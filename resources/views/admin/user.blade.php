<x-app-layout>
    <div x-data="{ open: false, showModal: false, selected: null, user: { id: null, name: '', email: '', usertype: '' } }">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Halaman User') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 hover:text-black">dashboard </a><a class="text-gray-800 dark:text-gray-200 font-bold">/ Kelola Data User</a>
        </x-slot>
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class=" w-full bg-white dark:bg-gray-800">
                <thead class="text-gray-800 dark:text-gray-200 border-b border-gray-300 dark:border-gray-700">
                    <tr>
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Nama User</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Departemen</th>
                        <th class="px-4 py-2">Role</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 dark:text-gray-300">
                    @forelse ($users as $index => $user)
                    <tr>
                        <td class=" text-center px-4 py-2">{{ $loop->iteration }} .</td>
                        <td class=" text-left px-4 py-2">{{ $user->name }}</td>
                        <td class=" text-center px-4 py-2">{{ $user->email }}</td>
                        <td class=" text-center px-4 py-2">{{ $user->departemen->nama_departemen ?? '-' }}</td>
                        <td class=" text-center px-4 py-2">{{ $user->usertype }}</td>
                        <td class=" flex justify-center text-center px-4 py-2 gap-2">
                            <x-secondary-button @click="showModal = true; user.id = '{{ $user->id }}'; user.name = '{{ $user->name }}'; user.email = '{{ $user->email }}'; user.usertype = '{{ $user->usertype }}'; user.departemen_id = '{{ $user->departemen_id }}'">
                                Edit
                            </x-secondary-button>
                            <form action="{{ route('user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                @csrf
                                @method('DELETE')
                                <x-danger-button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Hapus
                                </x-danger-button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4">
                            <div class="w-full flex justify-center items-center text-sm text-gray-400">
                                Tidak ada user ditemukan.
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" @click.self="showModal = false">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-11/12 md:w-1/3">
                <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Edit User</h2>
                <form :action="`/admin/pengaturan-user/${user.id}`" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" x-model="user.id">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 dark:text-gray-200">Nama User</label>
                        <input type="text" name="name" id="name" x-model="user.name" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 dark:text-gray-200">Email</label>
                        <input type="email" name="email" id="email" x-model="user.email" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200">Departemen</label>
                        <select name="departemen_id"
                                x-model="user.departemen_id"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:text-gray-200">
                            <option value="">-- Pilih Departemen --</option>
                            @foreach ($departemens as $departemen)
                                <option value="{{ $departemen->id }}">
                                    {{ $departemen->nama_departemen }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Role
                        </label>
                        <select name="usertype"
                                x-model="user.usertype"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                                    focus:border-indigo-500 focus:ring focus:ring-indigo-200
                                    dark:bg-gray-800 dark:text-gray-200"
                                required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="manager">Manager</option>
                            <option value="asisten manager">Asisten Manager</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" @click="showModal = false" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">Batal</button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>