<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kehadiran Siswa Hari Ini</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased">

    <nav class="bg-white border-b border-gray-200 fixed w-full z-10 top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <h1 class="text-2xl font-black text-black tracking-tighter">ABSENSI<span class="text-gray-400">.APP</span></h1>
                </div>
                <div>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="font-bold text-gray-600 hover:text-black">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="bg-black text-white px-5 py-2 rounded-lg font-bold text-sm hover:bg-gray-800 transition shadow-lg">
                                Masuk
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-10">
        
        <div class="text-center mb-10">
            <h2 class="text-4xl font-black text-gray-900 mb-2">Kehadiran Hari Ini</h2>
            <p class="text-lg text-gray-500 font-medium">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10 max-w-4xl mx-auto">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Siswa Terlambat</p>
                    <p class="text-5xl font-black text-yellow-500 mt-2">{{ $stats['terlambat'] }}</p>
                </div>
                <div class="p-4 bg-yellow-50 rounded-full text-yellow-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Kehadiran Hari Ini</p>
                    <p class="text-5xl font-black text-green-600 mt-2">{{ $stats['hadir'] }}</p>
                </div>
                <div class="p-4 bg-green-50 rounded-full text-green-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-6">
            <form method="GET" action="{{ route('home') }}" class="flex flex-col md:flex-row justify-between items-center gap-4">
                
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-gray-500 uppercase">Show:</span>
                        <select name="limit" onchange="this.form.submit()" class="border-gray-300 rounded-lg text-sm bg-gray-50 focus:ring-black focus:border-black p-2">
                            @foreach([10, 20, 50, 100, 200] as $val)
                                <option value="{{ $val }}" {{ $limit == $val ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-gray-500 uppercase">Kelas:</span>
                        <select name="kelas" onchange="this.form.submit()" class="border-gray-300 rounded-lg text-sm bg-gray-50 focus:ring-black focus:border-black p-2 min-w-[120px]">
                            <option value="">Semua</option>
                            @foreach(['X RPL', 'XI RPL', 'XII RPL', 'XII AK'] as $k)
                                <option value="{{ $k }}" {{ $kelasSelected == $k ? 'selected' : '' }}>{{ $k }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="w-full md:w-auto relative">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari Nama / NIS..." class="w-full md:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-black focus:border-black">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

            </form>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-8">
            <table class="w-full text-left border-collapse">
                <thead class="bg-black text-white">
                    <tr>
                        <th class="p-4 text-xs font-bold uppercase tracking-wider">NIS</th>
                        <th class="p-4 text-xs font-bold uppercase tracking-wider">Nama Siswa</th>
                        <th class="p-4 text-xs font-bold uppercase tracking-wider">Kelas</th>
                        <th class="p-4 text-xs font-bold uppercase tracking-wider text-center">Kehadiran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($data as $d)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="p-4 font-bold text-gray-700">{{ $d->nis }}</td>
                        <td class="p-4 font-medium text-gray-900">{{ $d->nama }}</td>
                        <td class="p-4 text-sm text-gray-600">
                            <span class="bg-gray-100 border border-gray-200 px-2 py-1 rounded text-xs font-bold">{{ $d->id_kelas }}</span>
                        </td>
                        <td class="p-4 text-center">
                            @if($d->kehadiran == 'Hadir') 
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold shadow-sm">Hadir</span>
                            @elseif($d->kehadiran == 'Terlambat') 
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold shadow-sm">Terlambat</span>
                            @else 
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold shadow-sm">{{ $d->kehadiran }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-10 text-center text-gray-400 bg-gray-50">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                <p>Belum ada data absensi hari ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex justify-center">
            {{ $data->links() }}
        </div>

    </div>

    <div class="text-center py-6 text-gray-400 text-sm">
        &copy; {{ date('Y') }} SMK Dubes - Sistem Absensi Digital
    </div>

</body>
</html>