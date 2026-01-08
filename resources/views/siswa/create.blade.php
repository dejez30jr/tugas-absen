<x-app-layout>
    @include('components.sidebar')

    <div class="ml-64 p-10 min-h-screen bg-gray-50">
        <div class="mb-8 border-b border-gray-200 pb-4">
            <h2 class="text-3xl font-black text-gray-900">Tambah Siswa Baru</h2>
        </div>

        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <strong class="font-bold">Gagal Menyimpan!</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm max-w-2xl">
            <form action="{{ route('siswa.store') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label class="block font-bold mb-2 text-sm text-gray-700">NIS</label>
                    <input type="text" name="nis" required placeholder="Contoh: 12345" 
                           class="w-full border-gray-300 rounded-lg p-3 focus:ring-black focus:border-black transition">
                </div>

                <div class="mb-6">
                    <label class="block font-bold mb-2 text-sm text-gray-700">Nama Lengkap</label>
                    <input type="text" name="nama" required placeholder="Contoh: Ahmad Budi" 
                           class="w-full border-gray-300 rounded-lg p-3 focus:ring-black focus:border-black transition">
                </div>

                <div class="flex gap-6 mb-8">
                    <div class="w-1/2">
                        <label class="block font-bold mb-2 text-sm text-gray-700">Kelas</label>
                        <select name="kelas" class="w-full border-gray-300 rounded-lg p-3 focus:ring-black focus:border-black cursor-pointer">
                            <option value="X RPL">X RPL</option>
                            <option value="XI RPL">XI RPL</option>
                            <option value="XII RPL">XII RPL</option>
                            <option value="XII AK">XII AK</option>
                        </select>
                    </div>
                    <div class="w-1/2">
                        <label class="block font-bold mb-2 text-sm text-gray-700">Gender</label>
                        <select name="gender" class="w-full border-gray-300 rounded-lg p-3 focus:ring-black focus:border-black cursor-pointer">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-black text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-800 transition shadow-lg">
                        Simpan Data
                    </button>
                    <a href="{{ route('siswa.index') }}" class="bg-gray-100 text-gray-600 px-6 py-3 rounded-lg font-bold hover:bg-gray-200 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>