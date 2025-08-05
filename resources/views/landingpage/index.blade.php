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
      <a class="navbar-brand" href="#">BUMDes Mugi Rahayu</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
          <li class="nav-item"><a class="nav-link" href="#produk">Produk</a></li>
          <li class="nav-item"><a class="nav-link" href="#galeri">Galeri</a></li>
          <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
    </ul>
        @if(session('login') === true)
          <a href="/dashboard" class="btn btn-light">Dashboard</a>
        @else
        <a href="/login" class="btn btn-light">Login</a>
        @endif
      </div>
    </div>
  </nav>

  <!-- Hero -->
  <section class="bg-light text-center py-5">
    <div class="container">
          <img class="img-fluid rounded mb-4" loading="lazy" src="{{ asset('assets/images/logoo.jpg') }}" width="245" height="80" alt="BootstrapBrain Logo">
      <h1 class="display-4">Selamat Datang di BUMDes Mugi Rahayu</h1>
      <p class="lead">   Membangun Kemandirian, Menuai Kemakmuran.</p>
      <a href="/listproduk" class="btn btn-success mt-3">Lihat Produk</a>
    </div>
  </section>

  <!-- Tentang -->
  <section id="tentang" class="py-5">
    <div class="container">
      <h2 class="text-center mb-4">Tentang Kami</h2>
       <p class="text-justify">
      <strong>BUMDes Mugi Rahayu</strong> merupakan Badan Usaha Milik Desa yang berada di <strong>Desa Tunjung, Kecamatan Jatilawang, Kabupaten Banyumas</strong>.
      Kami hadir untuk mendorong pertumbuhan ekonomi desa melalui berbagai unit usaha yang berbasis potensi lokal dan dikelola secara profesional.
      Produk unggulan kami meliputi:
    </p>
    <ul class="text-justify list-unstyled">
      <li>✅ <strong>Batik Jatilawangan</strong> – kerajinan batik khas Banyumasan dengan motif lokal yang bernilai seni tinggi, dibuat oleh pengrajin desa.</li>
      <li>✅ <strong>Air Minum Tirta Tunjung</strong> – layanan air isi ulang galon yang bersih, sehat, dan terjangkau untuk kebutuhan masyarakat sekitar.</li>
      <li>✅ <strong>Kedai Nusantara</strong> – tempat berkumpul warga yang menyajikan aneka kopi dan teh Nusantara dalam suasana yang nyaman dan ramah.</li>
    </ul>
    <p class="text-justify">
      Melalui pengembangan unit-unit usaha tersebut, BUMDes Mugi Rahayu berkomitmen untuk menciptakan lapangan kerja, meningkatkan pendapatan masyarakat, dan memperkuat kemandirian ekonomi Desa Tunjung.
    </p>
    </div>
  </section>

  <!-- Produk -->
  <section id="produk" class="py-5 bg-light">
    <div class="container">
      <h2 class="text-center mb-4">Produk & Layanan</h2>
      <div class="row">
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

      </div>
    </div>
    <div class="text-center d-flex justify-content-center">

        <a href="/pesan" class="btn btn-success mx-2">
        Pesan Sekarang
        </a>
    </div>
  </section>

  <!-- Galeri -->
<!-- Galeri -->
<section id="galeri" class="py-5">
  <div class="container">
    <h2 class="text-center mb-4">Galeri</h2>
    <div class="row">
      <!-- Baris 1 -->
      <div class="col-md-4 mb-3">
        <img src="{{asset('assets/galeri/kedai1.jpg')}}" class="img-fluid rounded galeri-img" alt="Galeri 1">
      </div>
      <div class="col-md-4 mb-3">
        <img  src="{{asset('assets/galeri/kedai2.jpg')}}" class="img-fluid rounded galeri-img" alt="Galeri 2">
      </div>
      <div class="col-md-4 mb-3">
        <img  src="{{asset('assets/galeri/kedai3.jpg')}}" class="img-fluid rounded galeri-img" alt="Galeri 3">
      </div>

      <!-- Baris 2 -->
      <div class="col-md-4 mb-3">
        <img  src="{{asset('assets/galeri/galon1.jpg')}}" class="img-fluid rounded galeri-img" alt="Galeri 4">
      </div>
      <div class="col-md-4 mb-3">
        <img  src="{{asset('assets/galeri/galon2.jpg')}}" class="img-fluid rounded galeri-img" alt="Galeri 5">
      </div>
      <div class="col-md-4 mb-3">
        <img src="{{asset('assets/galeri/galon3.jpg')}}" class="img-fluid rounded galeri-img" alt="Galeri 6">
      </div>

      <!-- Baris 3 -->
      <div class="col-md-4 mb-3">
        <img  src="{{asset('assets/galeri/batik1.jpg')}}" class="img-fluid rounded galeri-img" alt="Galeri 7">
      </div>
      <div class="col-md-4 mb-3">
        <img  src="{{asset('assets/galeri/batik2.jpg')}}" class="img-fluid rounded galeri-img" alt="Galeri 8">
      </div>
      <div class="col-md-4 mb-3">
        <img  src="{{asset('assets/galeri/batik3.jpg')}}" class="galeri-img img-fluid rounded" alt="Galeri 9">
      </div>
    </div>
  </div>
</section>


  <!-- Kontak -->
  <!-- Kontak -->
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
