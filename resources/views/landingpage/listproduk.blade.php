<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BUMDes Mugi Rahayu</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="{{asset('css/landingpage.css')}}">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
      <a class="navbar-brand" href="/">BUMDes Mugi Rahayu</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">

        @if(session('login') === true)
          <a href="/dashboard" class="btn btn-light">Dashboard</a>
        @else
        <a href="/login" class="btn btn-light">Login</a>
        @endif
      </div>
    </div>
  </nav>



  <!-- Produk -->
  <section id="produk" class="py-5 bg-light">
    <div class="container">
      <h2 class="text-center mb-4">Produk</h2>
       <form method="GET" action="{{ route('listproduk') }}" id="filterForm">
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
      <div class="row">
       @if($produks->isEmpty())
<div class="col-md-12 text-center mt-5">
  <img src="{{ asset('assets/images/empty.png') }}" alt="Tidak ada produk" style="max-width: 300px;" class="mb-4">
  <h5 class="text-muted">Data produk tidak ditemukan</h5>
</div>
@endif

        <!-- Produk 1 -->
         @foreach ($produks as $item)
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <img src="{{ asset('storage/'.$item->gambar) }}" class="card-img-top" alt="Produk {{$item->produk_id}}">
            <div class="card-body">
              <h4 class="card-title">{{$item->nama_produk}}</h4>
              <h5 class="card-title">{{$item->usaha->nama_usaha}}</h5>
              <p class="card-text">{{$item->deskripsi}}</p>
              <p class="text-success fw-bold">{{formatRupiah($item->harga)}}</p>
            </div>
          </div>
        </div>
        @endforeach

        {{ $produks->links() }}

      </div>
    </div>
  </section>

<section id="kontak" class="bg-success text-white py-5">
  <div class="container text-center">
    <h2>Kontak Kami</h2>
    <p>Alamat: Jl. Pramuka No. 04 Desa Tunjung RT. 01/RW. 04 Kec. Jatilawang, Kab. Banyumas - 53174</p>
    <p>Email: bumdes.mura22@gmail.com</p>
    <p>WhatsApp: 082135291228/082322509200 </p>
    <div class="mt-3">
      <a href="https://www.facebook.com/profile.php?id=61557624674571" target="_blank" class="text-white me-3">
        <i class="bi bi-facebook" style="font-size: 1.5rem;"></i>
      </a>
      <a href="https://www.instagram.com/bumdes_mugirahayutunjung2022" target="_blank" class="text-white">
        <i class="bi bi-instagram" style="font-size: 1.5rem;"></i>
      </a>
    </div>
  </div>
</section>

  <!-- Footer -->
  <footer class="bg-dark text-white text-center py-3">
    <small>© 2025 BUMDes Mugi Rahayu. All rights reserved.</small>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
