<x-app-layout>
    @include('components.sidebar')

    <div class="ml-64 p-10 min-h-screen bg-gray-50">
        
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-3xl font-black text-gray-900 tracking-tight">Admin Pengguna</h2>
                <p class="text-gray-500 mt-1">Kelola akun yang bisa mengakses sistem.</p>
            </div>
            <a href="{{ route('pengguna.create') }}" class="bg-black text-white px-6 py-3 rounded-lg font-bold text-sm hover:bg-gray-800 shadow-lg">
                + Tambah Admin
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded font-bold">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase">Nama Lengkap</th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase">Email Login</th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase">Role</th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($users as $u)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 font-bold text-gray-900">{{ $u->nama }}</td>
                        <td class="p-4 text-gray-600">{{ $u->email }}</td>
                        <td class="p-4">
                            <span class="bg-gray-100 text-gray-800 text-xs font-bold px-2 py-1 rounded uppercase">{{ $u->role }}</span>
                        </td>
                        <td class="p-4 text-center flex justify-center gap-2">
                            <a href="{{ route('pengguna.edit', $u->id_users) }}" class="bg-blue-50 text-blue-600 px-3 py-1 rounded text-xs font-bold hover:bg-blue-100">Edit</a>
                            
                            @if(auth()->user()->id_users != $u->id_users)
                                <form action="{{ route('pengguna.destroy', $u->id_users) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?');">
                                    @csrf @method('DELETE')
                                    <button class="bg-red-50 text-red-600 px-3 py-1 rounded text-xs font-bold hover:bg-red-100">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>