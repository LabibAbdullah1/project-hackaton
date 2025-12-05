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

    public function index()
    {
        $diaries = Diary::with('analysis')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('diaries.index', compact('diaries'));
    }


    public function create()
    {
        return view('diaries.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'content' => 'required|string|min:10',
            'is_private' => 'required|boolean',
        ]);

        // 2. Simpan Data Diary ke Database
        $diary = Diary::create([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
            'is_private' => $request->input('is_private'),
        ]);

        // 3. Proses KA (Dengan Error Handling Halus)
        try {
            $this->processAnalysis($diary);
            $message = 'Diary berhasil disimpan dan Analisis KA selesai!';
            $status = 'success';
        } catch (\Exception $e) {
            Log::error("KA Error pada Diary ID {$diary->id}: " . $e->getMessage());

            $message = 'Diary berhasil disimpan, namun Analisis KA sedang tidak tersedia saat ini.';
            $status = 'warning';
        }

        // 4. Redirect ke halaman detail atau index
        return redirect()->route('diaries.index')
            ->with($status, $message);
    }

    public function show($id)
    {
        $diary = Diary::with('analysis')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('diaries.show', compact('diary'));
    }

    public function edit($id)
    {
        $diary = Diary::where('user_id', Auth::id())->findOrFail($id);
        return view('diaries.edit', compact('diary'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|min:10',
            'is_private' => 'required|boolean',
        ]);

        $diary = Diary::where('user_id', Auth::id())->findOrFail($id);

        $contentChanged = $diary->content !== $request->input('content');

        $diary->update([
            'content' => $request->input('content'),
            'is_private' => $request->input('is_private'),
        ]);

        $message = 'Diary berhasil diperbarui.';

        if ($contentChanged) {
            try {
                if ($diary->analysis) {
                    $diary->analysis->delete();
                }
                $this->processAnalysis($diary);
                $message .= ' Analisis KA telah diperbarui sesuai cerita baru.';
            } catch (\Exception $e) {
                Log::error("Update KA Error ID {$diary->id}: " . $e->getMessage());
                $message .= ' Namun gagal memperbarui analisis KA.';
            }
        }

        return redirect()->route('diaries.index')->with('success', $message);
    }

    /**
     * Hapus diary.
     */
    public function destroy($id)
    {
        $diary = Diary::where('user_id', Auth::id())->findOrFail($id);
        $diary->delete();
        return redirect()->route('diaries.index')->with('success', 'Diary berhasil dihapus.');
    }

    private function processAnalysis(Diary $diary)
    {
        $analysisData = $this->callKaApi($diary->content);

        DiaryAnalysis::create([
            'diary_id' => $diary->id,
            'mood' => $analysisData['mood'] ?? 'Netral',
            'mood_score' => isset($analysisData['mood_score']) ? (int) $analysisData['mood_score'] : 50,
            'reflection' => $analysisData['reflection'] ?? 'Tidak ada refleksi.',
            'habit_insight' => $analysisData['habit_insight'] ?? 'Belum ada habit.',
        ]);
    }

    private function callKaApi(string $content): array
    {
        set_time_limit(60);

        $apiKey = env('KOLOSAL_API_KEY');
        $baseUrl = env('KOLOSAL_BASE_URL');
        $model = env('KOLOSAL_MODEL');

        if (!$apiKey) {
            throw new \Exception("API Key belum disetting di server.");
        }

        $jsonSchema = [
            'mood' => 'string (Singkat: Bahagia/Sedih/Cemas)',
            'mood_score' => 'integer (0-100)',
            'reflection' => 'string (Refleksi hangat maks 2 kalimat)',
            'habit_insight' => 'string (Saran aksi maks 2 kalimat)',
        ];

        // Kirim Request
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ])
        ->timeout(45)
        ->post($baseUrl, [
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => "Output JSON valid: " . json_encode($jsonSchema)],
                ['role' => 'user', 'content' => $content]
            ],
            'temperature' => 0.5,
            'response_format' => ['type' => 'json_object'],
        ]);

        if ($response->failed()) {
            throw new \Exception("Gagal KA: " . $response->status() . " " . $response->body());
        }

        $data = $response->json();

        $raw = $data['choices'][0]['message']['content'] ?? '{}';
        $cleanJson = preg_replace('/^```(?:json)?\s*/i', '', trim($raw));
        $cleanJson = preg_replace('/\s*```$/', '', $cleanJson);

        $decoded = json_decode($cleanJson, true);

        if (!$decoded) {
            throw new \Exception("Format respon KA tidak valid JSON.");
        }

        return $decoded;
    }
}
