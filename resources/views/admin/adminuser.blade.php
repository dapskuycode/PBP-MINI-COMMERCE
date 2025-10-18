<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pengguna - TumbasLek Mini Commerce</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logoAtas.png') }}?v={{ time() }}">
  <link rel="shortcut icon" href="{{ asset('images/logoAtas.png') }}?v={{ time() }}">
  <link rel="apple-touch-icon" href="{{ asset('images/logoAtas.png') }}?v={{ time() }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-rose-50 min-h-screen flex">
  {{-- Sidebar (copy dari dashboard-mu) --}}
  <aside class="w-64 bg-white border-r">
    <div class="p-4 text-center border-b">
  <img src="{{ asset('images/logo.png') }}" alt="TumbasLek" class="mx-auto w-16 mb-2">
  <h1 class="text-lg font-semibold text-emerald-700">TumbasLek</h1>
      <p class="text-xs text-gray-500">UMKM Mini-Commerce</p>
    </div>
    <nav class="p-4 space-y-2 text-sm">
      <a href="{{ route('dashboard') }}"
         class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium {{ request()->routeIs('dashboard') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-700 hover:bg-gray-100 hover:text-emerald-700' }}">
        <i class="lucide lucide-home"></i> Dashboard
      </a>

      <a href="{{ route('admin.managecategories.index') }}"
         class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium {{ request()->routeIs('admin.managecategories.*') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-700 hover:bg-gray-100 hover:text-emerald-700' }}">
        <i class="lucide lucide-box"></i> Manajemen Produk
      </a>

      <a href="{{ route('admin.manageorders.index') }}"
         class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium {{ request()->routeIs('admin.manageorders.*') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-700 hover:bg-gray-100 hover:text-emerald-700' }}">
        <i class="lucide lucide-shopping-bag"></i> Manajemen Pesanan
      </a>

      <a href="{{ route('admin.manageusers.showUsers') }}"
         class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium {{ request()->routeIs('admin.manageusers.*') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-700 hover:bg-gray-100 hover:text-emerald-700' }}">
        <i class="lucide lucide-users"></i> Pengguna
      </a>

      <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
        </svg>
        Logout
      </a>
    </nav>
  </aside>

  {{-- Konten utama --}}
  <main class="flex-1 p-8 space-y-6">
    <div class="flex justify-between items-center">
      <div>
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Pengguna</h1>
        <p class="text-gray-600">Kelola akun admin & pelanggan.</p>
      </div>
      <a href="{{ route('dashboard') }}" class="text-emerald-700 font-semibold hover:underline">← Kembali ke Dashboard</a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
      </div>
    @endif

    @if($errors->any())
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc list-inside">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- Data users dari controller --}}
    @php
      $listUsers = $users ?? collect([]);
      
      // Untuk statistik, ambil data dari seluruh database (tidak ter-filter)
      $allUsers = \App\Models\User::all();
      $totalUsers = $allUsers->count();
      $totalAdmins = $allUsers->where('role','admin')->count();
      $totalActive = $allUsers->where('status','active')->count();
      $totalBanned = $allUsers->where('status','banned')->count();
      
      // Untuk tampilan filtered results
      $filteredCount = $listUsers instanceof \Illuminate\Pagination\AbstractPaginator ? $listUsers->total() : $listUsers->count();
    @endphp

    {{-- Kartu ringkasan --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-emerald-100 grid place-items-center">👥</div>
        <div><p class="text-sm text-gray-600">Total Pengguna</p><p class="text-2xl font-semibold text-emerald-700">{{ $totalUsers }}</p></div>
      </div>
      <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-green-100 grid place-items-center">🛡️</div>
        <div><p class="text-sm text-gray-600">Total Admin</p><p class="text-2xl font-semibold text-green-700">{{ $totalAdmins }}</p></div>
      </div>
      <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-cyan-100 grid place-items-center">✅</div>
        <div><p class="text-sm text-gray-600">Aktif</p><p class="text-2xl font-semibold text-cyan-700">{{ $totalActive }}</p></div>
      </div>
      <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-rose-100 grid place-items-center">⛔</div>
        <div><p class="text-sm text-gray-600">Diblokir</p><p class="text-2xl font-semibold text-rose-600">{{ $totalBanned }}</p></div>
      </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-xl shadow p-4">
      <div class="mb-3 flex items-center text-sm text-gray-600">
      </div>
      <form id="filterForm" method="GET" action="{{ route('admin.manageusers.showUsers') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
        <div class="relative md:col-span-2">
          <input 
            type="text" 
            name="search" 
            id="searchInput"
            placeholder="Ketik nama atau email untuk mencari..." 
            value="{{ request('search') }}" 
            class="w-full rounded-lg border-gray-300 px-3 py-2 pr-10">
          <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
          </div>
        </div>
        <select name="role" id="roleSelect" class="rounded-lg border-gray-300">
          <option value="">Peran: Semua</option>
          <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
          <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Customer</option>
          <option value="moderator" {{ request('role') == 'moderator' ? 'selected' : '' }}>Moderator</option>
        </select>
        <select name="status" id="statusSelect" class="rounded-lg border-gray-300">
          <option value="">Status: Semua</option>
          <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
          <option value="banned" {{ request('status') == 'banned' ? 'selected' : '' }}>Diblokir</option>
        </select>
      </form>
      
      {{-- Loading indicator and Reset button --}}
      <div class="mt-3 flex justify-between items-center">
        <div id="loadingIndicator" class="hidden">
          <div class="flex items-center text-sm text-gray-600">
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Memfilter data...
          </div>
        </div>
        
        @if(request()->hasAny(['search', 'role', 'status']))
          <a href="{{ route('admin.manageusers.showUsers') }}" 
             class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            Reset Filter
          </a>
        @endif
      </div>
    </div>

    {{-- Tabel pengguna --}}
    <section class="bg-white rounded-xl shadow overflow-hidden">
      <div class="p-4 border-b">
        <div class="flex items-center justify-between mb-2">
          <h2 class="font-semibold">Daftar Pengguna</h2>
          <div class="text-sm text-gray-500">
            @if($listUsers instanceof \Illuminate\Pagination\AbstractPaginator)
              Menampilkan {{ $listUsers->count() }} dari {{ $listUsers->total() }}
            @else
              Total {{ $filteredCount }} pengguna
            @endif
          </div>
        </div>
        
        {{-- Active Filters Display --}}
        @if(request()->hasAny(['search', 'role', 'status']))
          <div class="flex flex-wrap gap-2 text-sm">
            <span class="text-gray-600">Filter aktif:</span>
            @if(request('search'))
              <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                Pencarian: "{{ request('search') }}"
              </span>
            @endif
            @if(request('role'))
              <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full">
                Role: {{ ucfirst(request('role')) }}
              </span>
            @endif
            @if(request('status'))
              <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full">
                Status: {{ ucfirst(request('status')) }}
              </span>
            @endif
            <a href="{{ route('admin.manageusers.showUsers') }}" class="text-red-600 hover:text-red-800">
              ✕ Hapus semua filter
            </a>
          </div>
        @endif
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-3">
                <input id="check-all-top" type="checkbox" class="rounded">
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peran</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bergabung</th>
              <th class="px-6 py-3"></th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            @forelse($listUsers as $u)
              @php
                $role   = $u->role   ?? (($u->is_admin ?? false) ? 'admin' : 'customer');
                $status = $u->status ?? 'active';
                $joined = optional($u->created_at)->format('d M Y') ?? '-';
              @endphp
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-4"><input type="checkbox" class="row-check rounded"></td>
                <td class="px-6 py-4 font-medium text-gray-900">{{ $u->name }}</td>
                <td class="px-6 py-4 text-gray-700 break-all">{{ $u->email }}</td>
                <td class="px-6 py-4">
                  @if($role === 'admin')
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Admin</span>
                  @elseif($role === 'moderator')
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-50 text-purple-700">Moderator</span>
                  @else
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">Customer</span>
                  @endif
                </td>
                <td class="px-6 py-4">
                  @if($status === 'banned')
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-700">Diblokir</span>
                  @else
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-cyan-50 text-cyan-700">Aktif</span>
                  @endif
                </td>
                <td class="px-6 py-4 text-gray-700">{{ $joined }}</td>
                <td class="px-6 py-4 text-right">
                  <div class="inline-flex gap-2">
                    <button type="button"
                      class="px-3 py-1.5 rounded-lg border hover:bg-gray-50 js-edit"
                      data-id="{{ $u->id }}"
                      data-name="{{ $u->name }}"
                      data-email="{{ $u->email }}"
                      data-role="{{ $role }}"
                      data-status="{{ $status }}">Edit</button>

                    <form method="POST"
                          action="{{ route('admin.manageusers.destroy', ['manageuser' => $u->id]) }}"
                          onsubmit="return confirm(@json('Hapus pengguna '.$u->name.'?'))"
                          class="inline">
                      @csrf @method('DELETE')
                      <button class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100">Hapus</button>
                    </form>

                    @if($status === 'active')
                      <form method="POST"
                            action="{{ route('admin.manageusers.update', ['manageuser' => $u->id]) }}"
                            onsubmit="return confirm(@json('Blokir pengguna '.$u->name.'?'))"
                            class="inline">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="banned">
                        <button class="px-3 py-1.5 rounded-lg border hover:bg-gray-50">Blokir</button>
                      </form>
                    @else
                      <form method="POST"
                            action="{{ route('admin.manageusers.update', ['manageuser' => $u->id]) }}"
                            onsubmit="return confirm(@json('Aktifkan kembali '.$u->name.'?'))"
                            class="inline">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="active">
                        <button class="px-3 py-1.5 rounded-lg border hover:bg-gray-50">Aktifkan</button>
                      </form>
                    @endif
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                  <div class="flex flex-col items-center">
                    <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.47-.881-6.08-2.33"></path>
                    </svg>
                    <p class="text-lg font-medium text-gray-900 mb-2">Tidak ada pengguna ditemukan</p>
                    <p class="text-gray-600 mb-4">
                      @if(request()->hasAny(['search', 'role', 'status']))
                        Coba ubah filter atau hapus semua filter untuk melihat semua pengguna.
                      @else
                        Belum ada pengguna yang terdaftar di sistem.
                      @endif
                    </p>
                    @if(request()->hasAny(['search', 'role', 'status']))
                      <a href="{{ route('admin.manageusers.showUsers') }}" 
                         class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md">
                        Hapus Filter
                      </a>
                    @endif
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      @if($listUsers instanceof \Illuminate\Pagination\AbstractPaginator)
        <div class="p-4 border-t">
          {{ $listUsers->links('vendor.pagination.tailwind') }}
        </div>
      @endif

      {{-- Aksi massal di BAWAH --}}
      <div class="p-4 border-t bg-gray-50 flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-2">
          <input id="check-all-bottom" type="checkbox" class="rounded">
          <label for="check-all-bottom" class="text-sm text-gray-700">Pilih semua</label>
          <select class="rounded-lg border-gray-300 text-sm">
            <option>Aksi massal</option>
            <option>Ubah role → Admin</option>
            <option>Ubah role → Customer</option>
            <option>Blokir akun</option>
            <option>Aktifkan akun</option>
            <option>Hapus</option>
          </select>
          <button class="px-3 py-2 rounded-lg border text-sm">Jalankan</button>
        </div>
        <div class="text-sm text-gray-500">
          @if($listUsers instanceof \Illuminate\Pagination\AbstractPaginator)
            Menampilkan {{ $listUsers->count() }} dari {{ $listUsers->total() }}
          @else
            Total {{ $filteredCount }} pengguna
          @endif
          @if(request()->hasAny(['search', 'role', 'status']))
            <span class="text-blue-600">(Difilter dari {{ $totalUsers }} total)</span>
          @endif
        </div>
      </div>
    </section>
  </main>

  {{-- Modal Edit --}}
  <div id="editModal" class="fixed inset-0 bg-black/50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
      <div class="bg-white rounded-xl shadow-xl max-w-md w-full overflow-hidden">
        <form id="editForm" method="POST">
          @csrf @method('PUT')
          <div class="p-6 border-b flex items-center justify-between">
            <h3 class="text-lg font-semibold">Edit Pengguna</h3>
            <button type="button" class="text-gray-500 hover:text-gray-700" onclick="closeEdit()">✕</button>
          </div>
          <div class="p-6 space-y-4">
            <input type="hidden" id="u-id" name="id">
            <div>
              <label class="block text-sm text-gray-700 mb-1">Nama</label>
              <input id="u-name" name="name" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
              <label class="block text-sm text-gray-700 mb-1">Email</label>
              <input id="u-email" name="email" type="email" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div class="grid grid-cols-2 gap-3">
              <div>
                <label class="block text-sm text-gray-700 mb-1">Peran</label>
                <select id="u-role" name="role" class="w-full border rounded-lg px-3 py-2">
                  <option value="user">Customer</option>
                  <option value="admin">Admin</option>
                  <option value="moderator">Moderator</option>
                </select>
              </div>
              <div>
                <label class="block text-sm text-gray-700 mb-1">Status</label>
                <select id="u-status" name="status" class="w-full border rounded-lg px-3 py-2">
                  <option value="active">Aktif</option>
                  <option value="banned">Diblokir</option>
                </select>
              </div>
            </div>
            <div>
              <label class="block text-sm text-gray-700 mb-1">Reset Password (opsional)</label>
              <input name="password" type="password" class="w-full border rounded-lg px-3 py-2" placeholder="••••••••">
            </div>
          </div>
          <div class="bg-gray-50 p-4 flex justify-end gap-2">
            <button type="button" class="px-4 py-2 rounded-lg border" onclick="closeEdit()">Batal</button>
            <button type="submit" class="px-4 py-2 rounded-lg bg-emerald-600 text-white">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    // Sync "pilih semua" atas/bawah
    const topMaster    = document.getElementById('check-all-top');
    const bottomMaster = document.getElementById('check-all-bottom');
    function setAllRows(checked){ document.querySelectorAll('.row-check').forEach(c => c.checked = checked); }
    function reflectMaster(){
      const rows = Array.from(document.querySelectorAll('.row-check'));
      const all  = rows.length && rows.every(c => c.checked);
      const any  = rows.some(c => c.checked);
      [topMaster, bottomMaster].forEach(m => { if(!m) return; m.checked = all; if('indeterminate' in m) m.indeterminate = !all && any; });
    }
    topMaster   && topMaster.addEventListener('change', e=>{ setAllRows(e.target.checked); bottomMaster && (bottomMaster.checked = e.target.checked); reflectMaster(); });
    bottomMaster&& bottomMaster.addEventListener('change', e=>{ setAllRows(e.target.checked); topMaster && (topMaster.checked = e.target.checked); reflectMaster(); });
    document.addEventListener('click', e=>{ if(e.target.classList?.contains('row-check')) reflectMaster(); });

    // Wire tombol Edit (pakai data-* per field)
    function wireEdit(){
      document.querySelectorAll('.js-edit').forEach(btn=>{
        btn.addEventListener('click', ()=>{
          console.log('Edit button clicked'); // Debug log
          const u = { 
            id: btn.dataset.id, 
            name: btn.dataset.name, 
            email: btn.dataset.email, 
            role: btn.dataset.role, 
            status: btn.dataset.status 
          };
          console.log('User data:', u); // Debug log
          
          document.getElementById('u-id').value     = u.id || '';
          document.getElementById('u-name').value   = u.name || '';
          document.getElementById('u-email').value  = u.email || '';
          document.getElementById('u-role').value   = u.role || 'user';
          document.getElementById('u-status').value = u.status || 'active';

          const form = document.getElementById('editForm');
          const actionUrl = @json(route('admin.manageusers.update', ['manageuser' => '__ID__'])).replace('__ID__', u.id);
          form.action = actionUrl;
          console.log('Form action set to:', actionUrl); // Debug log

          openEdit();
        });
      });
    }
    function openEdit(){ document.getElementById('editModal').classList.remove('hidden'); }
    function closeEdit(){ document.getElementById('editModal').classList.add('hidden'); document.getElementById('editForm').reset(); }

    document.addEventListener('click', e=>{ if (e.target === document.getElementById('editModal')) closeEdit(); });
    document.addEventListener('keydown', e=>{ if (e.key === 'Escape') closeEdit(); });

    // Form submit handler with debugging
    document.addEventListener('DOMContentLoaded', ()=>{ 
      wireEdit(); 
      reflectMaster();
      
      // Add form submit debugging
      document.getElementById('editForm').addEventListener('submit', function(e) {
        console.log('Form submit triggered');
        console.log('Form action:', this.action);
        console.log('Form method:', this.method);
        
        // Check if form data is valid
        const formData = new FormData(this);
        for (let [key, value] of formData.entries()) {
          console.log(key + ':', value);
        }
      });

      // Auto-submit filter form
      setupAutoFilter();
    });

    // Setup auto-filtering functionality
    function setupAutoFilter() {
      const form = document.getElementById('filterForm');
      const searchInput = document.getElementById('searchInput');
      const roleSelect = document.getElementById('roleSelect');
      const statusSelect = document.getElementById('statusSelect');
      const loadingIndicator = document.getElementById('loadingIndicator');
      
      let searchTimeout;

      // Show loading indicator
      function showLoading() {
        if (loadingIndicator) {
          loadingIndicator.classList.remove('hidden');
        }
      }

      // Auto-submit on search input (with debounce)
      searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        
        // Show loading immediately when typing
        if (this.value.length > 0 || {{ request('search') ? 'true' : 'false' }}) {
          showLoading();
        }
        
        searchTimeout = setTimeout(() => {
          form.submit();
        }, 500); // Wait 500ms after user stops typing
      });

      // Auto-submit on dropdown change (immediate)
      roleSelect.addEventListener('change', function() {
        showLoading();
        form.submit();
      });

      statusSelect.addEventListener('change', function() {
        showLoading();
        form.submit();
      });

      // Clear search timeout if form is submitted manually
      form.addEventListener('submit', function() {
        clearTimeout(searchTimeout);
        showLoading();
      });

      // Add visual feedback for typing
      searchInput.addEventListener('keydown', function() {
        clearTimeout(searchTimeout);
      });
    }
  </script>
</body>
</html>
