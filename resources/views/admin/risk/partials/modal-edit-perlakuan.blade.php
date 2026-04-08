<div x-show="editPerlakuanId === {{ $perlakuan->id }}"
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    @click.self="editPerlakuanId = null">

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-11/12 md:w-1/3 h-[85vh] flex flex-col">

        <h2 class="px-6 pt-6 text-lg font-bold mb-4 text-gray-800 dark:text-white">
            Edit Pengendalian Risiko
        </h2>

        <div class=" flex-1 overflow-y-auto p-6">
            <form method="POST"
                action="{{ route('risk.perlakuan-risiko.update', $item->id) }}" enctype="multipart/form-data">
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
                        Tanggal Pelaksanaan
                    </label>
                    <textarea name="tanggal_pelaksanaan"
                        class="mt-1 block w-full rounded-md border-gray-300
                            dark:bg-gray-700 dark:text-gray-200"
                            required>{{ $perlakuan->tanggal_pelaksanaan }}</textarea>
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

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                        Output Target
                    </label>
                    <textarea type="text" name="output_target"
                        class="mt-1 block w-full rounded-md border-gray-300
                        dark:bg-gray-700 dark:text-gray-200"
                        required>{{ $perlakuan->output_target }}</textarea>
                </div>
                
                <div class="grid grid-cols-2 gap-4">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            timeline Periode
                        </label>
                        <textarea name="timeline_periode"
                            class="mt-1 block w-full rounded-md border-gray-300
                            dark:bg-gray-700 dark:text-gray-200"
                            required>{{ $perlakuan->timeline_periode }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            timeline Target
                        </label>
                        <textarea name="timeline_target"
                            class="mt-1 block w-full rounded-md border-gray-300
                            dark:bg-gray-700 dark:text-gray-200"
                            required>{{ $perlakuan->timeline_target }}</textarea>
                    </div>
                </div>

                <div class=" mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                        Biaya Target
                    </label>
                    <textarea name="biaya_target"
                        class="mt-1 block w-full rounded-md border-gray-300
                        dark:bg-gray-700 dark:text-gray-200"
                        required>{{ $perlakuan->biaya_target }}</textarea>
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

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Biaya Mitigasi
                        </label>
                        <input type="number" name="biaya_mitigasi" min="0"
                            value="{{ $perlakuan->biaya_mitigasi }}"
                            class="mt-1 block w-full rounded-md border-gray-300
                            dark:bg-gray-700 dark:text-gray-200">
                    </div>

                    <div>
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
                                hover:file:bg-blue-700"/>
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
</div>