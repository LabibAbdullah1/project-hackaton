@extends('layouts.app')

@section('content')
<section class="py-28 bg-gradient-to-b from-white to-purple-50">
    <div class="max-w-6xl mx-auto px-6">

        <!-- Heading -->
        <div class="text-center mb-14">
            <h2 class="text-3xl md:text-5xl font-extrabold text-gray-800">
                Demo Diary <span class="text-purple-600">VibeSense AI</span>
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto mt-4 text-lg">
                Lihat bagaimana AI membaca emosimu, memberi respon empati, 
                dan membantu memahami dirimu lebih dalam — secara aman & privat.
            </p>
        </div>

        <!-- Card Demo -->
        <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-xl border border-purple-100 p-10">

            <!-- Input Example -->
            <h3 class="text-xl font-semibold text-gray-800 mb-3">Contoh Diary</h3>

            <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 text-gray-700 mb-10 leading-relaxed">
                "Hari ini aku agak kewalahan. Banyak yang harus kupikirkan dan rasanya capek banget.
                Aku cuma ingin ada yang mengerti perasaanku."
            </div>

            <!-- AI Response -->
            <h3 class="text-xl font-semibold text-gray-800 mb-3">Respon Empati dari AI</h3>

            <div class="bg-purple-50 border border-purple-200 rounded-xl p-6 text-gray-800 mb-10">
                <p class="font-medium text-purple-700 mb-2">💬 Empathy Response:</p>
                <p>
                    Kamu sudah menjalani hari yang berat, dan itu wajar membuatmu merasa lelah.
                    Tidak apa-apa untuk berhenti sejenak dan mengakui bahwa kamu butuh ruang.
                    Kamu tidak sendirian — aku di sini untuk mendengarkan kamu.
                </p>
            </div>

            <!-- Mood Analysis -->
            <h3 class="text-xl font-semibold text-gray-800 mb-3">Analisis Mood</h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-12">
                <div class="text-center p-5 bg-white border border-gray-200 rounded-xl shadow-sm">
                    <p class="text-gray-500 text-sm">Emosi Utama</p>
                    <p class="text-purple-600 font-bold text-3xl mt-1">Sedih</p>
                </div>

                <div class="text-center p-5 bg-white border border-gray-200 rounded-xl shadow-sm">
                    <p class="text-gray-500 text-sm">Emosi Tambahan</p>
                    <p class="text-purple-600 font-bold text-3xl mt-1">Lelah</p>
                </div>

                <div class="text-center p-5 bg-white border border-gray-200 rounded-xl shadow-sm">
                    <p class="text-gray-500 text-sm">Konteks</p>
                    <p class="text-purple-600 font-bold text-xl mt-1">Stres Harian</p>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('register') }}"
                    class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-8 py-3 rounded-full font-semibold shadow-md hover:shadow-lg transition">
                    Coba Sekarang
                </a>
            </div>

        </div>

        <!-- Note -->
        <p class="mt-10 text-center text-gray-500 text-sm">
            *Demo menampilkan contoh UI, bukan data pengguna asli.
        </p>

    </div>
</section>
@endsection
