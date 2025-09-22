@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Detail Produk') }}</h5>
                    <div>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if($product->image)
                        <div class="row mb-4">
                            <div class="col-12 text-center">
                                <h6 class="text-muted">Gambar Produk</h6>
                                <div class="d-inline-block border rounded p-2" style="max-width: 400px;">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                         class="img-fluid rounded" style="max-height: 300px; width: auto;">
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Nama Produk</h6>
                            <p class="fs-5 fw-bold">{{ $product->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Kategori</h6>
                            <p>
                                <span class="badge bg-primary">{{ $product->category->name }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Harga</h6>
                            <p class="fs-4 fw-bold text-success">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Stok</h6>
                            <p class="fs-5">
                                <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $product->stock }} unit
                                </span>
                            </p>
                        </div>
                    </div>

                    @if($product->description)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="text-muted">Deskripsi</h6>
                                <p class="text-justify">{{ $product->description }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Tanggal Dibuat</h6>
                            <p>{{ $product->created_at->format('d F Y, H:i') }} WIB</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Terakhir Diperbarui</h6>
                            <p>{{ $product->updated_at->format('d F Y, H:i') }} WIB</p>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <div>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.')">
                                    <i class="fas fa-trash"></i> Hapus Produk
                                </button>
                            </form>
                        </div>
                        <div>
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Produk
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
