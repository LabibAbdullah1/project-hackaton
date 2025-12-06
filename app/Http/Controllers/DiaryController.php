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

        return view('user.diary.index', compact('diaries'));
    }


    public function create()
    {
        return view('user.diary.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'content' => 'required|string|min:10',
    ]);

    // Simpan diary
    $diary = Diary::create([
        'user_id' => Auth::id(),
        'content' => $request->input('content'),
    ]);

    try {
        // Panggil API KA
        $analysisData = $this->callKaApi($diary->content);

        // Simpan analysis
        $analysis = DiaryAnalysis::create([
            'diary_id' => $diary->id,
            'mood' => $analysisData['mood'] ?? 'Netral',
            'mood_score' => $analysisData['mood_score'] ?? 50,
            'reflection' => $analysisData['reflection'] ?? 'Tidak ada refleksi.',
            'habit_insight' => $analysisData['habit_insight'] ?? 'Belum ada habit.',
        ]);

        Log::info('=== DIARY ANALYSIS DEBUG ===');
        Log::info('Diary ID: ' . $diary->id);
        Log::info('Analysis ID: ' . $analysis->id);
        Log::info('Reflection: ' . $analysis->reflection);
        Log::info('Habit: ' . $analysis->habit_insight);
        
        return view('user.diary.create', [
            'diary' => $diary,
            'analysis' => $analysis,
            'success' => true
        ]);

    } catch (\Exception $e) {
        Log::error("Analisis AI error: " . $e->getMessage());
        Log::error($e->getTraceAsString());

        return view('user.diary.create', [
            'diary' => $diary,
            'error' => 'Diary tersimpan, tapi analisis AI gagal: ' . $e->getMessage()
        ]);
    }
}






    public function show($id)
    {
        $diary = Diary::with('analysis')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('user.diary.show', compact('diary'));
    }

    public function edit($id)
    {
        $diary = Diary::where('user_id', Auth::id())->findOrFail($id);
        return view('user.diary.edit', compact('diary'));
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

        return redirect()->route('user.diary.show', $diary->id)->with('success', $message);
    }

    /**
     * Hapus diary.
     */
    public function destroy($id)
    {
        $diary = Diary::where('user_id', Auth::id())->findOrFail($id);
        $diary->delete();

        return redirect()->route('user.diary.index')->with('success', 'Diary berhasil dihapus.');
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
            'mood' => 'string (Singkat: Senang/Sedih/Cemas/Lelah/Marah/Tenang/Stres)',
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
