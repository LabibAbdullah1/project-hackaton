<?php

namespace App\Jobs;

use App\Models\Diary;
use App\Models\DiaryAnalysis;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AnalyzeDiaryMoodJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $diaryId;

    public function __construct(int $diaryId)
    {
        $this->diaryId = $diaryId;
    }


    public function handle(): void
    {
        $diary = Diary::find($this->diaryId);

        if (!$diary) {
            Log::error("Diary ID {$this->diaryId} tidak ditemukan.");
            return;
        }

        try {
            $analysisData = $this->callKaApi($diary->content);
            DiaryAnalysis::create([
                'diary_id' => $diary->id,
                'mood' => $analysisData['mood'] ?? 'Unknown',
                'mood_score' => $analysisData['mood_score'] ?? 50,
                'reflection' => $analysisData['reflection_text'] ?? null,
                'habit_insight' => $analysisData['habit_insight'] ?? null,
            ]);

            Log::info("Analisis Diary ID {$diary->id} berhasil disimpan.");
        } catch (\Exception $e) {
            Log::error("Gagal menganalisis Diary ID {$diary->id}: " . $e->getMessage());
            $this->release(60);
        }
    }

    protected function callKaApi(string $content): array
    {
        $jsonSchema = [
            'mood' => 'string (e.g., Happy, Stressed, Anxious, Calm)',
            'mood_score' => 'integer (0-100)',
            'reflection_text' => 'string (A simple reflection based on the diary)',
            'habit_insight' => 'string (An actionable insight or suggestion about habit)',
        ];

        $response = Http::timeout(45) 
            ->withHeaders([
                'Authorization' => 'Bearer ' . env('KOLOSAL_API_KEY'),
            ])
            ->post(env('KOLOSAL_BASE_URL') . '/chat/completions', [
                'model' => env('KOLOSAL_MODEL', 'Claude Sonnet 4.5'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "Anda adalah Vibessense KA. Tugas Anda adalah menganalisis mood dan kebiasaan dari teks diary pengguna. Wajib kembalikan output dalam format JSON berikut: " . json_encode($jsonSchema),
                    ],
                    [
                        'role' => 'user',
                        'content' => "Diary: " . $content
                    ]
                ],
                'temperature' => 0.5,
                'response_format' => ['type' => 'json_object'],
            ]);

        if ($response->failed()) 
        {
            $response->throw();
        }
        
        $data = $response->json();

        $jsonString = $data['choices'][0]['message']['content'] ?? '';
        $analysisResult = json_decode($jsonString, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Gagal memecahkan kode respons JSON dari KA.");
        }

        return $analysisResult;
    }
}
