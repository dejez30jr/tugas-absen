<x-app-layout>
    @include('components.sidebar')

    <div class="ml-64 p-10 min-h-screen bg-gray-50">
        
        <div class="mb-8 flex justify-between items-end">
            <div>
                <h1 class="text-4xl font-black text-gray-900">Dashboard</h1>
                <p class="text-gray-500 mt-2">Data Kehadiran Hari Ini, {{ now()->format('d F Y') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl border-l-4 border-yellow-400 shadow-sm">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Siswa Terlambat</p>
                <p class="text-5xl font-black text-yellow-500 mt-2">{{ $stats['terlambat'] }}</p>
            </div>
            
            <div class="bg-white p-6 rounded-xl border-l-4 border-green-500 shadow-sm">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kehadiran Hari Ini</p>
                <p class="text-5xl font-black text-green-600 mt-2">{{ $stats['hadir'] }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl border-l-4 border-red-500 shadow-sm">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Sakit / Izin / Alpha</p>
                <p class="text-5xl font-black text-red-500 mt-2">{{ $stats['lainnya'] }}</p>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 mb-6">
            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap gap-4 items-center justify-between">
                
                <div class="flex gap-4 items-center">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-gray-500">Show:</span>
                        <select name="limit" onchange="this.form.submit()" class="border-gray-300 rounded text-sm bg-gray-50">
                            <option value="10" {{ $limit == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ $limit == 20 ? 'selected' : '' }}>20</option>
                            <option value="50" {{ $limit == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $limit == 100 ? 'selected' : '' }}>100</option>
                            <option value="200" {{ $limit == 200 ? 'selected' : '' }}>200</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-gray-500">Kelas:</span>
                        <select name="kelas" onchange="this.form.submit()" class="border-gray-300 rounded text-sm bg-gray-50">
                            <option value="">Semua</option>
                            <option value="X RPL" {{ $kelasSelected == 'X RPL' ? 'selected' : '' }}>X RPL</option>
                            <option value="XI RPL" {{ $kelasSelected == 'XI RPL' ? 'selected' : '' }}>XI RPL</option>
                            <option value="XII RPL" {{ $kelasSelected == 'XII RPL' ? 'selected' : '' }}>XII RPL</option>
                        </select>
                    </div>
                </div>

                <div class="relative">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari Nama / NIS..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-black focus:border-black w-64">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-6">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase">NIS</th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase">Nama Siswa</th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase">Kelas</th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($data as $d)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($d->tanggal)->format('d/m/Y') }}</td>
                        <td class="p-4 font-bold text-sm">{{ $d->nis }}</td>
                        <td class="p-4 font-medium text-gray-900">{{ $d->nama }}</td>
                        <td class="p-4 text-sm">{{ $d->id_kelas }}</td>
                        <td class="p-4">
                            @if($d->kehadiran == 'Hadir') <span class="text-green-600 bg-green-100 px-2 py-1 rounded text-xs font-bold">Hadir</span>
                            @elseif($d->kehadiran == 'Terlambat') <span class="text-yellow-600 bg-yellow-100 px-2 py-1 rounded text-xs font-bold">Terlambat</span>
                            @else <span class="text-red-600 bg-red-100 px-2 py-1 rounded text-xs font-bold">{{ $d->kehadiran }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="p-8 text-center text-gray-400">Data tidak ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>{{ $data->links() }}</div>

    </div>
</x-app-layout>