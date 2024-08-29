<!-- Modal -->
<div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
        <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Apakah Anda yakin?</h2>
        <p class="mb-6 text-gray-700 dark:text-gray-300">Anda tidak dapat mengembalikan data yang telah dihapus.</p>
        <div class="flex justify-end">
            <button type="button" onclick="toggleModal('deleteModal')" class="px-4 py-2 mr-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                Tidak
            </button>
            <button type="button" id="confirmDeleteButton" class="px-4 py-2 text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<!-- Form Delete -->
<form id="deleteForm" action="" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>