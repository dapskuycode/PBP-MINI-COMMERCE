<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Mini Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background: var(--primary-gradient) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.2);
            border: none;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }

        .nav-link {
            color: white !important;
            font-weight: 500;
            margin: 0 10px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #f8f9fa !important;
            transform: translateY(-2px);
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 25px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: white;
            color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.3);
        }

        .profile-container {
            padding: 100px 0 50px;
        }

        .profile-header {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 120px;
            background: var(--primary-gradient);
            border-radius: 20px 20px 0 0;
        }

        .profile-avatar {
            position: relative;
            z-index: 2;
            width: 120px;
            height: 120px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            font-size: 3rem;
            color: #667eea;
            border: 5px solid white;
        }

        .profile-name {
            position: relative;
            z-index: 2;
            color: white;
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .profile-email {
            position: relative;
            z-index: 2;
            color: rgba(255, 255, 255, 0.9);
            text-align: center;
            font-size: 1.1rem;
            margin-bottom: 30px;
        }

        .profile-stats {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-top: 20px;
        }

        .stat-item {
            text-align: center;
            color: white;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            display: block;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .profile-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .info-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: none;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-gradient);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #718096;
            font-weight: 500;
        }

        .info-value {
            color: #2d3748;
            font-weight: 600;
        }

        .btn-edit {
            background: var(--secondary-gradient);
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(240, 147, 251, 0.4);
            color: white;
        }

        .btn-logout {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
            color: white;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            background: var(--success-gradient);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 2px;
        }

        .activity-time {
            color: #718096;
            font-size: 0.85rem;
        }

        .badge-status {
            background: var(--success-gradient);
            color: white;
            border-radius: 20px;
            padding: 5px 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .profile-content {
                grid-template-columns: 1fr;
            }

            .profile-stats {
                gap: 20px;
            }

            .profile-header {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-shopping-bag me-2"></i>Mini Commerce
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">
                            <i class="fas fa-home me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/#categories') }}">
                            <i class="fas fa-th-large me-1"></i>Kategori
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/#products') }}">
                            <i class="fas fa-box me-1"></i>Produk
                        </a>
                    </li>
                </ul>

                <div class="navbar-nav">
                    <a href="{{ url('/') }}" class="btn btn-back">
                        <i class="fas fa-arrow-left me-1"></i>Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Profile Content -->
    <div class="profile-container">
        <div class="container">
            <!-- Profile Header -->
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <h1 class="profile-name">{{ Auth::user()->name }}</h1>
                <p class="profile-email">{{ Auth::user()->email }}</p>

                <div class="profile-stats">
                    <div class="stat-item">
                        <span class="stat-number">24</span>
                        <span class="stat-label">Pesanan</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">5</span>
                        <span class="stat-label">Ulasan</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">2</span>
                        <span class="stat-label">Tahun Bergabung</span>
                    </div>
                </div>
            </div>

            <!-- Profile Content Grid -->
            <div class="profile-content">
                <!-- Personal Information -->
                <div class="info-card">
                    <h3 class="card-title">
                        <div class="card-icon">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        Informasi Pribadi
                    </h3>

                    <div class="info-item">
                        <span class="info-label">Nama Lengkap</span>
                        <span class="info-value">{{ Auth::user()->name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email</span>
                        <span class="info-value">{{ Auth::user()->email }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Nomor Telepon</span>
                        <span class="info-value">+62 812-3456-7890</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Tanggal Lahir</span>
                        <span class="info-value">15 Januari 1990</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Jenis Kelamin</span>
                        <span class="info-value">Laki-laki</span>
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-edit">
                            <i class="fas fa-edit me-2"></i>Edit Informasi
                        </button>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="info-card">
                    <h3 class="card-title">
                        <div class="card-icon">
                            <i class="fas fa-cog"></i>
                        </div>
                        Informasi Akun
                    </h3>

                    <div class="info-item">
                        <span class="info-label">ID Pengguna</span>
                        <span class="info-value">#MC{{ str_pad(Auth::user()->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Status Akun</span>
                        <span class="badge-status">{{ Auth::user()->email_verified_at ? 'Terverifikasi' : 'Belum Terverifikasi' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Bergabung Sejak</span>
                        <span class="info-value">{{ Auth::user()->created_at->format('d F Y') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Terakhir Login</span>
                        <span class="info-value">{{ Auth::user()->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Level Member</span>
                        <span class="info-value">{{ ucfirst(Auth::user()->role) }} Member</span>
                    </div>

                    <div class="mt-3">
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-logout">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="info-card">
                    <h3 class="card-title">
                        <div class="card-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        Alamat Pengiriman
                    </h3>

                    <div class="info-item">
                        <span class="info-label">Alamat Utama</span>
                        <span class="info-value">Jl. Sudirman No. 123</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Kota</span>
                        <span class="info-value">Jakarta Pusat</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Provinsi</span>
                        <span class="info-value">DKI Jakarta</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Kode Pos</span>
                        <span class="info-value">10270</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Negara</span>
                        <span class="info-value">Indonesia</span>
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-edit">
                            <i class="fas fa-plus me-2"></i>Kelola Alamat
                        </button>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="info-card">
                    <h3 class="card-title">
                        <div class="card-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        Aktivitas Terbaru
                    </h3>

                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Pesanan baru dibuat</div>
                            <div class="activity-time">2 jam yang lalu</div>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Memberikan ulasan produk</div>
                            <div class="activity-time">1 hari yang lalu</div>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Pesanan telah diterima</div>
                            <div class="activity-time">3 hari yang lalu</div>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Menambah ke wishlist</div>
                            <div class="activity-time">5 hari yang lalu</div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-edit">
                            <i class="fas fa-list me-2"></i>Lihat Semua Aktivitas
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        // Edit information buttons
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                const cardTitle = this.closest('.info-card').querySelector('.card-title').textContent.trim();
                alert('Edit ' + cardTitle + '\n\nFitur edit akan diimplementasikan dengan form yang sesuai.');
            });
        });

        // Logout button - removed since we now use form submission
        // document.querySelector('.btn-logout').addEventListener('click', function() {
        //     if (confirm('Apakah Anda yakin ingin logout?')) {
        //         alert('Logout berhasil!\n\nAnda akan diarahkan ke halaman utama.');
        //         window.location.href = '{{ url("/") }}';
        //     }
        // });

        // Navbar background change on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'var(--primary-gradient)';
                navbar.style.backdropFilter = 'blur(10px)';
            } else {
                navbar.style.background = 'var(--primary-gradient)';
            }
        });

        // Card hover animations
        document.querySelectorAll('.info-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.02)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Profile avatar click
        document.querySelector('.profile-avatar').addEventListener('click', function() {
            alert('Fitur upload foto profil akan segera tersedia!');
        });
    </script>
</body>
</html>
