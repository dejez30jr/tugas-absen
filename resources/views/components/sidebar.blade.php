<aside class="fixed top-0 left-0 z-50 w-64 h-screen bg-white border-r border-gray-200 flex flex-col justify-between">
    
    <div>
        <div class="flex items-center justify-center h-20 border-b border-gray-100">
            <h1 class="text-2xl font-black text-black">ABSENSI<span class="text-gray-300">.APP</span></h1>
        </div>

        <nav class="p-4 space-y-2 mt-4">
            
            <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-lg text-sm transition-all {{ request()->routeIs('dashboard') ? 'bg-black text-white font-bold shadow-lg' : 'text-gray-600 hover:bg-gray-100 font-medium' }}">
                Home
            </a>
            
            <a href="{{ route('absensi.index') }}" class="block px-4 py-3 rounded-lg text-sm transition-all {{ request()->routeIs('absensi.*') ? 'bg-black text-white font-bold shadow-lg' : 'text-gray-600 hover:bg-gray-100 font-medium' }}">
                Data Absensi
            </a>

            <a href="{{ route('siswa.index') }}" class="block px-4 py-3 rounded-lg text-sm transition-all {{ request()->routeIs('siswa.*') ? 'bg-black text-white font-bold shadow-lg' : 'text-gray-600 hover:bg-gray-100 font-medium' }}">
                Data Siswa
            </a>

            @if(auth()->user()->role == 'admin')
                <a href="{{ route('pengguna.index') }}" class="block px-4 py-3 rounded-lg text-sm transition-all {{ request()->routeIs('pengguna.*') ? 'bg-black text-white font-bold shadow-lg' : 'text-gray-600 hover:bg-gray-100 font-medium' }}">
                    Pengguna (Admin)
                </a>
            @endif

        </nav>
    </div>
    
    <div class="border-t border-gray-200 bg-gray-50">
        
        <div class="p-4 border-b border-gray-200 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-black text-white flex items-center justify-center font-bold text-lg">
                {{ substr(auth()->user()->nama, 0, 1) }}
            </div>
            
            <div class="overflow-hidden">
                <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->nama }}</p>
                <p class="text-xs text-gray-500 uppercase tracking-wide">
                    {{ auth()->user()->role }}
                </p>
            </div>
        </div>

        <div class="p-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full flex items-center justify-center gap-2 bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Keluar Aplikasi
                </button>
            </form>
        </div>

    </div>
</aside>