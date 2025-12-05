<?php

namespace App\Http\Controllers;

use App\Models\Diary;
use App\Models\DiaryAnalysis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DiaryController extends Controller
{
    /**
     * 1. INDEX: Menampilkan daftar diary milik user.
     */
    public function index()
    {
        // Mengambil diary milik user yang login, diurutkan dari terbaru.
        // 'with("analysis")' digunakan agar hemat query database (Eager Loading).
        $diaries = Diary::with('analysis')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10); // Menampilkan 10 per halaman

        return view('diaries.index', compact('diaries'));
    }

    /**
     * 2. CREATE: Menampilkan form tambah diary.
     */
    public function create()
    {
        return view('diaries.create');
    }

    /**
     * 3. STORE: Simpan Diary Baru & Jalankan Analisis KA.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'content' => 'required|string|min:10', // Minimal 10 karakter agar AI bisa baca
            'is_private' => 'required|boolean',
        ]);

        // Simpan data dasar ke tabel 'diaries'
        $diary = Diary::create([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
            'is_private' => $request->input('is_private'),
        ]);

        // PROSES KA (Synchronous/Realtime)
        // Memanggil fungsi privat yang menjalankan 3 analisis sekaligus
        $this->processAnalysis($diary);

        return redirect()->route('diaries.show', $diary->id)
            ->with('success', 'Diary berhasil disimpan! Analisis Mood, Refleksi, dan Habit telah siap.');
    }

    /**
     * 4. SHOW: Menampilkan detail diary & hasil analisis.
     */
    public function show($id)
    {
        // Cari diary berdasarkan ID, pastikan milik user yang login (Keamanan)
        $diary = Diary::with('analysis')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('diaries.show', compact('diary'));
    }

    /**
     * 5. EDIT: Menampilkan form edit diary.
     */
    public function edit($id)
    {
        $diary = Diary::where('user_id', Auth::id())->findOrFail($id);
        return view('diaries.edit', compact('diary'));
    }

    /**
     * 6. UPDATE: Memperbarui isi diary & Analisis Ulang jika perlu.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|min:10',
            'is_private' => 'required|boolean',
        ]);

        $diary = Diary::where('user_id', Auth::id())->findOrFail($id);

        $oldContent = $diary->content;
        $newContent = $request->input('content');

        // Update data di database
        $diary->update([
            'content' => $newContent,
            'is_private' => $request->input('is_private'),
        ]);

        // LOGIKA PINTAR: Cek apakah isi konten berubah?
        if ($oldContent !== $newContent) {
            // Jika berubah, analisis lama sudah tidak valid. Hapus dulu.
            if ($diary->analysis) {
                $diary->analysis->delete();
            }

            // Jalankan ulang KA untuk konten baru
            $this->processAnalysis($diary);

            $message = 'Diary diperbarui. Analisis baru (Mood, Refleksi, Habit) telah dibuat!';
        } else {
            // Jika cuma ubah status privasi, tidak perlu panggil AI (Hemat kuota API)
            $message = 'Status privasi diary berhasil diperbarui.';
        }

        return redirect()->route('diaries.show', $diary->id)->with('success', $message);
    }

    /**
     * 7. DESTROY: Menghapus diary.
     */
    public function destroy($id)
    {
        $diary = Diary::where('user_id', Auth::id())->findOrFail($id);

        if ($diary->analysis) {
            $diary->analysis->delete();
        }

        $diary->delete();

        return redirect()->route('diaries.index')->with('success', 'Diary berhasil dihapus.');
    }

    // =========================================================================
    // PRIVATE METHODS (Logika Internal KA)
    // =========================================================================

    private function processAnalysis(Diary $diary)
    {
        try {
            $analysisData = $this->callKaApi($diary->content);

            DiaryAnalysis::create([
                'diary_id' => $diary->id,
                'mood' => $analysisData['mood'] ?? 'Netral',
                'mood_score' => isset($analysisData['mood_score']) ? (int) $analysisData['mood_score'] : 50,
                'reflection' => $analysisData['reflection'] ?? 'Tidak ada refleksi saat ini.',
                'habit_insight' => $analysisData['habit_insight'] ?? 'Belum ada pola kebiasaan terdeteksi.',
            ]);
        } catch (\Exception $e) {
            Log::error("KA Error pada Diary ID {$diary->id}: " . $e->getMessage());
        }
    }


    private function callKaApi(string $content): array
    {
        set_time_limit(60);

        $jsonSchema = [
            'mood' => 'string (Contoh: Bahagia, Cemas, Marah, Tenang, Sedih)',
            'mood_score' => 'integer (0-100)',
            'reflection' => 'string (Refleksi singkat dan hangat untuk user, maks 2 kalimat)',
            'habit_insight' => 'string (Analisis pola kebiasaan atau saran aksi nyata, maks 2 kalimat)',
        ];

        $apiKey = env('KOLOSAL_API_KEY');
        $baseUrl = env('KOLOSAL_BASE_URL', 'https://api.kolosal.ai/v1');
        $model = env('KOLOSAL_MODEL', 'Claude Sonnet 4.5');

        $response = Http::timeout(50)
            ->withHeaders(['Authorization' => 'Bearer ' . $apiKey])
            ->post($baseUrl . '/chat/completions', [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "Anda adalah Vibessense KA, asisten kesehatan mental. Tugas Anda:
                        1. Analisis Mood (Mood Analyzer).
                        2. Berikan Refleksi Harian (Daily Reflection).
                        3. Deteksi Kebiasaan/Saran (Habit Understanding).

                        Keluarkan hasil HANYA dalam format JSON valid sesuai skema ini: " . json_encode($jsonSchema),
                    ],
                    [
                        'role' => 'user',
                        'content' => "Ini cerita diary saya: \n\n" . $content
                    ]
                ],
                'temperature' => 0.5,
                'response_format' => ['type' => 'json_object'],
            ]);

        if ($response->failed()) {
            throw new \Exception('Gagal menghubungi KA: ' . $response->status());
        }

        $data = $response->json();
        $raw = $data['choices'][0]['message']['content'] ?? '';

        $cleanJson = preg_replace('/^```(?:json)?\s*/i', '', trim($raw));
        $cleanJson = preg_replace('/\s*```$/', '', $cleanJson);

        $decoded = json_decode($cleanJson, true);

        return $decoded ?? [];
    }
}
