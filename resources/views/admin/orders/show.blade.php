<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan #{{ $transformedOrder['code'] ?? 'Unknown' }} • TumbasLek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        {{-- Sidebar --}}
        <aside class="w-64 bg-white border-r">
            <div class="p-4 text-center border-b">
                <img src="{{ asset('images/logo.png') }}" alt="TumbasLek" class="mx-auto w-16 mb-2">
                <h1 class="text-lg font-semibold text-emerald-700">TumbasLek</h1>
                <p class="text-xs text-gray-500">UMKM Mini-Commerce</p>
            </div>
            <nav class="p-4 space-y-2 text-sm">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium text-gray-700 hover:bg-gray-100 hover:text-emerald-700">
                    <i class="lucide lucide-home"></i> Dashboard
                </a>
                <a href="{{ route('admin.managecategories.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium text-gray-700 hover:bg-gray-100 hover:text-emerald-700">
                    <i class="lucide lucide-box"></i> Manajemen Produk
                </a>
                <a href="{{ route('admin.manageorders.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium bg-emerald-100 text-emerald-700">
                    <i class="lucide lucide-shopping-bag"></i> Manajemen Pesanan
                </a>
                <a href="{{ route('admin.manageusers.showUsers') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium text-gray-700 hover:bg-gray-100 hover:text-emerald-700">
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

        <!-- Main Content -->
        <main class="flex-1 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('admin.manageorders.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke Manajemen Pesanan
                </a>
            </div>

            {{-- Header --}}
            <div class="bg-white rounded-2xl shadow-sm border p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold">Detail Pesanan #{{ $transformedOrder['code'] ?? 'Unknown' }}</h1>
                        <p class="text-sm text-gray-500">{{ $transformedOrder['date'] ?? 'Unknown date' }}</p>
                    </div>
                    <div class="text-right">
                        <span class="px-3 py-1 rounded-full text-sm 
                            @if(($transformedOrder['status'] ?? '') === 'dikemas') bg-purple-100 text-purple-700
                            @elseif(($transformedOrder['status'] ?? '') === 'dikirim') bg-blue-100 text-blue-700
                            @elseif(($transformedOrder['status'] ?? '') === 'selesai') bg-emerald-100 text-emerald-700
                            @elseif(($transformedOrder['status'] ?? '') === 'dibatalkan') bg-red-100 text-red-700
                            @else bg-gray-100 text-gray-700
                            @endif">
                            @switch($transformedOrder['status'] ?? '')
                                @case('dikemas') Dikemas @break
                                @case('dikirim') Sedang Dikirim @break
                                @case('selesai') Selesai @break
                                @case('dibatalkan') Dibatalkan @break
                                @default {{ $transformedOrder['status'] ?? 'Unknown' }}
                            @endswitch
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Customer Information --}}
                <div class="bg-white rounded-2xl shadow-sm border p-6">
                    <h2 class="text-lg font-semibold mb-4">Informasi Customer</h2>
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm text-gray-500">Nama Customer</label>
                            <p class="font-medium">{{ $transformedOrder['customer'] ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Nomor Telepon</label>
                            <p class="font-medium">{{ $transformedOrder['phone'] ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Email</label>
                            <p class="font-medium">{{ $transformedOrder['user_email'] ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Alamat Lengkap</label>
                            <p class="font-medium">{{ $transformedOrder['address'] ?? 'N/A' }}</p>
                        </div>
                        @if(($transformedOrder['kota'] ?? '') !== 'N/A')
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm text-gray-500">Kota</label>
                                <p class="font-medium">{{ $transformedOrder['kota'] ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Kode Pos</label>
                                <p class="font-medium">{{ $transformedOrder['kode_pos'] ?? 'N/A' }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Payment & Shipping --}}
                <div class="bg-white rounded-2xl shadow-sm border p-6">
                    <h2 class="text-lg font-semibold mb-4">Pembayaran & Pengiriman</h2>
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm text-gray-500">Metode Pembayaran</label>
                            <p class="font-medium">{{ $transformedOrder['payment_method'] ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Jenis Pengiriman</label>
                            <p class="font-medium">{{ $transformedOrder['shipping'] ?? 'N/A' }}</p>
                        </div>
                        @if($transformedOrder['nomor_resi'] ?? false)
                        <div>
                            <label class="text-sm text-gray-500">Nomor Resi</label>
                            <p class="font-medium text-purple-600">{{ $transformedOrder['nomor_resi'] }}</p>
                        </div>
                        @endif
                        <div class="border-t pt-3">
                            <label class="text-sm text-gray-500">Total Pembayaran</label>
                            <p class="text-2xl font-bold text-emerald-600">
                                {{ 'Rp ' . number_format($transformedOrder['total'] ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Order Items --}}
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border p-6">
                    <h2 class="text-lg font-semibold mb-4">Items Pesanan</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-3">Produk</th>
                                    <th class="text-center py-3">Qty</th>
                                    <th class="text-right py-3">Harga</th>
                                    <th class="text-right py-3">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transformedOrder['items'] ?? [] as $item)
                                <tr class="border-b">
                                    <td class="py-3">
                                        <div class="font-medium">{{ $item['name'] ?? 'Unknown Product' }}</div>
                                    </td>
                                    <td class="py-3 text-center">{{ $item['qty'] ?? 0 }}</td>
                                    <td class="py-3 text-right">{{ 'Rp ' . number_format($item['price'] ?? 0, 0, ',', '.') }}</td>
                                    <td class="py-3 text-right font-medium">{{ 'Rp ' . number_format($item['subtotal'] ?? 0, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="border-t-2">
                                    <td colspan="3" class="py-3 text-right font-semibold">Total:</td>
                                    <td class="py-3 text-right text-lg font-bold text-emerald-600">
                                        {{ 'Rp ' . number_format($transformedOrder['total'] ?? 0, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                {{-- Action Buttons --}}
                @if(($transformedOrder['status'] ?? '') !== 'selesai' && ($transformedOrder['status'] ?? '') !== 'dibatalkan')
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border p-6">
                    <h2 class="text-lg font-semibold mb-4">Aksi Pesanan</h2>
                    <div class="flex flex-wrap gap-3">
                        @if(($transformedOrder['status'] ?? '') === 'dikemas')
                            <form method="POST" action="{{ route('admin.manageorders.shipOrder', $order->id) }}" class="inline" id="shipForm">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="nomor_resi" id="hiddenNomorResi">
                                <button type="button" onclick="showShipModal()" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                                    Kirim Pesanan
                                </button>
                            </form>
                        @elseif(($transformedOrder['status'] ?? '') === 'dikirim')
                            <form method="POST" action="{{ route('admin.manageorders.updateStatus', $order->id) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700" onclick="return confirm('Tandai pesanan ini sebagai selesai?')">
                                    Tandai Selesai
                                </button>
                            </form>
                        @endif
                        
                        <form method="POST" action="{{ route('admin.manageorders.updateStatus', $order->id) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700" onclick="return confirm('Batalkan pesanan ini?')">
                                Batalkan Pesanan
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>

            <div class="h-6"></div>
        </main>
    </div>

    <!-- Modal Input Nomor Resi -->
    <div id="shipModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeShipModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Kirim Pesanan
                            </h3>
                            <div class="mt-4">
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600">Pesanan: <span class="font-semibold">#{{ $transformedOrder['code'] ?? 'Unknown' }}</span></p>
                                    <p class="text-sm text-gray-600">Customer: <span class="font-semibold">{{ $transformedOrder['customer'] ?? 'N/A' }}</span></p>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="nomorResi" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nomor Resi <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        id="nomorResi" 
                                        placeholder="Masukkan nomor resi pengiriman"
                                        class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 px-4 py-2"
                                        required>
                                    <p class="text-xs text-gray-500 mt-1">Contoh: JNE123456789, TIKI987654321, POS555666777</p>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ekspedisi</label>
                                    <p class="text-sm text-gray-600">{{ $transformedOrder['shipping'] ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button onclick="submitShipOrder()" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Kirim Pesanan
                    </button>
                    <button onclick="closeShipModal()" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showShipModal() {
            document.getElementById('shipModal').classList.remove('hidden');
        }
        
        function closeShipModal() {
            document.getElementById('shipModal').classList.add('hidden');
            document.getElementById('nomorResi').value = '';
        }
        
        function submitShipOrder() {
            const nomorResi = document.getElementById('nomorResi').value.trim();
            
            if (!nomorResi) {
                alert('Nomor resi harus diisi');
                return;
            }
            
            if (confirm('Kirim pesanan ini dengan nomor resi: ' + nomorResi + '?')) {
                document.getElementById('hiddenNomorResi').value = nomorResi;
                document.getElementById('shipForm').submit();
            }
        }
    </script>

    @if(session('success'))
        <script>
            alert('{{ session('success') }}');
        </script>
    @endif

    @if(session('error'))
        <script>
            alert('{{ session('error') }}');
        </script>
    @endif
</body>
</html>