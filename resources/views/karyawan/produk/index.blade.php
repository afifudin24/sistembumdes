@extends('layouts.dashboard')

@section('content')
<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Data Produk</h1>


					<div class="row">
						<div class="col-12 col-lg-12 col-xxl-9 d-flex">
							<div class="card flex-fill">
								<div class="card-header">

									{{-- <h5 class="card-title mb-0">Data produk</h5> --}}

                         @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif



								</div>
                                <!-- wadah table -->

                                <div class="table-responsive">
								<table class="table table-hover my-0">
									<thead>
										<tr>
											<th>NO</th>
											<th class="">Nama Usaha</th>
											<th class="">Nama Produk</th>
											<th class="d-none d-xl-table-cell">Harga</th>
											<th class="d-none d-xl-table-cell">Deskripsi</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
                                        @foreach($produk as $item)
										<tr>
											<td>{{$loop->iteration}}</td>
											<td class="">{{$item->usaha->nama_usaha}}</td>
											<td class="">{{$item->nama_produk}}</td>
                                         <td class="d-none d-xl-table-cell">
                                         {{ formatRupiah($item->harga)}}
                                        </td>
											<td class="d-none d-xl-table-cell">{{$item->deskripsi}}</td>

										<td class="">
    <!-- Detail Button -->
    <button class="btn btn-success btnDetail" data-item="{{$item}}" data-bs-toggle="modal" data-bs-target="#modalDetail" >
        <span class="d-none d-xl-inline">Detail</span>
        <i data-feather="eye" class="d-inline d-xl-none"></i>
    </button>

</td>

										</tr>
                                        @endforeach

									</tbody>
								</table>
                                     </div>
                                <div class="d-flex mt-3 mr-3 p-3 justify-content-end">
                                    {{ $produk->links() }}

                                </div>
							</div>
						</div>
					</div>

				</div>
			</main>

         <!-- Modal Detail -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailLabel">Detail Produk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered mb-0">
          <tbody>
            <tr>
              <th scope="row">Nama Produk</th>
              <td id="namaProdukDetail">-</td>
            </tr>
            <tr>
              <th scope="row">Harga</th>
              <td id="hargaDetail">-</td>
            </tr>
            <tr>
            <tr>
              <th scope="row">Usaha</th>
              <td id="usahaDetail">-</td>
            </tr>
            <tr>
              <th scope="row">Deskripsi</th>
              <td id="keteranganDetail">-</td>
            </tr>

            <tr>
              <th scope="row">Gambar</th>
              <td id="fotoDetail" class="text-center">
                <img src="" id="gambarProdukDetail" alt="Gambar Produk" class="img-fluid rounded" style="max-width: 150px;">
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modal Detail -->




@push('scripts')
    <script>
        $(document).ready(function() {
      $('.btnDetail').on('click', function () {
    var item = $(this).data('item');
    console.log(item);

    $('#namaProdukDetail').html(item.nama_produk ?? '-');
    $('#usahaDetail').html(item.usaha.nama_usaha ?? '-');
    $('#hargaDetail').html(item.harga ?? '-');

    $('#keteranganDetail').html(item.deskripsi ?? '-');

    if (item.gambar) {
        $('#gambarProdukDetail').attr('src', '/storage/' + item.gambar).show();
    } else {
        $('#gambarProdukDetail').attr('src', '').hide();
    }

    $('#modalDetail').modal('show');
});

        });
    </script>

    <script>
  feather.replace();

  $('#togglePassword').on('click', function () {
    const input = $('#passwordTambah');
    const icon = $('#iconPassword');

    if (input.attr('type') === 'password') {
      input.attr('type', 'text');
      icon.attr('data-feather', 'eye-off');
    } else {
      input.attr('type', 'password');
      icon.attr('data-feather', 'eye');
    }

    feather.replace(); // refresh icon
  });
</script>


@endpush
      @endsection
