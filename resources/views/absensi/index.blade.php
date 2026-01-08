<x-app-layout>
    @include('components.sidebar')

    <div class="ml-64 p-10 min-h-screen bg-gray-50">
        
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-3xl font-black text-gray-900 tracking-tight">Data Absensi</h2>
                <p class="text-gray-500 mt-1">Kelola riwayat kehadiran siswa.</p>
            </div>
            <a href="{{ route('absensi.create') }}" class="bg-black text-white px-6 py-3 rounded-lg font-bold text-sm hover:bg-gray-800 shadow-lg">
                + Input Kehadiran
            </a>
        </div>

        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded font-bold">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded font-bold">
                {{ session('success') }}
            </div>
        @endif

       <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 mb-6">
            <form method="GET" action="{{ route('absensi.index') }}" class="flex flex-wrap justify-between items-center gap-4">
                
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
                        <select name="kelas" onchange="this.form.submit()" class="border-gray-300 rounded text-sm bg-gray-50 focus:ring-black focus:border-black min-w-[100px]">
                            <option value="">Semua</option>
                            <option value="X RPL" {{ $kelasSelected == 'X RPL' ? 'selected' : '' }}>X RPL</option>
                            <option value="XI RPL" {{ $kelasSelected == 'XI RPL' ? 'selected' : '' }}>XI RPL</option>
                            <option value="XII RPL" {{ $kelasSelected == 'XII RPL' ? 'selected' : '' }}>XII RPL</option>
                            <option value="XII AK" {{ $kelasSelected == 'XII AK' ? 'selected' : '' }}>XII AK</option>
                        </select>
                    </div>
                </div>
                
                <input type="hidden" name="sort" value="{{ $sort }}">

                <div class="relative">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari Siswa..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm w-64 focus:ring-black focus:border-black">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

            </form>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
        <th class="p-4 text-xs font-bold text-gray-500 uppercase cursor-pointer hover:bg-gray-200 transition select-none">
            <a href="{{ route('absensi.index', array_merge(request()->query(), ['sort' => $sort == 'desc' ? 'asc' : 'desc'])) }}" 
               class="flex items-center gap-1 group text-black">
                
                TANGGAL
                
                @if($sort == 'desc')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                @endif
            </a>
        </th>

        <th class="p-4 text-xs font-bold text-gray-500 uppercase">NIS</th>
        <th class="p-4 text-xs font-bold text-gray-500 uppercase">Nama Siswa</th>
        <th class="p-4 text-xs font-bold text-gray-500 uppercase">Kelas</th>
        <th class="p-4 text-xs font-bold text-gray-500 uppercase">Status</th>
        <th class="p-4 text-xs font-bold text-gray-500 uppercase text-center">Aksi</th>
    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($dataAbsensi as $d)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 text-sm">{{ \Carbon\Carbon::parse($d->tanggal)->format('d-m-Y') }}</td>
                        <td class="p-4 font-bold text-sm">{{ $d->nis }}</td>
                        <td class="p-4 font-medium">{{ $d->nama }}</td>
                        <td class="p-4 text-sm">{{ $d->id_kelas }}</td>
                        <td class="p-4 font-bold text-xs">{{ $d->kehadiran }}</td>
                        <td class="p-4 text-center flex justify-center gap-2">
                            <a href="{{ route('absensi.edit', $d->id_kehadiran) }}" class="bg-blue-50 text-blue-600 px-3 py-1 rounded text-xs font-bold hover:bg-blue-100">Edit</a>
                            @if(auth()->user()->role == 'admin')
            <form action="{{ route('absensi.destroy', $d->id_kehadiran) }}" method="POST" onsubmit="return confirm('Hapus?');">
                @csrf @method('DELETE')
                <button class="bg-red-50 text-red-600 px-3 py-1 rounded text-xs font-bold hover:bg-red-100">Hapus</button>
            </form>
        @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="p-8 text-center text-gray-400">Data tidak ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $dataAbsensi->links() }}</div>
    </div>
</x-app-layout>