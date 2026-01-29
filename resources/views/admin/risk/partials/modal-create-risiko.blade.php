<div x-show="showModal"
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    @click.self="showModal = false">

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-2xl p-6">

        <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">
            Tambah Sebab Risiko
        </h2>

        <form action="{{ route('risk.detail.store', $sasaran) }}" method="POST">  
            @csrf

            <!-- SASARAN -->
            <input type="hidden" name="sasaran_id" value="{{ $sasaran->id }}">

            <!-- KATEGORI -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                    Kategori Risiko
                </label>
                <select name="kategori_id"                                
                        class="mt-1 block w-full rounded-md border-gray-300
                            dark:bg-gray-700 dark:text-gray-200"
                        required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}">
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- NAMA SEBAB -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                    Sebab Risiko
                </label>
                <textarea name="nama_sebab"
                        rows="2"
                        class="mt-1 block w-full rounded-md border-gray-300
                                dark:bg-gray-700 dark:text-gray-200"
                        required></textarea>
            </div>

            <!-- PENGENDALIAN INTERNAL -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                    Pengendalian Internal
                </label>
                <textarea name="pengendalian_internal"
                        rows="2"
                        class="mt-1 block w-full rounded-md border-gray-300
                                dark:bg-gray-700 dark:text-gray-200"
                        required></textarea>
            </div>

            <!-- REFERENSI -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                    Referensi Pengendalian
                </label>
                <input type="text"
                    name="referensi_pengendalian"
                    class="mt-1 block w-full rounded-md border-gray-300
                            dark:bg-gray-700 dark:text-gray-200"
                    required>
            </div>

            <!-- EFEKTIFITAS -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                    Efektifitas Pengendalian
                </label>
                <select name="efektifitas_pengendalian"
                        class="mt-1 block w-full rounded-md border-gray-300
                            dark:bg-gray-700 dark:text-gray-200"
                        required>
                    <option value="">-- Pilih --</option>
                    <option value="Efektif">Efektif</option>
                    <option value="Kurang Efektif">Kurang Efektif</option>
                    <option value="Tidak Efektif">Tidak Efektif</option>
                </select>
            </div>

            <!-- DAMPAK & PROBABILITAS -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                        Dampak
                    </label>
                    <input type="number"
                        name="dampak"
                        min="1" max="5"
                        class="mt-1 block w-full rounded-md border-gray-300
                                dark:bg-gray-700 dark:text-gray-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                        Probabilitas
                    </label>
                    <input type="number"
                        name="probabilitas"
                        min="1" max="5"
                        class="mt-1 block w-full rounded-md border-gray-300
                                dark:bg-gray-700 dark:text-gray-200">
                </div>
            </div>

            <!-- ACTION -->
            <div class="mt-6 flex justify-end gap-2">
                <button type="button"
                        @click="showModal = false"
                        class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">
                    Batal
                </button>

                <button type="submit"
                        class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white">
                    Simpan
                </button>
            </div>    
        </form>
    </div>
</div>