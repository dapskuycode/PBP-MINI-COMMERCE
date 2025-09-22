@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Edit Produk') }}</h5>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Nama Produk') }} <span class="text-danger">*</span></label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name', $product->name) }}" required autocomplete="name" autofocus>
                            @error('name')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">{{ __('Kategori') }} <span class="text-danger">*</span></label>
                            <select id="category_id" class="form-select @error('category_id') is-invalid @enderror"
                                    name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Deskripsi') }}</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror"
                                      name="description" rows="4" placeholder="Deskripsi produk (opsional)">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">{{ __('Gambar Produk') }}</label>

                            @if($product->image)
                                <div class="mb-3">
                                    <label class="form-label">Gambar Saat Ini:</label>
                                    <div class="border rounded p-2" style="width: 200px; height: 200px; overflow: hidden;">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                </div>
                            @endif

                            <input id="image" type="file" class="form-control @error('image') is-invalid @enderror"
                                   name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                            <div class="form-text">
                                Format: JPEG, PNG, JPG, GIF. Maksimal 2MB.
                                {{ $product->image ? 'Kosongkan jika tidak ingin mengubah gambar.' : '' }}
                            </div>

                            <!-- Image Preview -->
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <label class="form-label">Preview Gambar Baru:</label>
                                <div class="border rounded p-2" style="width: 200px; height: 200px; overflow: hidden;">
                                    <img id="previewImg" src="" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            </div>
                        </div>                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">{{ __('Harga') }} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input id="price" type="number" class="form-control @error('price') is-invalid @enderror"
                                               name="price" value="{{ old('price', $product->price) }}" required min="0" step="0.01"
                                               placeholder="0">
                                        @error('price')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="stock" class="form-label">{{ __('Stok') }} <span class="text-danger">*</span></label>
                                    <input id="stock" type="number" class="form-control @error('stock') is-invalid @enderror"
                                           name="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                                           placeholder="0">
                                    @error('stock')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted">
                                <span class="text-danger">*</span> Field wajib diisi
                            </small>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Format number input for price
    const priceInput = document.getElementById('price');
    priceInput.addEventListener('input', function(e) {
        // Remove any non-digit characters except decimal point
        let value = e.target.value.replace(/[^\d.]/g, '');
        e.target.value = value;
    });

    // Image preview functionality
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Check file type
            if (!file.type.startsWith('image/')) {
                alert('Please select an image file');
                this.value = '';
                imagePreview.style.display = 'none';
                return;
            }

            // Check file size (2MB = 2048KB)
            if (file.size > 2048 * 1024) {
                alert('File size must be less than 2MB');
                this.value = '';
                imagePreview.style.display = 'none';
                return;
            }

            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = 'none';
        }
    });
});
</script>
@endsection
