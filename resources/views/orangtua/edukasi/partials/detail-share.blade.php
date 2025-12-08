<div class="bg-gray-50 p-8 border-t border-gray-200">
    <div class="flex flex-col md:flex-row items-center justify-between">
        <div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Artikel ini bermanfaat?</h3>
            <p class="text-gray-600 text-sm">Bagikan kepada keluarga dan teman Anda</p>
        </div>

        <div class="flex items-center space-x-3 mt-4 md:mt-0">
            <button onclick="shareWhatsApp()" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                <i class="fab fa-whatsapp mr-2"></i>WhatsApp
            </button>
            <button onclick="shareFacebook()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fab fa-facebook mr-2"></i>Facebook
            </button>
            <button onclick="copyLink()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-link mr-2"></i>Salin Link
            </button>
        </div>
    </div>
</div>