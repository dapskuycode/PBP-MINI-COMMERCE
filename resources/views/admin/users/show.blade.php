@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Detail User') }}</h5>
                    <div>
                        @if($user->id !== auth()->id())
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        @endif
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Nama Lengkap</h6>
                            <p class="fs-5 fw-bold">{{ $user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Email</h6>
                            <p class="fs-6">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Role</h6>
                            <p>
                                <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : 'bg-primary' }} fs-6">
                                    {{ ucfirst($user->role) }}
                                </span>
                                @if($user->id === auth()->id())
                                    <span class="badge bg-warning">Anda</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Status Akun</h6>
                            <p>
                                <span class="badge bg-success">Aktif</span>
                            </p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Tanggal Bergabung</h6>
                            <p>{{ $user->created_at->format('d F Y, H:i') }} WIB</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Terakhir Diperbarui</h6>
                            <p>{{ $user->updated_at->format('d F Y, H:i') }} WIB</p>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="text-muted">Hak Akses {{ ucfirst($user->role) }}</h6>
                            @if($user->role === 'admin')
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check text-success me-2"></i>Mengelola Produk & Kategori</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Mengelola User & Role</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Melihat Dashboard Admin</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Akses Laporan & Analytics</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Mengelola Pesanan</li>
                                </ul>
                            @else
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check text-success me-2"></i>Browse & Beli Produk</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Mengelola Keranjang Belanja</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Melihat Riwayat Pesanan</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Memberikan Review Produk</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Mengelola Profile</li>
                                </ul>
                            @endif
                        </div>
                    </div>

                    <hr>

                    @if($user->id !== auth()->id())
                        <div class="d-flex justify-content-between">
                            <div>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan.')">
                                        <i class="fas fa-trash"></i> Hapus User
                                    </button>
                                </form>
                            </div>
                            <div>
                                <!-- Quick Role Change -->
                                <form action="{{ route('admin.users.change-role', $user) }}" method="POST" class="d-inline me-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="role" value="{{ $user->role === 'admin' ? 'buyer' : 'admin' }}">
                                    <button type="submit" class="btn btn-outline-primary"
                                            onclick="return confirm('Apakah Anda yakin ingin mengubah role user ini?')">
                                        <i class="fas fa-exchange-alt"></i>
                                        Ubah ke {{ $user->role === 'admin' ? 'Buyer' : 'Admin' }}
                                    </button>
                                </form>

                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit User
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Ini adalah akun Anda. Anda tidak dapat menghapus atau mengubah role akun Anda sendiri untuk keamanan sistem.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
