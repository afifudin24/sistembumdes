@extends('layouts.dashboard')

@section('content')
<main class="content">
				<div class="container-fluid p-0">
               <form method="GET" action="{{ route('pesan') }}" id="filterForm">
    <div class="mb-3 col-3">
        <select class="form-select" name="usaha_id" onchange="document.getElementById('filterForm').submit()">
            <option value="">Semua</option>
            @foreach($usaha as $item)
                <option value="{{ $item->usaha_id }}" {{ request('usaha_id') == $item->usaha_id ? 'selected' : '' }}>
                    {{ $item->nama_usaha }}
                </option>
            @endforeach
        </select>
    </div>
</form>


<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
    @if($produk->isEmpty())
    <div class="alert alert-danger" role="alert">
        Data produk tidak ditemukan
        </div>
    @endif

    @foreach($produk as $item)
    <div class="col">
        <div class="card h-100 text-center shadow-sm">
            <img src="{{ asset('storage/'.$item->gambar) }}" class="card-img-top" alt="{{ $item->nama_produk }}" style="height: 200px; object-fit: cover;">
            <div class="card-body d-flex flex-column justify-content-between">
                <h5 class="card-title">{{ $item->nama_produk }}</h5>
                <p class="card-text">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>

                <div class="d-flex justify-content-center align-items-center mb-2">
                    <button class="btn btn-outline-secondary btn-sm me-2 quantity-decrease" data-id="{{ $item->produk_id }}">-</button>
                    <input type="number" name="quantity[{{ $item->produk_id }}]" value="1" min="1" class="form-control text-center quantity-input" data-id="{{ $item->produk_id }}" style="width: 60px;">
                    <button class="btn btn-outline-primary btn-sm ms-2 quantity-increase" data-id="{{ $item->produk_id }}">+</button>
                </div>

           <button
    class="btn btn-success w-100 btn-sm add-to-cart"
    data-id="{{ $item->produk_id }}"
    data-nama="{{ $item->nama_produk }}"
    data-harga="{{ $item->harga }}"
>
    Tambah ke keranjang
</button>
            </div>
        </div>
    </div>
    @endforeach
</div>


				</div>
			</main>
            <!-- Tombol Buka Keranjang -->
<button id="openCartBtn" class="btn btn-secondary position-fixed" style="top: 100px; right: 20px; z-index: 9999;">
    <i  data-feather="shopping-cart"></i> Keranjang (<span id="cart-count">0</span>)
</button>

<!-- Slider Keranjang -->
<div id="cartSidebar" class="position-fixed top-0 end-0 bg-white border-start shadow p-3" style="width: 350px; height: 100vh; transform: translateX(100%); transition: transform 0.3s ease; z-index: 9999;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Keranjang</h5>
        <button id="closeCartBtn" class="btn btn-sm btn-danger">Tutup</button>
    </div>
    <div id="cartItems"></div>

    <hr>
    <div class="d-flex justify-content-between">
        <strong>Total:</strong>
        <strong id="cartTotal">Rp 0</strong>
    </div>

    <div class="form-group mt-3">
    <label for="paymentMethod" class="form-label">Metode Pembayaran</label>
    <select id="paymentMethod" class="form-select">
        <option value="COD">COD (Bayar di Tempat)</option>
        <option value="Transfer">Transfer</option>
    </select>
</div>


<div class="form-group mt-3">
    <label for="cartNote" class="form-label">Keterangan</label>
    <textarea id="cartNote" class="form-control" rows="2" placeholder="Tulis catatan atau permintaan khusus..."></textarea>
</div>
    <button class="btn btn-success w-100 mt-3" id="checkoutBtn">Checkout</button>
</div>



@push('scripts')


    <script>
    $(document).ready(function() {
        $('.quantity-increase').click(function() {
            const id = $(this).data('id');
            const input = $(`.quantity-input[data-id="${id}"]`);
            let currentVal = parseInt(input.val()) || 1;
            input.val(currentVal + 1);
        });

        $('.quantity-decrease').click(function() {
            const id = $(this).data('id');
            const input = $(`.quantity-input[data-id="${id}"]`);
            let currentVal = parseInt(input.val()) || 1;
            if (currentVal > 1) {
                input.val(currentVal - 1);
            }
        });
    });


</script>

