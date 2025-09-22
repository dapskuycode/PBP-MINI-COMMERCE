<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Mini Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --admin-gradient: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background: var(--admin-gradient) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(255, 107, 107, 0.2);
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

        .main-content {
            padding-top: 100px;
            min-height: 100vh;
        }

        .admin-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
        }

        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            text-align: center;
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin: 0 auto 15px;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 5px;
        }

        .stats-label {
            color: #718096;
            font-weight: 500;
        }

        .btn-admin {
            background: var(--admin-gradient);
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-admin:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
            color: white;
        }

        .page-title {
            color: #2d3748;
            font-weight: 700;
            margin-bottom: 30px;
        }

        .quick-actions {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .action-btn {
            background: var(--primary-gradient);
            border: none;
            border-radius: 10px;
            padding: 15px 20px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
            margin-bottom: 15px;
            text-align: center;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .action-btn:last-child {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-shield-alt me-2"></i>Admin Panel
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.products.index') }}">
                            <i class="fas fa-box me-1"></i>Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.users.index') }}">
                            <i class="fas fa-users me-1"></i>Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-chart-bar me-1"></i>Reports
                        </a>
                    </li>
                </ul>

                <div class="navbar-nav">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-light me-2">
                        <i class="fas fa-store me-1"></i>Ke Toko
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-2"></i>{{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="fas fa-user-circle me-2"></i>Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger" style="border: none; background: none;">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show position-fixed" style="top: 80px; right: 20px; z-index: 1050; max-width: 400px;" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show position-fixed" style="top: 80px; right: 20px; z-index: 1050; max-width: 400px;" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <h1 class="page-title">
                <i class="fas fa-tachometer-alt me-3"></i>Admin Dashboard
            </h1>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="stats-card">
                        <div class="stats-icon" style="background: var(--primary-gradient);">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stats-number">{{ $totalProducts ?? 0 }}</div>
                        <div class="stats-label">Total Produk</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stats-card">
                        <div class="stats-icon" style="background: var(--success-gradient);">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stats-number">{{ $totalUsers ?? 0 }}</div>
                        <div class="stats-label">Total Users</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stats-card">
                        <div class="stats-icon" style="background: var(--admin-gradient);">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="stats-number">{{ $totalOrders ?? 0 }}</div>
                        <div class="stats-label">Total Orders</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stats-card">
                        <div class="stats-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stats-number">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div>
                        <div class="stats-label">Total Revenue</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Welcome Message -->
                <div class="col-md-8 mb-4">
                    <div class="admin-card">
                        <h3 class="mb-3">
                            <i class="fas fa-hand-wave me-2" style="color: #f39c12;"></i>
                            Selamat Datang, {{ Auth::user()->name }}!
                        </h3>
                        <p class="text-muted mb-4">
                            Anda login sebagai <strong>Administrator</strong>. Dari sini Anda dapat mengelola seluruh aspek Mini Commerce,
                            termasuk menambah produk baru, mengelola user, dan melihat laporan penjualan.
                        </p>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <h5>
                                    <i class="fas fa-key me-2 text-primary"></i>Akses Admin
                                </h5>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check text-success me-2"></i>Mengelola Produk</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Mengelola Kategori</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Melihat Laporan</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Mengelola User</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5>
                                    <i class="fas fa-info-circle me-2 text-info"></i>Tips
                                </h5>
                                <p class="text-muted small">
                                    Mulai dengan menambahkan beberapa kategori dan produk untuk mengisi toko Anda.
                                    Pastikan informasi produk lengkap untuk pengalaman buyer yang terbaik.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="col-md-4 mb-4">
                    <div class="quick-actions">
                        <h5 class="mb-3">
                            <i class="fas fa-bolt me-2"></i>Quick Actions
                        </h5>
                        <a href="{{ route('admin.products.create') }}" class="action-btn">
                            <i class="fas fa-plus me-2"></i>Tambah Produk Baru
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="action-btn">
                            <i class="fas fa-list me-2"></i>Lihat Semua Produk
                        </a>
                        <a href="#" class="action-btn">
                            <i class="fas fa-chart-bar me-2"></i>Lihat Laporan
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="action-btn">
                            <i class="fas fa-users-cog me-2"></i>Kelola Users
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <div class="col-12">
                    <div class="admin-card">
                        <h5 class="mb-3">
                            <i class="fas fa-clock me-2"></i>Aktivitas Terbaru
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Waktu</th>
                                        <th>Aktivitas</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><small class="text-muted">{{ now()->subMinutes(5)->format('H:i') }}</small></td>
                                        <td>Admin login ke sistem</td>
                                        <td><span class="badge bg-success">Success</span></td>
                                    </tr>
                                    <tr>
                                        <td><small class="text-muted">{{ now()->subHours(2)->format('H:i') }}</small></td>
                                        <td>User baru mendaftar</td>
                                        <td><span class="badge bg-info">New</span></td>
                                    </tr>
                                    <tr>
                                        <td><small class="text-muted">{{ now()->subHours(3)->format('H:i') }}</small></td>
                                        <td>Produk baru ditambahkan</td>
                                        <td><span class="badge bg-primary">Added</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Add loading states to action buttons
        document.querySelectorAll('.action-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                if (!this.classList.contains('loading')) {
                    this.classList.add('loading');
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
                }
            });
        });
    </script>
</body>
</html>
