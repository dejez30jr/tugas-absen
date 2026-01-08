<x-app-layout>
    @include('components.sidebar')

    <div class="ml-64 p-10 min-h-screen bg-gray-50">
        <div class="mb-8 border-b border-gray-200 pb-4">
            <h2 class="text-3xl font-black text-gray-900">Input Kehadiran</h2>
        </div>

        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm max-w-2xl">
            <form action="{{ route('absensi.store') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label class="block font-bold mb-2 text-sm">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-lg p-3">
                </div>

                <div class="mb-6">
                    <label class="block font-bold mb-2 text-sm">Pilih Siswa</label>
                    <select name="id_siswa" class="w-full border-gray-300 rounded-lg p-3">
                        <option value="">-- Pilih Nama Siswa --</option>
                        @foreach($siswa as $s)
                            <option value="{{ $s->id_siswa }}">{{ $s->nis }} - {{ $s->nama }} ({{ $s->id_kelas }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block font-bold mb-2 text-sm">Keterangan</label>
                    <select name="kehadiran" class="w-full border-gray-300 rounded-lg p-3">
                        <option value="Hadir">Hadir</option>
                        <option value="Terlambat">Terlambat</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Izin">Izin</option>
                        <option value="Alpha">Alpha</option>
                    </select>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-black text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-800">Simpan</button>
                    <a href="{{ route('absensi.index') }}" class="bg-gray-100 text-gray-600 px-6 py-3 rounded-lg font-bold hover:bg-gray-200">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>