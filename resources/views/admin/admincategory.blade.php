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
	<!-- Bungkus layout menjadi flex agar sidebar dan konten utama sejajar -->
	<div class="min-h-screen flex">
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
	
		<!-- Main Content (ubah menjadi flex-1 dan tambahkan spacing vertikal) -->
		<main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
			<!-- Alert Messages -->
			@if(session('warning'))
			    <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
			        <div class="flex items-center">
			            <svg class="w-5 h-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
			                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
			            </svg>
			            <p class="text-yellow-700 font-medium">{{ session('warning') }}</p>
			        </div>
			    </div>
			@endif
	
			@if(session('success'))
			    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
			        <div class="flex items-center">
			            <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
			                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
			            </svg>
			            <p class="text-green-700 font-medium">{{ session('success') }}</p>
			        </div>
			    </div>
			@endif
	
			<!-- Welcome Section -->
			
			<!-- Stats Cards -->
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
			    <div class="bg-white rounded-xl shadow-md p-6 text-center">
			        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-3">
			            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
			                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
			            </svg>
			        </div>
			        <h3 class="text-lg font-semibold text-gray-900">Total Produk</h3>
			        <p class="text-3xl font-bold text-blue-600">{{ $totalProducts }}</p>
			    </div>
			    
			    <div class="bg-white rounded-xl shadow-md p-6 text-center">
			        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-3">
			            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
			                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
			            </svg>
			        </div>
			        <h3 class="text-lg font-semibold text-gray-900">Total Kategori</h3>
			        <p class="text-3xl font-bold text-green-600">{{ $totalCategories }}</p>
			    </div>
			    
			    <div class="bg-white rounded-xl shadow-md p-6 text-center">
			        <div class="w-12 h-12 bg-cyan-100 rounded-lg flex items-center justify-center mx-auto mb-3">
			            <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
			                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
			            </svg>
			        </div>
			        <h3 class="text-lg font-semibold text-gray-900">Stok Tersedia</h3>
			        <p class="text-3xl font-bold text-cyan-600">{{ $products->sum('stock') }}</p>
			    </div>
			    
			    <div class="bg-white rounded-xl shadow-md p-6 text-center">
			        <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center mx-auto mb-3">
			            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
			                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
			            </svg>
			        </div>
			        <h3 class="text-lg font-semibold text-gray-900">Nilai Stok</h3>
			        <p class="text-3xl font-bold text-amber-600">Rp {{ number_format($products->sum(function($product) { return $product->price * $product->stock; }), 0, ',', '.') }}</p>
			    </div>
			</div>
	
			<!-- Products Section (ubah: kategori memanjang ke samping, produk disusun ke bawah per kategori) -->
			<div class="bg-white rounded-xl shadow-md p-6">
	<div class="flex justify-between items-center mb-6">
		<h2 class="text-xl font-bold text-gray-900">Produk Berdasarkan Kategori</h2>
		<div class="flex gap-2">
			<button onclick="openCreateModal()" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 flex items-center gap-2">
				<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
				</svg>
				Tambah Produk
			</button>
            <button onclick="openCategoryModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Kategori
            </button>
		</div>
	</div>

	<div class="space-y-4">
		@foreach($categories as $category)
			<div class="w-full bg-gray-50 rounded-lg border border-gray-200 p-4">
				<div class="flex items-center justify-between">
					<div class="flex items-center gap-4">
						<div class="w-12 h-12 bg-emerald-100 rounded flex items-center justify-center text-emerald-700 font-semibold text-lg">
							{{ Str::substr($category->name,0,1) }}
						</div>
						<div>
							<div class="font-medium text-lg">{{ $category->name }}</div>
							<div class="text-xs text-gray-500">{{ $category->products->count() }} produk</div>
						</div>
					</div>

					<div class="flex items-center gap-2">
						<a href="{{ route('admin.managecategories.edit', $category->id) }}" class="text-sm text-blue-600 hover:underline">Edit</a>
						<button onclick="toggleCategory({{ $category->id }})" class="text-sm px-3 py-1 bg-white border rounded hover:bg-gray-50">Tampilkan</button>
					</div>
				</div>

				<!-- Daftar produk (vertikal) -->
				<div id="cat-{{ $category->id }}" class="mt-3 hidden">
					@if($category->products->count())
						<div class="grid grid-cols-1 gap-3">
							@foreach($category->products as $p)
								<div class="flex items-center gap-4 p-3 bg-white rounded border">
									<div class="w-16 h-16 bg-gray-100 rounded overflow-hidden flex items-center justify-center">
										@if($p->photos && $p->photos->count())
											<img src="{{ asset('storage/' . $p->photos->first()->url) }}" alt="{{ $p->name }}" class="w-full h-full object-cover">
										@else
											<svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"></path>
											</svg>
										@endif
									</div>

									<div class="flex-1 min-w-0">
										<div class="font-semibold truncate">{{ $p->name }}</div>
										<div class="text-xs text-gray-500">Stok: {{ $p->stock }} • Rp {{ number_format($p->price,0,',','.') }}</div>
									</div>

									<div class="flex gap-2">
										<button onclick="openEditModal({{ json_encode($p) }})" class="text-sm bg-amber-500 text-white px-3 py-1 rounded">Edit</button>
										<button onclick="deleteProduct({{ $p->id }})" class="text-sm bg-red-500 text-white px-3 py-1 rounded">Hapus</button>
									</div>
								</div>
							@endforeach
						</div>
					@else
						<div class="text-sm text-gray-500 py-2">Belum ada produk pada kategori ini.</div>
					@endif
				</div>
			</div>
		@endforeach
	</div>
