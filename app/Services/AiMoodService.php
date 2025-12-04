<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AIMoodService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = env('KOLOSAL_BASE_URL', 'https://api.kolosal.ai/v1');
        $this->apiKey = env('KOLOSAL_API_KEY');
    }

    /**
     * analyzeMessage
     * - $text: pesan user
     * - $preference: user preference (string) for motivation tone
     *
     * returns array with keys:
     *  - mood_label
     *  - confidence
     *  - description
     *  - motivation
     *  - raw (full api response array)
     */
    public function analyzeMessage(string $text, string $preference = 'general'): array
    {
        // Build prompt: minta output JSON terstruktur
        $prompt = "Analisis pesan pengguna berikut dan tentukan mood dari daftar: Senang, Sedih, Marah, Cemas, Netral.
Gunakan preferensi motivasi: {$preference}.
Kembalikan hasil dalam format JSON persis seperti ini:
{\"mood\":\"<mood_label>\",\"score\":<float_0_1>,\"desc\":\"<deskripsi singkat>\",\"motivation\":\"<motivasi singkat sesuai preference>\"}
Pesan: \"{$text}\"";

        $payload = [
            "model" => "Claude Sonnet 4.5",
            "messages" => [
                ["role" => "user", "content" => $prompt]
            ],
            // tambahan opsi model sesuai API Kolosal (jika diperlukan)
        ];

        $response = Http::withToken($this->apiKey)
            ->acceptJson()
            ->post($this->baseUrl . '/chat/completions', $payload);

        // error handling dasar
        if (! $response->successful()) {
            // fallback: return neutral
            return [
                'mood_label' => 'Netral',
                'confidence' => 0.0,
                'description' => 'AI service error',
                'motivation' => "Maaf, sistem AI sedang tidak tersedia sekarang.",
                'raw' => $response->body(),
            ];
        }

        $data = $response->json();

        // parse AI reply content (try to decode string JSON inside response)
        $content = null;
        if (isset($data['choices'][0]['message']['content'])) {
            $content = $data['choices'][0]['message']['content'];
        } elseif (isset($data['choices'][0]['text'])) {
            $content = $data['choices'][0]['text'];
        }

        // try decode JSON from content
        $decoded = null;
        if ($content) {
            // strip codeblocks and whitespace
            $trim = trim($content);
            // sometimes AI returns wrapped in ```json ... ```
            $trim = preg_replace('/^```(?:json)?\s*/i', '', $trim);
            $trim = preg_replace('/\s*```$/', '', $trim);
            $decoded = json_decode($trim, true);
        }

        if (is_array($decoded)) {
            return [
                'mood_label' => $decoded['mood'] ?? 'Netral',
                'confidence' => isset($decoded['score']) ? floatval($decoded['score']) : null,
                'description' => $decoded['desc'] ?? null,
                'motivation' => $decoded['motivation'] ?? null,
                'raw' => $data
            ];
        }

        // fallback parsing (if AI returns free text)
        // attempt to extract mood word by keyword
        $lower = strtolower($content ?? '');
        $mood = 'Netral';
        foreach (['senang', 'sedih', 'marah', 'cemas', 'netral'] as $keyword) {
            if (strpos($lower, $keyword) !== false) {
                $mood = ucfirst($keyword);
                break;
            }
        }

        return [
            'mood_label' => $mood,
            'confidence' => null,
            'description' => $content,
            'motivation' => null,
            'raw' => $data
        ];
    }
}
