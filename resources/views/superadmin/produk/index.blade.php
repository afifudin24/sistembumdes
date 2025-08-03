@extends('layouts.dashboard')

@section('content')
<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Kelola Data Produk</h1>


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


                                    <div>

                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahproduk">
                                            Tambah Produk
                                        </button>
                                    </div>
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

    <!-- Edit Button -->
    <button data-item="{{$item}}" class="btn btn-warning btn-small btnEdit"  data-bs-toggle="modal"
  data-bs-target="#modalEdit">
        <span class="d-none d-xl-inline">Edit</span>
        <i data-feather="edit" class="d-inline d-xl-none"></i>
    </button>

    <!-- Delete Button -->
    <button class="btn btn-danger btnHapus" data-item="{{$item}}" data-bs-toggle="modal" data-bs-target="#modalHapus">
        <span class="d-none d-xl-inline">Hapus</span>
        <i data-feather="trash-2" class="d-inline d-xl-none"></i>
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


<!-- Modal Edit Produk -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="editprodukForm" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modalEditLabel">Edit Produk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" id="editProdukId" name="produk_id">

          <div class="mb-3">
            <label for="editNamaProduk" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="editNamaProduk" name="nama_produk" required>
          </div>

          <div class="mb-3">
            <label for="editUsaha" class="form-label">Usaha</label>
            <select class="form-select" id="editUsaha" name="usaha_id" required>
              <option value="" selected disabled>Pilih Usaha</option>
              @foreach ($usaha as $u)
                <option value="{{ $u->usaha_id }}">{{ $u->nama_usaha }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="editHarga" class="form-label">Harga</label>
            <input type="number" class="form-control" id="editHarga" name="harga" required>
          </div>

          <div class="mb-3">
            <label for="editDeskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="editDeskripsi" name="deskripsi" required></textarea>
          </div>

          <div class="mb-3">
            <label for="editGambar" class="form-label">Gambar Produk (Kosongkan jika tidak diubah)</label>
            <input type="file" class="form-control" id="editGambar" name="gambar" accept="image/*">
            <div class="mt-2">
              <img id="previewGambarEdit" src="" alt="Gambar Saat Ini" style="max-height: 150px;" class="rounded">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Tambah Produk -->
<div class="modal fade" id="modalTambahproduk" tabindex="-1" aria-labelledby="modalTambahprodukLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <form id="tambahproduk" action="{{ route('tambahproduk') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahprodukLabel">Tambah Produk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="nama_produk" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
              </div>
              <div class="mb-3">
                <label for="usaha_id" class="form-label">Usaha</label>
                <select class="form-select" id="usaha_id" name="usaha_id" required>
                  <option value="" disabled selected>Pilih Usaha</option>
                  @foreach($usaha as $u)
                    <option value="{{ $u->usaha_id }}">{{ $u->nama_usaha }}</option>
                  @endforeach
                </select>
              </div>
              <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
              </div>
              <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Produk</label>
                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>



            <!-- modal konfirmasi hapus -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="formHapusproduk" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-header">
          <h5 class="modal-title" id="modalHapusLabel">Konfirmasi Hapus</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <p>Apakah Anda yakin ingin menghapus produk <strong id="namaHapus"></strong>?</p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Ya, Hapus</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>


            <!-- end modal konfirmasi hapus -->

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


           $('.btnEdit').on('click', function () {

 var item = $(this).data('item');

    $('#editprodukForm').attr('action', '/produk/' + item.produk_id); // pastikan route-nya sesuai

    $('#editProdukId').val(item.produk_id);
    $('#editNamaProduk').val(item.nama_produk);
    $('#editUsaha').val(item.usaha_id);
    $('#editHarga').val(item.harga);
    $('#editDeskripsi').val(item.deskripsi);

    if (item.gambar) {
        $('#previewGambarEdit').attr('src', '/storage/' + item.gambar).show();
    } else {
        $('#previewGambarEdit').hide();
    }
   $('#editprodukForm').attr('action', '/updateproduk/' + item.produk_id); // ganti 'id' jika ID utama bukan 'id'
});

        });

         $('.btnHapus').on('click', function () {
      const item = $(this).data('item');


      // Set nama di modal
      $('#namaHapus').text(item.nama_produk);

      // Set action form
      $('#formHapusproduk').attr('action', '/hapusproduk/' + item.produk_id);
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
