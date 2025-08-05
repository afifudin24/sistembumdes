<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	 <link rel="shortcut icon" href="{{ asset('assets/images/logoo.jpg') }}" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>Sistem BumDes</title>



	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<style>
 .custom-collapse {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.4s ease;
}

.custom-collapse.show {
  max-height: 500px; /* pastikan cukup tinggi untuk semua konten */
}

</style>


	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

</head>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="index.html">
          <span class="align-middle">Mugi Rahayu</span>
        </a>

				<ul class="sidebar-nav">
					<li class="sidebar-header text-uppercase">
						{{session()->get('role')}}
					</li>

					<li class="sidebar-item {{ Request::is('dashboard') ? 'active' : ''}}">
						<a class="sidebar-link" href="/dashboard">
              <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
            </a>
					</li>

					{{-- sidebar superadmin --}}
					@if(session()->get('role') == 'superadmin')

						{{--  --}}
				<li class="sidebar-item {{ Request::is('datasuperadmin', 'dataadmin', 'datakaryawan', 'datapelanggan') ? 'active' : '' }}">
  <a href="#" class="sidebar-link" onclick="toggleCollapse('datauser')">
    <i class="align-middle" data-feather="users"></i>
    <span class="align-middle">Kelola Data User</span>
  </a>
  <ul id="datauser" class="sidebar-dropdown list-unstyled custom-collapse {{ Request::is('datasuperadmin', 'dataadmin', 'datakaryawan', 'datapelanggan') ? 'show' : '' }}">
    <li class="sidebar-item {{ Request::is('datasuperadmin') ? 'active' : '' }}">
      <a class="sidebar-link" href="/datasuperadmin">Super Admin</a>
    </li>
    <li class="sidebar-item {{ Request::is('dataadmin') ? 'active' : '' }}">
      <a class="sidebar-link" href="/dataadmin">Admin</a>
    </li>
    <li class="sidebar-item {{ Request::is('datakaryawan') ? 'active' : '' }}">
      <a class="sidebar-link" href="/datakaryawan">Karyawan</a>
    </li>
    <li class="sidebar-item {{ Request::is('datapelanggan') ? 'active' : '' }}">
      <a class="sidebar-link" href="/datapelanggan">Pelanggan</a>
    </li>
  </ul>
</li>



						{{--  --}}
						<li class="sidebar-item {{ Request::is('datausaha') ? 'active' : ''}}">
							<a class="sidebar-link" href="/datausaha">
								<i class="align-middle" data-feather="bar-chart"></i> <span class="align-middle">Kelola Data Usaha</span>
							</a>
						</li>
						<li class="sidebar-item {{ Request::is('dataproduk') ? 'active' : ''}}">
							<a class="sidebar-link " href="/dataproduk">
								<i class="align-middle" data-feather="package"></i> <span class="align-middle">Kelola Data Produk</span>
							</a>
						</li>
						<li class="sidebar-item {{ Request::is('rekaplaporanpenjualan') ? 'active' : ''}}">
							<a class="sidebar-link" href="/rekaplaporanpenjualan">
								<i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Rekap Laporan Penjualan</span>
							</a>
						</li>
					@endif
                    @if(session()->get('role') == 'admin')
                    	<li class="sidebar-item {{ Request::is('dataproduk') ? 'active' : ''}}">
							<a class="sidebar-link " href="/dataproduk">
								<i class="align-middle" data-feather="package"></i> <span class="align-middle">Kelola Data Produk</span>
							</a>
						</li>
                        	<li class="sidebar-item {{ Request::is('datakaryawan') ? 'active' : ''}}">
							<a class="sidebar-link " href="/datakaryawan">
								<i class="align-middle" data-feather="users"></i> <span class="align-middle">Kelola Data Karyawan</span>
							</a>
						</li>
                        	<li class="sidebar-item {{ Request::is('datatransaksi') ? 'active' : ''}}">
							<a class="sidebar-link " href="/datatransaksi">
								<i class="align-middle" data-feather="repeat"></i> <span class="align-middle">Kelola Data Transaksi</span>
							</a>
						</li>
                        	<li class="sidebar-item {{ Request::is('datakonfirmasipembayaran') ? 'active' : ''}}">
							<a class="sidebar-link " href="/datakonfirmasipembayaran">
								<i class="align-middle" data-feather="dollar-sign"></i> <span class="align-middle">Konfirmasi Pembayaran</span>
							</a>
						</li>
                        <li class="sidebar-item {{ Request::is('rekaplaporanpenjualan') ? 'active' : ''}}">
							<a class="sidebar-link" href="/rekaplaporanpenjualan">
								<i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Rekap Laporan Penjualan</span>
							</a>
						</li>
                    @endif

					@if(session()->get('role') == 'karyawan')
					<li class="sidebar-item {{ Request::is('dataproduk') ? 'active' : ''}}">
							<a class="sidebar-link " href="/dataproduk">
								<i class="align-middle" data-feather="package"></i> <span class="align-middle">Data Produk</span>
							</a>
						</li>
						<li class="sidebar-item {{ Request::is('datatransaksi') ? 'active' : ''}}">
							<a class="sidebar-link " href="/datatransaksi">
								<i class="align-middle" data-feather="repeat"></i> <span class="align-middle">Kelola Data Transaksi</span>
							</a>
						</li>
                        	<li class="sidebar-item {{ Request::is('datakonfirmasipembayaran') ? 'active' : ''}}">
							<a class="sidebar-link " href="/datakonfirmasipembayaran">
								<i class="align-middle" data-feather="dollar-sign"></i> <span class="align-middle">Konfirmasi Pembayaran</span>
							</a>
						</li>
                        <li class="sidebar-item {{ Request::is('rekaplaporanpenjualan') ? 'active' : ''}}">
							<a class="sidebar-link" href="/rekaplaporanpenjualan">
								<i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Rekap Laporan Penjualan</span>
							</a>
						</li>
					@endif
			<li class="sidebar-item">
    <a href="#" class="sidebar-link" data-bs-toggle="modal" data-bs-target="#logoutModal">
        <i class="align-middle" data-feather="log-out"></i>
        <span class="align-middle">Logout</span>
    </a>