</div>

<!-- Pagination tetap jika perlu -->
{{-- HAPUS BLOK PAGINASI --}}
{{-- 
@if($products->hasPages())
	<div class="mt-6">
		{{ $products->links('vendor.pagination.tailwind') }}
	</div>
@endif
--}}

		</main>
	</div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-xl max-w-lg w-full max-h-screen overflow-y-auto">
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Edit Produk</h3>
                            <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Error Display -->
                        <div id="edit-errors" class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded hidden">
                            <ul id="edit-error-list" class="list-disc list-inside">
                            </ul>
                        </div>
                        
                        <div class="space-y-4">
                            <input type="hidden" name="id" id="edit-id">
                            
                            <div>
                                <label for="edit-name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                                <input type="text" id="edit-name" name="name" required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                            
                            <div>
                                <label for="edit-category" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                                <select id="edit-category" name="category_id" required 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="" disabled>Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="edit-price" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                                    <input type="number" id="edit-price" name="price" required 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                                </div>
                                <div>
                                    <label for="edit-stock" class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                                    <input type="number" id="edit-stock" name="stock" required 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                                </div>
                            </div>
                            
                            <div>
                                <label for="edit-discount" class="block text-sm font-medium text-gray-700 mb-1">Diskon (%)</label>
                                <input type="number" id="edit-discount" name="discount" min="0" max="100" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                            
                            <div>
                                <label for="edit-description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                <textarea id="edit-description" name="description" rows="3" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                            </div>
                            
                            <!-- Existing Photos Display -->
                            <div id="existing-photos-container" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Saat Ini</label>
                                <div id="existing-photos" class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-3">
                                </div>
                            </div>
                            
                            <div>
                                <label for="edit-photos" class="block text-sm font-medium text-gray-700 mb-1">Tambah Foto Baru</label>
                                <input type="file" id="edit-photos" name="photos[]" multiple accept="image/*" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-sm file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                                       onchange="previewEditPhotos(this)">
                                <p class="text-xs text-gray-500 mt-1">Pilih beberapa foto sekaligus untuk ditambahkan</p>
                                
                                <!-- New Photo Preview Container -->
                                <div id="edit-photo-preview" class="mt-3 grid grid-cols-2 sm:grid-cols-3 gap-3 hidden">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-6 py-3 flex justify-end gap-3 rounded-b-xl">
                        <button type="button" onclick="closeEditModal()" 
                                class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 text-sm text-white bg-emerald-600 rounded-lg hover:bg-emerald-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Create Modal -->
    <div id="createModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-xl max-w-lg w-full max-h-screen overflow-y-auto">
                <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Tambah Produk Baru</h3>
                            <button type="button" onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Error Display -->
                        @if($errors->any())
                            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                                <ul class="list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <div class="space-y-4">
                            <div>
                                <label for="create-name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                                <input type="text" id="create-name" name="name" required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                            
                            <div>
                                <label for="create-category" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                                <select id="create-category" name="category_id" required 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="create-price" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                                    <input type="number" id="create-price" name="price" required 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                                </div>
                                <div>
                                    <label for="create-stock" class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                                    <input type="number" id="create-stock" name="stock" required 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                                </div>
                            </div>
                            
                            <div>
                                <label for="create-discount" class="block text-sm font-medium text-gray-700 mb-1">Diskon (%)</label>
                                <input type="number" id="create-discount" name="discount" value="0" min="0" max="100" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                            
                            <div>
                                <label for="create-description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                <textarea id="create-description" name="description" rows="3" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                            </div>
                            
                            <div>
                                <label for="create-photos" class="block text-sm font-medium text-gray-700 mb-1">Foto Produk</label>
                                <input type="file" id="create-photos" name="photos[]" multiple accept="image/*" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-sm file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                                       onchange="previewCreatePhotos(this)">
                                <p class="text-xs text-gray-500 mt-1">Pilih beberapa foto sekaligus (maksimal 10 foto)</p>
                                
                                <!-- Photo Preview Container -->
                                <div id="create-photo-preview" class="mt-3 grid grid-cols-2 sm:grid-cols-3 gap-3 hidden">
                                    <!-- Preview images will be shown here -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-6 py-3 flex justify-end gap-3 rounded-b-xl">
                        <button type="button" onclick="closeCreateModal()" 
                                class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 text-sm text-white bg-emerald-600 rounded-lg hover:bg-emerald-700">
                            Tambah Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Kategori -->
    <div id="categoryModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
            <h2 class="text-lg font-semibold mb-4">Tambah Kategori Baru</h2>

            <form action="{{ route('admin.managecategories.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-1">Nama Kategori</label>
                    <input type="text" id="name" name="name" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" onclick="closeCategoryModal()" class="px-4 py-2 rounded-lg border">Batal</button>
                    <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700">Tambah</button>
                </div>
            </form>

            <!-- Tombol close (X) -->
            <button onclick="closeCategoryModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                &times;
            </button>
        </div>
    </div>

    <script>
        // Modal Functions
        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
        }

        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
            document.querySelector('#createModal form').reset();
            // Clear photo previews
            document.getElementById('create-photo-preview').innerHTML = '';
            document.getElementById('create-photo-preview').classList.add('hidden');
        }

        function openCategoryModal() {
		document.getElementById('categoryModal').classList.remove('hidden');
		document.getElementById('categoryModal').classList.add('flex');
        }
        
        function closeCategoryModal() {
            document.getElementById('categoryModal').classList.add('hidden');
            document.getElementById('categoryModal').classList.remove('flex');
        }

        function openEditModal(product) {
            // Fill form with product data
            document.getElementById('edit-id').value = product.id;
            document.getElementById('edit-name').value = product.name;
            document.getElementById('edit-category').value = product.category_id;
            document.getElementById('edit-price').value = product.price;
            document.getElementById('edit-stock').value = product.stock;
            document.getElementById('edit-discount').value = product.discount || 0;
            document.getElementById('edit-description').value = product.description || '';
            
            // Display existing photos
            displayExistingPhotos(product.photos || []);
            
            // Clear new photo previews
            document.getElementById('edit-photo-preview').innerHTML = '';
            document.getElementById('edit-photo-preview').classList.add('hidden');
            document.getElementById('edit-photos').value = '';
            
            // Set form action
            document.getElementById('editForm').action = `/admin/products/${product.id}`;
            
            // Show modal
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editForm').reset();
            // Clear photo previews and existing photos display
            document.getElementById('edit-photo-preview').innerHTML = '';
            document.getElementById('edit-photo-preview').classList.add('hidden');
            document.getElementById('existing-photos').innerHTML = '';
            document.getElementById('existing-photos-container').classList.add('hidden');
        }

        async function deleteProduct(productId) {
            if (!confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                return;
            }

            try {
                const response = await fetch(`/admin/products/${productId}`, {
                    method: 'DELETE',
                    headers:
                    {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                });

                const result = await response.json();
                
                if (result.success) {
                    alert('Produk berhasil dihapus!');
                    location.reload();
                } else {
                    alert(result.message || 'Gagal menghapus produk');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus produk');
            }
        }

        // Close modals when clicking outside
        document.addEventListener('click', function(event) {
            const createModal = document.getElementById('createModal');
            const editModal = document.getElementById('editModal');
            
            if (event.target === createModal) {
                closeCreateModal();
            }
            if (event.target === editModal) {
                closeEditModal();
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeCreateModal();
                closeEditModal();
            }
        });

        // Add form submit debugging
        document.addEventListener('DOMContentLoaded', function() {
            // Debug create form submission
            const createForm = document.querySelector('#createModal form');
            if (createForm) {
                createForm.addEventListener('submit', function(e) {
                    console.log('Create form submitting...');
                    console.log('Form action:', this.action);
                    console.log('Form method:', this.method);
                    console.log('Form enctype:', this.enctype);
                    
                    const formData = new FormData(this);
                    let fileCount = 0;
                    let debugInfo = [];
                    
                    console.log('FormData entries:');
                    for (let [key, value] of formData.entries()) {
                        if (value instanceof File) {
                            console.log(key + ':', value.name, value.type, value.size + ' bytes');
                            debugInfo.push(key + ': ' + value.name + ' (' + value.type + ', ' + value.size + ' bytes)');
                            fileCount++;
                        } else {
                            console.log(key + ':', value);
                            debugInfo.push(key + ': ' + value);
                        }
                    }
                    
                    // Log file info (no alert)
                    if (fileCount > 0) {
                        console.log('Found ' + fileCount + ' files for submission');
                    } else {
                        console.log('No files detected in form');
                    }
                });
            }

            // Debug edit form submission
            const editForm = document.querySelector('#editForm');
            if (editForm) {
                editForm.addEventListener('submit', function(e) {
                    console.log('Edit form submitting...');
                    console.log('Form action:', this.action);
                    console.log('Form method:', this.method);
                    console.log('Form enctype:', this.enctype);
                    
                    const formData = new FormData(this);
                    let fileCount = 0;
                    let debugInfo = [];
                    
                    console.log('Edit FormData entries:');
                    for (let [key, value] of formData.entries()) {
                        if (value instanceof File) {
                            console.log(key + ':', value.name, value.type, value.size + ' bytes');
                            debugInfo.push(key + ': ' + value.name + ' (' + value.type + ', ' + value.size + ' bytes)');
                            fileCount++;
                        } else {
                            console.log(key + ':', value);
                            debugInfo.push(key + ': ' + value);
                        }
                    }
                    
                    // Log file info for edit (no alert)
                    if (fileCount > 0) {
                        console.log('Found ' + fileCount + ' files for edit submission');
                    } else {
                        console.log('No files detected in edit form');
                    }
                });
            }
        });

        // Photo preview functions
        function previewCreatePhotos(input) {
            console.log('previewCreatePhotos called', input.files);
            const previewContainer = document.getElementById('create-photo-preview');
            previewContainer.innerHTML = '';
            
            if (input.files && input.files.length > 0) {
                console.log('Files selected:', input.files.length);
                previewContainer.classList.remove('hidden');
                
                // Limit to 10 photos
                const filesToProcess = Math.min(input.files.length, 10);
                
                for (let i = 0; i < filesToProcess; i++) {
                    const file = input.files[i];
                    console.log('Processing file:', file.name, file.type, file.size);
                    
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const photoDiv = document.createElement('div');
                            photoDiv.className = 'relative group';
                            photoDiv.innerHTML = `
                                <img src="${e.target.result}" alt="Preview" class="w-full h-20 object-cover rounded-lg border border-gray-200">
                                <button type="button" onclick="removePreviewPhoto(this, 'create')" 
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 text-xs hover:bg-red-600 opacity-0 group-hover:opacity-100 transition-opacity">
                                    ×
                                </button>
                                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs p-1 rounded-b-lg">
                                    ${file.name} (${(file.size/1024).toFixed(1)}KB)
                                </div>
                            `;
                            previewContainer.appendChild(photoDiv);
                        };
                        reader.readAsDataURL(file);
                    } else {
                        console.log('File rejected (not image):', file.name);
                    }
                }
                
                if (input.files.length > 10) {
                    alert('Maksimal 10 foto yang dapat dipilih. Hanya 10 foto pertama yang akan diproses.');
                }
            } else {
                previewContainer.classList.add('hidden');
            }
        }

        function previewEditPhotos(input) {
            console.log('previewEditPhotos called', input.files);
            const previewContainer = document.getElementById('edit-photo-preview');
            previewContainer.innerHTML = '';
            
            if (input.files && input.files.length > 0) {
                console.log('Edit files selected:', input.files.length);
                previewContainer.classList.remove('hidden');
                
                // Limit to 10 photos
                const filesToProcess = Math.min(input.files.length, 10);
                
                for (let i = 0; i < filesToProcess; i++) {
                    const file = input.files[i];
                    console.log('Processing edit file:', file.name, file.type, file.size);
                    
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const photoDiv = document.createElement('div');
                            photoDiv.className = 'relative group';
                            photoDiv.innerHTML = `
                                <img src="${e.target.result}" alt="Preview" class="w-full h-20 object-cover rounded-lg border border-gray-200">
                                <button type="button" onclick="removePreviewPhoto(this, 'edit')" 
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 text-xs hover:bg-red-600 opacity-0 group-hover:opacity-100 transition-opacity">
                                    ×
                                </button>
                                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs p-1 rounded-b-lg">
                                    ${file.name} (${(file.size/1024).toFixed(1)}KB)
                                </div>
                            `;
                            previewContainer.appendChild(photoDiv);
                        };
                        reader.readAsDataURL(file);
                    } else {
                        console.log('Edit file rejected (not image):', file.name);
                    }
                }
                
                if (input.files.length > 10) {
                    alert('Maksimal 10 foto yang dapat dipilih. Hanya 10 foto pertama yang akan diproses.');
                }
            } else {
                previewContainer.classList.add('hidden');
            }
        }

        function displayExistingPhotos(photos) {
            const existingPhotosContainer = document.getElementById('existing-photos');
            const existingPhotosWrapper = document.getElementById('existing-photos-container');
            
            existingPhotosContainer.innerHTML = '';
            
            if (photos && photos.length > 0) {
                existingPhotosWrapper.classList.remove('hidden');
                
                photos.forEach((photo, index) => {
                    const photoDiv = document.createElement('div');
                    photoDiv.className = 'relative group';
                    photoDiv.innerHTML = `
                        <img src="/storage/${photo.url}" alt="Existing photo" class="w-full h-20 object-cover rounded-lg border border-gray-200">
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                            <button type="button" onclick="deleteExistingPhoto(${photo.id}, this)" 
                                    class="bg-red-500 text-white rounded-full w-8 h-8 text-sm hover:bg-red-600">
                                ×
                            </button>
                        </div>
                        ${photo.is_primary ? '<div class="absolute top-1 left-1 bg-emerald-500 text-white text-xs px-1 rounded">Utama</div>' : ''}
                    `;
                    existingPhotosContainer.appendChild(photoDiv);
                });
            } else {
                existingPhotosWrapper.classList.add('hidden');
            }
        }

        function removePreviewPhoto(button, type) {
            const photoDiv = button.parentElement;
            photoDiv.remove();
            
            const previewContainer = document.getElementById(type + '-photo-preview');
            if (previewContainer.children.length === 0) {
                previewContainer.classList.add('hidden');
            }
        }

        async function deleteExistingPhoto(photoId, buttonElement) {
            console.log('deleteExistingPhoto called with ID:', photoId);
            
            if (!confirm('Apakah Anda yakin ingin menghapus foto ini?')) {
                console.log('User cancelled deletion');
                return;
            }

            console.log('User confirmed deletion. Processing...');

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                console.log('CSRF Token:', csrfToken);
                
                const url = `/admin/photos/${photoId}`;
                console.log('Request URL:', url);
                
                const response = await fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                });
                
                console.log('Request sent successfully');

                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers.get('content-type'));

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();
                console.log('Delete result:', result);
                
                if (result.success) {
                    // Remove photo from display
                    const photoElement = buttonElement.closest('.relative.group');
                    photoElement.remove();
                    
                    // Hide container if no photos left
                    const existingPhotosContainer = document.getElementById('existing-photos');
                    if (existingPhotosContainer.children.length === 0) {
                        document.getElementById('existing-photos-container').classList.add('hidden');
                    }
                    
                    console.log('Photo successfully deleted from UI');
                } else {
                    console.error('Delete failed:', result.message);
                    alert(result.message || 'Gagal menghapus foto');
                }
            } catch (error) {
                console.error('Error deleting photo:', error);
                alert('Terjadi kesalahan saat menghapus foto: ' + error.message);
            }
        }

        // Add some utility styles
        const style = document.createElement('style');
        style.textContent = `
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
        `;
        document.head.appendChild(style);

        // Toggle category dropdown (scroll vertical saat dibuka)
        function toggleCategory(id){
            const el = document.getElementById('cat-' + id);
            if(!el) return;
            el.classList.toggle('hidden');
            if(!el.classList.contains('hidden')){
                // scroll parent category container into view (vertically)
                const parent = el.closest('div[w-full]') || el.closest('.w-full');
                (el).scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    </script>

</body>
</html>