<div x-show="editPerlakuanId === {{ $perlakuan->id }}"
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    @click.self="editPerlakuanId = null">

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-xl p-6">

        <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">
            Edit Perlakuan Risiko
        </h2>

        <form method="POST"
            action="{{ route('risk.perlakuan-risiko.update', $item->id) }}">
            @csrf
            @method('PUT')

            <!-- ID PERLAKUAN -->
            <input type="hidden" name="perlakuan_risiko_id" value="{{ $perlakuan->id }}">

            <!-- DESKRIPSI -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                    Perlakuan Risiko
                </label>
                <textarea name="perlakuan_risiko" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300
                        dark:bg-gray-700 dark:text-gray-200"
                        required>{{ $perlakuan->perlakuan_risiko }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                    Periode
                </label>
                <select name="periode"
                        class="mt-1 block w-full rounded-md border-gray-300
                            dark:bg-gray-700 dark:text-gray-200"
                        required>
                    <option value="Bulanan" @selected($perlakuan->periode == 'Bulanan')>Bulanan</option>
                    <option value="Triwulan" @selected($perlakuan->periode == 'Triwulan')>Triwulan</option>
                    <option value="Semester" @selected($perlakuan->periode == 'Semester')>Semester</option>
                    <option value="Tahunan" @selected($perlakuan->periode == 'Tahunan')>Tahunan</option>
                </select>
            </div>

            <!-- DAMPAK & PROBABILITAS -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                        Dampak
                    </label>
                    <input type="number" name="dampak" min="1" max="5"
                        value="{{ $perlakuan->dampak }}"
                        class="mt-1 block w-full rounded-md border-gray-300
                        dark:bg-gray-700 dark:text-gray-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                        Probabilitas
                    </label>
                    <input type="number" name="probabilitas" min="1" max="5"
                        value="{{ $perlakuan->probabilitas }}"
                        class="mt-1 block w-full rounded-md border-gray-300
                        dark:bg-gray-700 dark:text-gray-200">
                </div>
            </div>

            <!-- ACTION -->
            <div class="mt-6 flex justify-end gap-2">
                <button type="button"
                        @click="editPerlakuanId = null"
                        class="px-4 py-2 rounded bg-gray-300">
                    Batal
                </button>

                <button type="submit"
                        class="px-4 py-2 rounded bg-blue-600 text-white">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>