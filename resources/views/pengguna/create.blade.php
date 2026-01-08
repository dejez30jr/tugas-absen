<x-app-layout>
    @include('components.sidebar')

    <div class="ml-64 p-10 min-h-screen bg-gray-50">
        <div class="mb-8 border-b border-gray-200 pb-4">
            <h2 class="text-3xl font-black text-gray-900">Tambah Pengguna Baru</h2>
        </div>

        <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm max-w-2xl">
            <form action="{{ route('pengguna.store') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block font-bold mb-2 text-sm">Nama Lengkap</label>
                    <input type="text" name="nama" required class="w-full border-gray-300 rounded-lg p-3">
                </div>
                <div class="mb-6">
                    <label class="block font-bold mb-2 text-sm">Email (Untuk Login)</label>
                    <input type="email" name="email" required class="w-full border-gray-300 rounded-lg p-3">
                </div>
                <div class="mb-6">
                    <label class="block font-bold mb-2 text-sm">Password</label>
                    <input type="password" name="password" required class="w-full border-gray-300 rounded-lg p-3">
                </div>
                <div class="mb-6">
                    <label class="block font-bold mb-2 text-sm">Role</label>
                    <select name="role" class="w-full border-gray-300 rounded-lg p-3">
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                    </select>
                </div>
                <div class="flex gap-4">
                    <button type="submit" class="bg-black text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-800">Simpan</button>
                    <a href="{{ route('pengguna.index') }}" class="bg-gray-100 text-gray-600 px-6 py-3 rounded-lg font-bold hover:bg-gray-200">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>