<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin • TokoKami</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50">
    {{-- Sidebar --}}
  <aside class="w-64 bg-white border-r">
    <div class="p-4 text-center border-b">
      <img src="{{ asset('images/logo.png') }}" alt="TokoKami" class="mx-auto w-16 mb-2">
      <h1 class="text-lg font-semibold text-emerald-700">TokoKami</h1>
      <p class="text-xs text-gray-500">UMKM Mini-Commerce</p>
    </div>
    <nav class="p-4 space-y-2 text-sm">
      <a href="{{ route('dashboard') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium 
        {{ request()->routeIs('dashboard') 
              ? 'bg-emerald-100 text-emerald-700' 
              : 'text-gray-700 hover:bg-gray-100 hover:text-emerald-700' }}">
          <i class="lucide lucide-home"></i> Dashboard
      </a>

      <a href="{{ route('admin.managecategories.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium 
        {{ request()->routeIs('admin.managecategories.index') 
              ? 'bg-emerald-100 text-emerald-700' 
              : 'text-gray-700 hover:bg-gray-100 hover:text-emerald-700' }}">
          <i class="lucide lucide-box"></i> Manajemen Produk
      </a>

      <a href="{{ route('admin.manageorders.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium 
        {{ request()->routeIs('admin.manageorders.index') 
              ? 'bg-emerald-100 text-emerald-700' 
              : 'text-gray-700 hover:bg-gray-100 hover:text-emerald-700' }}">
          <i class="lucide lucide-shopping-bag"></i> Manajemen Pesanan
      </a>

      <a href="{{ route('admin.manageusers.showUsers') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium 
        {{ request()->routeIs('admin.manageusers.showUsers') 
              ? 'bg-emerald-100 text-emerald-700' 
              : 'text-gray-700 hover:bg-gray-100 hover:text-emerald-700' }}">
          <i class="lucide lucide-file-chart"></i> Pengguna
      </a>
      <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
        </svg>
        Logout
    </a>
    </nav>
  </aside>
</body>
</html>