<script>
    $(document).ready(function () {
        // Buka/tutup slider keranjang
        $('#openCartBtn').click(() => $('#cartSidebar').css('transform', 'translateX(0)'));
        $('#closeCartBtn').click(() => $('#cartSidebar').css('transform', 'translateX(100%)'));

        // Inisialisasi keranjang dari localStorage
        let cart = JSON.parse(localStorage.getItem('cart')) || {};

        function updateCartDisplay() {
            let cartHtml = '';
            let total = 0;
            let count = 0;

            Object.values(cart).forEach(item => {
                const subtotal = item.harga * item.qty;
                total += subtotal;
                count += item.qty;

                cartHtml += `
                    <div class="border-bottom pb-2 mb-2">
                        <div class="d-flex justify-content-between">
                            <strong>${item.nama}</strong>
                            <small>Rp ${formatRupiah(item.harga)}</small>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-secondary decrease-cart" data-id="${item.id}">-</button>
                                <input type="text" class="form-control text-center cart-qty" value="${item.qty}" readonly style="width: 40px;">
                                <button class="btn btn-outline-primary increase-cart" data-id="${item.id}">+</button>
                            </div>
                            <small class="text-muted">Subtotal: Rp ${formatRupiah(subtotal)}</small>
                        </div>
                    </div>
                `;
            });

            $('#cartItems').html(cartHtml);
            $('#cartTotal').text('Rp ' + formatRupiah(total));
            $('#cart-count').text(count);
        }

        function saveCart() {
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartDisplay();
        }

        function formatRupiah(angka) {
            return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Tambah ke keranjang
        $('.add-to-cart').click(function () {
            const id = $(this).data('id');
            console.log(id);
            const nama = $(this).data('nama');
            const harga = parseInt($(this).data('harga'));
            const qty = parseInt($(`.quantity-input[data-id="${id}"]`).val());

            if (cart[id]) {
                cart[id].qty += qty;
            } else {
                cart[id] = { id, nama, harga, qty };
            }

            saveCart();
        });

        // Tambah jumlah di keranjang
        $('#cartSidebar').on('click', '.increase-cart', function () {
            const id = $(this).data('id');
            cart[id].qty += 1;
            saveCart();
        });

        // Kurangi jumlah di keranjang
        $('#cartSidebar').on('click', '.decrease-cart', function () {
            const id = $(this).data('id');
            if (cart[id].qty > 1) {
                cart[id].qty -= 1;
            } else {
                delete cart[id];
            }
            saveCart();
        });

       $('#checkoutBtn').click(function () {
    const payment = $('#paymentMethod').val();
    const note = $('#cartNote').val();
      if (!payment) {
        Swal.fire({
            icon: 'warning',
            title: 'Metode pembayaran belum dipilih!',
            text: 'Silakan pilih metode pembayaran terlebih dahulu.',
        });
        return;
    }

    if (note === '') {
        Swal.fire({
            icon: 'warning',
            title: 'Keterangan kosong!',
            text: 'Silakan isi keterangan pesanan.',
        });
        return;
    }

    $.ajax({
        url: "{{ route('checkout') }}", // kamu buat route ini di bawah nanti
        type: "POST",
        data: {
            _token: '{{ csrf_token() }}',
            cart: cart,
            metode_pembayaran: payment,
            keterangan: note
        },
        success: function (response) {
              Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: response.message || 'Pesanan berhasil dibuat.',
            timer: 2000,
            showConfirmButton: false
        });
            cart = {};
            saveCart();

            // Bersihkan form
            $('#cartNote').val('');
            $('#paymentMethod').val('COD');
            localStorage.removeItem('cart_note');
            localStorage.removeItem('payment_method');
            $('#cartSidebar').css('transform', 'translateX(100%)');
        },
       error: function(xhr) {
        console.log(xhr)
        let message = 'Terjadi kesalahan saat melakukan checkout.';
        if (xhr.responseJSON && xhr.responseJSON.message) {
            message = xhr.responseJSON.message;
        }

        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: message
        });
    }
    });
});

        // Inisialisasi awal
        updateCartDisplay();
    });
</script>

<script>
    // Load keterangan dari localStorage jika ada
// Load metode pembayaran dari localStorage jika ada
$('#paymentMethod').val(localStorage.getItem('payment_method') || 'COD');

// Simpan metode pembayaran ke localStorage saat dipilih
$('#paymentMethod').on('change', function () {
    localStorage.setItem('payment_method', $(this).val());
});

// Load keterangan dari localStorage jika ada
$('#cartNote').val(localStorage.getItem('cart_note') || '');

// Simpan keterangan ke localStorage saat diketik
$('#cartNote').on('input', function () {
    localStorage.setItem('cart_note', $(this).val());
});

// $('#checkoutBtn').click(function () {
//     const payment = $('#paymentMethod').val();
//     const note = $('#cartNote').val();

//     // Simulasi: tampilkan di console
//     console.log('Checkout Data:', {
//         cart,
//         payment_method: payment,
//         keterangan: note
//     });

//     alert('Checkout berhasil! (Simulasi)');
//     cart = {};
//     saveCart();

//     // Reset input
//     $('#cartNote').val('');
//     $('#paymentMethod').val('COD');
//     localStorage.removeItem('cart_note');
//     localStorage.removeItem('payment_method');

//     $('#cartSidebar').css('transform', 'translateX(100%)');
// });

</script>


@endpush
      @endsection
