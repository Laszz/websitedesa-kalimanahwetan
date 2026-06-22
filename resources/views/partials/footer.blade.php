<footer class="bg-gray-900 text-white py-4 mt-auto">
    <div class="container mx-auto px-4 flex flex-col sm:flex-row items-center justify-between">

        {{-- Kiri: Nama Desa --}}
        <div class="text-sm font-medium text-gray-300 mb-2 sm:mb-0 text-center sm:text-left">
            Desa Kalimanah Wetan, Kecamatan Kalimanah, Kabupaten Purbalingga
        </div>

        {{-- Kanan: Icon Sosial Media --}}
        <div class="flex items-center space-x-4 text-lg">
            <a href="https://www.youtube.com/@pemdeskalwet" target="_blank" class="hover:text-red-500 transition">
                <i class="fab fa-youtube"></i>
            </a>
            <a href="https://www.instagram.com/pemdeskalwet?igsh=b2dqZmFtenZsZXRp" target="_blank" class="hover:text-pink-500 transition">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="https://vt.tiktok.com/ZSA1D9sb6/" target="_blank" class="hover:text-gray-400 transition">
                <i class="fab fa-tiktok"></i>
            </a>
            <a href="https://wa.me/6281393009585" target="_blank" class="hover:text-green-500 transition">
                <i class="fab fa-whatsapp"></i>
            </a>
        </div>
    </div>

    {{-- Copyright --}}
    <div class="text-center text-gray-500 text-xs mt-3">
        &copy; {{ date('Y') }} {{ config('Desa Kalimanah Wetan') }}. All rights reserved.
    </div>
</footer>

{{-- Tambahkan di layout utama <head> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
