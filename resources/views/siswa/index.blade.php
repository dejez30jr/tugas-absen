<x-app-layout>
    @include('components.sidebar')

    <div class="ml-64 p-10 min-h-screen bg-gray-50">
        
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-3xl font-black text-gray-900 tracking-tight">Data Siswa</h2>
                <p class="text-gray-500 mt-1">Kelola data siswa yang terdaftar.</p>
            </div>
            <a href="{{ route('siswa.create') }}" class="bg-black text-white px-6 py-3 rounded-lg font-bold text-sm hover:bg-gray-800 transition shadow-lg">
                + Tambah Siswa
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded font-bold">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 mb-6">
            <form method="GET" action="{{ route('siswa.index') }}" class="flex flex-wrap justify-between items-center gap-4">
                
                <div class="flex items-center gap-4">
                    
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-gray-500 uppercase">Show:</span>
                        <select name="limit" onchange="this.form.submit()" class="border-gray-300 rounded text-sm bg-gray-50 focus:ring-black focus:border-black">
                            <option value="10" {{ $limit == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ $limit == 20 ? 'selected' : '' }}>20</option>
                            <option value="50" {{ $limit == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $limit == 100 ? 'selected' : '' }}>100</option>
                            <option value="200" {{ $limit == 200 ? 'selected' : '' }}>200</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-gray-500 uppercase">Kelas:</span>
                        <select name="kelas" onchange="this.form.submit()" class="border-gray-300 rounded text-sm focus:ring-black focus:border-black cursor-pointer bg-gray-50 min-w-[120px]">
                            <option value="">Semua</option>
                            <option value="X RPL" {{ $kelasSelected == 'X RPL' ? 'selected' : '' }}>X RPL</option>
                            <option value="XI RPL" {{ $kelasSelected == 'XI RPL' ? 'selected' : '' }}>XI RPL</option>
                            <option value="XII RPL" {{ $kelasSelected == 'XII RPL' ? 'selected' : '' }}>XII RPL</option>
                            <option value="XII AK" {{ $kelasSelected == 'XII AK' ? 'selected' : '' }}>XII AK</option>
                        </select>
                    </div>

                </div>

                <div class="relative">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari Nama / NIS..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm w-64 focus:ring-black focus:border-black">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

            </form>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase">NIS</th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase">Nama Lengkap</th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase">Kelas</th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase">L/P</th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($dataSiswa as $s)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 font-bold text-gray-700">{{ $s->nis }}</td>
                        <td class="p-4 font-medium text-gray-900">{{ $s->nama }}</td>
                        <td class="p-4">
                            <span class="bg-gray-100 text-gray-600 text-xs font-bold px-2 py-1 rounded border border-gray-200">
                                {{ $s->id_kelas }}
                            </span>
                        </td>
                        <td class="p-4 text-gray-600">{{ $s->gender }}</td>
                        <td class="p-4 text-center flex justify-center gap-2">
                            <a href="{{ route('siswa.edit', $s->id_siswa) }}" class="bg-blue-50 text-blue-600 px-3 py-1 rounded text-xs font-bold hover:bg-blue-100">Edit</a>
                            @if(auth()->user()->role == 'admin')
            <form action="{{ route('siswa.destroy', $s->id_siswa) }}" method="POST" onsubmit="return confirm('Yakin hapus?');">
                @csrf @method('DELETE')
                <button class="bg-red-50 text-red-600 px-3 py-1 rounded text-xs font-bold hover:bg-red-100">Hapus</button>
            </form>
        @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-400">
                            Data siswa tidak ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $dataSiswa->links() }}
        </div>

    </div>
</x-app-layout>