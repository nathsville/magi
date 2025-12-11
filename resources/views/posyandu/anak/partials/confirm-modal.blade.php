<div id="confirmModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform scale-95 transition-transform duration-300">
        <div class="p-6">
            <div class="flex items-center justify-center mb-4">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-orange-600 text-3xl"></i>
                </div>
            </div>
            <h3 class="text-xl font-bold text-gray-800 text-center mb-2" id="modalTitle">Konfirmasi</h3>
            <p class="text-gray-600 text-center mb-6" id="modalMessage">Apakah Anda yakin?</p>
            <div class="flex space-x-3">
                <button onclick="closeModal()" class="flex-1 px-4 py-3 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 transition">
                    Batal
                </button>
                <button onclick="confirmAction()" class="flex-1 px-4 py-3 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition">
                    Ya, Lanjutkan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let confirmCallback = null;

function showModal(title, message, callback) {
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalMessage').textContent = message;
    confirmCallback = callback;
    
    const modal = document.getElementById('confirmModal');
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.querySelector('.bg-white').classList.remove('scale-95');
        modal.querySelector('.bg-white').classList.add('scale-100');
    }, 10);
}

function closeModal() {
    const modal = document.getElementById('confirmModal');
    modal.querySelector('.bg-white').classList.remove('scale-100');
    modal.querySelector('.bg-white').classList.add('scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
        confirmCallback = null;
    }, 300);
}

function confirmAction() {
    if (confirmCallback) {
        confirmCallback();
    }
    closeModal();
}
</script>