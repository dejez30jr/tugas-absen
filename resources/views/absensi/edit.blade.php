<x-app-layout>
    @include('components.sidebar')

    <div class="ml-64 p-10 min-h-screen bg-gray-50">
        <div class="mb-8 border-b border-gray-200 pb-4">
            <h2 class="text-3xl font-black text-gray-900">Edit Kehadiran</h2>
        </div>

        <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm max-w-2xl">
            <form action="{{ route('absensi.update', $d->id_kehadiran) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <p class="text-sm text-gray-500">Siswa:</p>
                    <p class="font-bold text-lg">{{ $s->nama }} ({{ $s->nis }})</p>
                    <p class="text-sm text-gray-500 mt-1">Kelas: {{ $s->id_kelas }}</p>
                </div>

                <div class="mb-6">
                    <label class="block font-bold mb-2 text-sm">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ $d->tanggal }}" class="w-full border-gray-300 rounded-lg p-3">
                </div>

                <div class="mb-6">
                    <label class="block font-bold mb-2 text-sm">Status Kehadiran</label>
                    <select name="kehadiran" class="w-full border-gray-300 rounded-lg p-3">
                        <option value="Hadir" {{ $d->kehadiran == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="Terlambat" {{ $d->kehadiran == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                        <option value="Sakit" {{ $d->kehadiran == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="Izin" {{ $d->kehadiran == 'Izin' ? 'selected' : '' }}>Izin</option>
                        <option value="Alpha" {{ $d->kehadiran == 'Alpha' ? 'selected' : '' }}>Alpha</option>
                    </select>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-black text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-800">Simpan Perubahan</button>
                    <a href="{{ route('absensi.index') }}" class="bg-gray-100 text-gray-600 px-6 py-3 rounded-lg font-bold hover:bg-gray-200">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>