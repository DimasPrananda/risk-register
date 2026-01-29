<div x-show="addPerlakuanId === {{ $item->id }}"
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    @click.self="addPerlakuanId = null">

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-xl p-6">

        <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">
            Tambah Perlakuan Risiko
        </h2>

        <form action="{{ route('risk.perlakuan-risiko.store', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- sebab risiko -->
            <input type="hidden" name="sebab_risiko_id" value="{{ $item->id }}">

            <!-- PERLAKUAN -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                    Perlakuan Risiko
                </label>
                <textarea name="perlakuan_risiko" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300
                    dark:bg-gray-700 dark:text-gray-200" required></textarea>
            </div>

            <select name="periode"
                class="mt-1 block w-full rounded-md border-gray-300
                    dark:bg-gray-700 dark:text-gray-200"
                required>
                <option value="">-- Pilih Periode --</option>
                <option value="Bulanan">Bulanan</option>
                <option value="Triwulan">Triwulan</option>
                <option value="Semester">Semester</option>
                <option value="Tahunan">Tahunan</option>
            </select>

            <!-- DAMPAK & PROBABILITAS -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                        Dampak
                    </label>
                    <input type="number" name="dampak" min="1" max="5"
                        class="mt-1 block w-full rounded-md border-gray-300
                        dark:bg-gray-700 dark:text-gray-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                        Probabilitas
                    </label>
                    <input type="number" name="probabilitas" min="1" max="5"
                        class="mt-1 block w-full rounded-md border-gray-300
                        dark:bg-gray-700 dark:text-gray-200">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                        Dokumen Pendukung (PDF, max 5MB)
                    </label>

                    <input type="file"
                        name="dokumen_pdf"
                        accept="application/pdf"
                        class="mt-1 block w-full text-sm text-gray-700
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:bg-blue-600 file:text-white
                            hover:file:bg-blue-700
                            dark:text-gray-200">
                </div>
            </div>

            <!-- ACTION -->
            <div class="mt-6 flex justify-end gap-2">
                <button type="button"
                        @click="addPerlakuanId = null"
                        class="px-4 py-2 rounded bg-gray-300">
                    Batal
                </button>

                <button type="submit"
                        class="px-4 py-2 rounded bg-green-600 text-white">
                    Simpan
                </button>
            </div>

        </form>
    </div>
</div>   