<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pengguna • UMKM Mini-Commerce</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-rose-50 min-h-screen flex">
  {{-- Sidebar (copy dari dashboard-mu) --}}
  <aside class="w-64 bg-white border-r">
    <div class="p-4 text-center border-b">
      <img src="{{ asset('images/logo.png') }}" alt="TokoKami" class="mx-auto w-16 mb-2">
      <h1 class="text-lg font-semibold text-emerald-700">TokoKami</h1>
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

    {{-- Data fallback jika controller belum kirim $users --}}
    @php
      $listUsers = isset($users) ? $users : collect([
        (object)['id'=>1,'name'=>'Admin User','email'=>'admin@example.com','role'=>'admin','status'=>'active','created_at'=>now()->subDays(30)],
        (object)['id'=>2,'name'=>'Test User','email'=>'test@example.com','role'=>'customer','status'=>'active','created_at'=>now()->subDays(1)],
        (object)['id'=>3,'name'=>'Moderator User','email'=>'mod@example.com','role'=>'customer','status'=>'active','created_at'=>now()],
      ]);
      $totalUsers  = $listUsers instanceof \Illuminate\Pagination\AbstractPaginator ? $listUsers->total() : $listUsers->count();
      $totalAdmins = $listUsers->where('role','admin')->count();
      $totalActive = $listUsers->where('status','active')->count();
      $totalBanned = $listUsers->where('status','banned')->count();
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

    {{-- Filter (tanpa aksi massal) --}}
    <div class="bg-white rounded-xl shadow p-4">
      <form class="grid grid-cols-1 md:grid-cols-5 gap-3">
        <input type="text" placeholder="Cari nama / email" class="rounded-lg border-gray-300 px-3 py-2 md:col-span-2">
        <select class="rounded-lg border-gray-300">
          <option value="">Peran: Semua</option><option value="admin">Admin</option><option value="customer">Customer</option>
        </select>
        <select class="rounded-lg border-gray-300">
          <option value="">Status: Semua</option><option value="active">Aktif</option><option value="banned">Diblokir</option>
        </select>
        <div class="flex gap-2">
          <button type="button" class="px-4 py-2 rounded-lg bg-gray-900 text-white">Terapkan</button>
          <button type="button" class="px-4 py-2 rounded-lg border">Reset</button>
        </div>
      </form>
    </div>

    {{-- Tabel pengguna --}}
    <section class="bg-white rounded-xl shadow overflow-hidden">
      <div class="p-4 flex items-center justify-between border-b">
        <h2 class="font-semibold">Daftar Pengguna</h2>
        <div class="text-sm text-gray-500">
          @if($listUsers instanceof \Illuminate\Pagination\AbstractPaginator)
            Menampilkan {{ $listUsers->count() }} dari {{ $listUsers->total() }}
          @else
            Total {{ $listUsers->count() }} pengguna
          @endif
        </div>
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
            @foreach($listUsers as $u)
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
            @endforeach
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
            Total {{ $listUsers->count() }} pengguna
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
                  <option value="customer">Customer</option>
                  <option value="admin">Admin</option>
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
            <button class="px-4 py-2 rounded-lg bg-emerald-600 text-white">Simpan</button>
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
          const u = { id:btn.dataset.id, name:btn.dataset.name, email:btn.dataset.email, role:btn.dataset.role, status:btn.dataset.status };
          document.getElementById('u-id').value     = u.id || '';
          document.getElementById('u-name').value   = u.name || '';
          document.getElementById('u-email').value  = u.email || '';
          document.getElementById('u-role').value   = u.role || 'customer';
          document.getElementById('u-status').value = u.status || 'active';

          const form = document.getElementById('editForm');
          form.action = @json(route('admin.manageusers.update', ['manageuser' => '__ID__'])).replace('__ID__', u.id);

          openEdit();
        });
      });
    }
    function openEdit(){ document.getElementById('editModal').classList.remove('hidden'); }
    function closeEdit(){ document.getElementById('editModal').classList.add('hidden'); document.getElementById('editForm').reset(); }

    document.addEventListener('click', e=>{ if (e.target === document.getElementById('editModal')) closeEdit(); });
    document.addEventListener('keydown', e=>{ if (e.key === 'Escape') closeEdit(); });

    document.addEventListener('DOMContentLoaded', ()=>{ wireEdit(); reflectMaster(); });
  </script>
</body>
</html>