</li>



				</ul>


			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
          <i class="hamburger align-self-center"></i>
        </a>



				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<!-- <li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
								<div class="position-relative">
									<i class="align-middle" data-feather="bell"></i>
									<span class="indicator">4</span>
								</div>
							</a> -->
							<!-- <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
								<div class="dropdown-menu-header">
									4 New Notifications
								</div>
								<div class="list-group">
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-danger" data-feather="alert-circle"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Update completed</div>
												<div class="text-muted small mt-1">Restart server 12 to complete the update.</div>
												<div class="text-muted small mt-1">30m ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-warning" data-feather="bell"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Lorem ipsum</div>
												<div class="text-muted small mt-1">Aliquam ex eros, imperdiet vulputate hendrerit et.</div>
												<div class="text-muted small mt-1">2h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-primary" data-feather="home"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Login from 192.186.1.8</div>
												<div class="text-muted small mt-1">5h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-success" data-feather="user-plus"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">New connection</div>
												<div class="text-muted small mt-1">Christina accepted your request.</div>
												<div class="text-muted small mt-1">14h ago</div>
											</div>
										</div>
									</a>
								</div>
								<div class="dropdown-menu-footer">
									<a href="#" class="text-muted">Show all notifications</a>
								</div>
							</div> -->
						<!-- </li> -->

						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                <i class="align-middle" data-feather="settings"></i>
              </a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                 <span class="text-dark">{{session()->get('user')->nama}}</span>
              </a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="pages-profile.html"><i class="align-middle me-1" data-feather="user"></i> Profile</a>


								 <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutModal">
        <i class="align-middle" data-feather="log-out"></i>
        <span class="align-middle">Logout</span>
    </a>
							</div>
						</li>
					</ul>
				</div>
							<!-- Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin logout?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-danger">Logout</button>
        </form>
      </div>
    </div>
  </div>
</div>


{{-- end modal --}}
			</nav>
			@push('scripts')
			<script>
  function toggleCollapse(id) {
    const element = document.getElementById(id);
    element.classList.toggle('show');
  }

  window.addEventListener('DOMContentLoaded', () => {
    const dataUserMenu = document.getElementById('datauser');
    const activeLink = dataUserMenu.querySelector('.active');
    if (activeLink) {
      dataUserMenu.classList.add('show');
    }
  });
</script>

			@endpush
