<x-app-layout>
    @include('components.sidebar')

    <div class="ml-64 p-10 min-h-screen bg-gray-50">
        <div class="mb-8 border-b border-gray-200 pb-4">
            <h2 class="text-3xl font-black text-gray-900">Edit Pengguna</h2>
        </div>

        <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm max-w-2xl">
            <form action="{{ route('pengguna.update', $user->id_users) }}" method="POST">
                @csrf @method('PUT')
                
                <div class="mb-6">
                    <label class="block font-bold mb-2 text-sm">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ $user->nama }}" required class="w-full border-gray-300 rounded-lg p-3">
                </div>
                <div class="mb-6">
                    <label class="block font-bold mb-2 text-sm">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" required class="w-full border-gray-300 rounded-lg p-3">
                </div>
                
                <div class="mb-6 p-4 bg-yellow-50 rounded border border-yellow-200">
                    <label class="block font-bold mb-2 text-sm text-yellow-800">Ganti Password (Opsional)</label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password" class="w-full border-gray-300 rounded-lg p-3">
                </div>

                <div class="mb-6">
                    <label class="block font-bold mb-2 text-sm">Role</label>
                    <select name="role" class="w-full border-gray-300 rounded-lg p-3">
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>Petugas</option>
                    </select>
                </div>
                <div class="flex gap-4">
                    <button type="submit" class="bg-black text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-800">Update</button>
                    <a href="{{ route('pengguna.index') }}" class="bg-gray-100 text-gray-600 px-6 py-3 rounded-lg font-bold hover:bg-gray-200">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>