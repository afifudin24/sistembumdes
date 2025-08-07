@extends('layouts.dashboard')

@section('content')
<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Data Pesanan</h1>


					<div class="row">
						<div class="col-12 col-lg-12 col-xxl-9 d-flex">
							<div class="card flex-fill">
								<div class="card-header">


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
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


                                    <div>

                                        <a href="/pesan" class="btn btn-primary">Pesan Baru</a>
                                    </div>
								</div>
                                <!-- wadah table -->

                                <div class="table-responsive">



								<table class="table table-hover my-0">
									<thead>
										<tr>

											<th class="">ID</th>
											<th class="">Usaha</th>
											<th class="d-none d-xl-table-cell">Tanggal</th>
											<th class="d-none d-xl-table-cell">Total Harga</th>
											<th class="d-none d-xl-table-cell">Invoice</th>
										
											<th class="d-none d-xl-table-cell">Status</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
                                        @foreach($transaksi as $item)
										<tr>
											<td class="">{{$item->transaksi_id}}</td>

											<td class="">{{$item->usaha->nama_usaha}}</td>
											<td class="">{{formatTanggal($item->tanggal)}}</td>
                                         <td class="d-none d-xl-table-cell">
                                         {{ formatRupiah($item->total_harga)}}
                                        </td>
                      <td><a target="_blank" href="{{asset('storage/invoices/'.'transaksi_'.$item->transaksi_id.'.pdf')}}" class="btn btn-danger btn-sm">Invoice</a></td>
											<td class="d-none d-xl-table-cell text-capitalize">{{$item->status}}
                      <br>
                      @if($item->status == 'perlu bayar')
                        <!-- Button trigger modal -->
<button type="button" class="btn btnUploadBukti btn-primary btn-sm" data-item="{{$item}}" data-bs-toggle="modal" data-bs-target="#uploadBuktiModal">
  Upload Bukti
</button>
@elseif($item->status == 'menunggu konfirmasi')
  <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#cekBuktiModal{{ $item->transaksi_id }}">
  Cek Bukti Bayar
</button>


{{-- Update bukti --}}
  <!-- Modal -->
<div class="modal fade" id="cekBuktiModal{{ $item->transaksi_id }}" tabindex="-1" aria-labelledby="cekBuktiLabel{{ $item->transaksi_id }}" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ url('/uploadbuktibayar/' . $item->transaksi_id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('POST')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="cekBuktiLabel{{ $item->transaksi_id }}">Cek & Perbarui Bukti Bayar</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">

          @if($item->bukti_bayar)
            <div class="mb-3 text-center">
              <p class="fw-bold">Bukti Bayar Saat Ini:</p>
             <img src="{{ asset('storage/' . $item->bukti_bayar) }}" class="img-thumbnail img-fluid" style="max-width: 150px;" alt="Bukti Bayar">

            </div>
          @else
            <p class="text-muted text-center">Belum ada bukti bayar diunggah.</p>
          @endif

          <div class="mb-3">
            <label for="bukti_bayar_{{ $item->transaksi_id }}" class="form-label">Perbarui Bukti Bayar</label>
            <input class="form-control" type="file" id="bukti_bayar_{{ $item->transaksi_id }}" name="bukti_bayar" accept="image/*" required>
            <div class="form-text">File berupa gambar (jpg, png, jpeg, gif) maks. 2MB.</div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-success">Perbarui Bukti</button>
        </div>
      </div>
    </form>
  </div>
</div>
{{-- end update bukti --}}
  @elseif($item->status == 'dikirim')
                        <form action="/pesananditerima/{{$item->transaksi_id}}" method="POST">
                          @csrf
                          <button class="btn btn-sm btn-secondary" type="submit">Terima</button>
                        </form>

@endif
                      </td>

										<td class="">

    <!-- Detail Button -->
    <button class="btn btn-success btnDetail" data-item="{{$item}}" data-bs-toggle="modal" data-bs-target="#modalDetail" >
        <span class="d-none d-xl-inline">Detail</span>
        <i data-feather="eye" class="d-inline d-xl-none"></i>
    </button>
    <button class="btn btn-warning btnProduk" data-item="{{$item}}" data-bs-toggle="modal" data-bs-target="#modalProduk">
         <i data-feather="package" class=""></i>
    </button>
    
    @if($item->status == 'antrian' || $item->status == 'perlu bayar')
    <a class="btn btn-danger" href="{{ url('/batalkanpesanan/' . $item->transaksi_id) }}">
     <i data-feather="x"></i>
    </a>


    @endif


</td>

										</tr>
                                        @endforeach

									</tbody>
								</table>
                                     </div>
                                <div class="d-flex mt-3 mr-3 p-3 justify-content-end">
                                    {{ $transaksi->links() }}

                                </div>
							</div>
						</div>
					</div>

				</div>
			</main>

      {{-- Modal Bukti Bayar --}}

<!-- Modal -->
<div class="modal fade" id="uploadBuktiModal" tabindex="-1" aria-labelledby="uploadBuktiModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formBuktiBayar" action="/uploadbuktibayar" method="POST" enctype="multipart/form-data">
      <!-- Jika pakai Laravel -->
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="uploadBuktiModalLabel">Upload Bukti Pembayaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
              <h5 class="mb-2">Transfer ke rekening</h5>
              <h4 class=""><span id="rekening"></span> | <span id="no_rek"></span> </h4>
          </div>
          <div class="mb-3">
            <label for="bukti_bayar" class="form-label">Upload Bukti Bayar</label>
            <input class="form-control" type="file" id="bukti_bayar" name="bukti_bayar" accept="image/*,application/pdf" required>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Kirim Bukti</button>
        </div>
      </div>
    </form>
  </div>
</div>
{{-- Bukti Bayar --}}

         <!-- Modal Detail -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailLabel">Detail Transaksi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered mb-0">
          <tbody id="tbodyDetail">

            <tr>
              <th scope="row">Total Harga</th>
              <td id="totalDetail">-</td>
            </tr>
            <tr>
            <tr>
              <th scope="row">Usaha</th>
              <td id="namaUsahaDetail">-</td>
            </tr>
            <tr>
              <th scope="row">Tanggal</th>
              <td id="tanggalDetail">-</td>
            </tr>
            <tr>
              <th scope="row">Metode Pembayaran</th>
              <td id="metodePembayaranDetail">-</td>
            </tr>

            <tr>
              <th scope="row">Status</th>
              <td id="statusDetail" class="text-capitalize">
                -
              </td>
            </tr>
            <tr>
              <th scope="row">Keterangan</th>
              <td id="keteranganDetail" class="">
                -
              </td>
            </tr>
            <tr>
              <th scope="row">Bukti Bayar</th>
              <td id="buktiDetail" class="">
                <img src="" id="buktiBayarDetail" alt="Bukti Bayar" class="img-fluid rounded" style="max-width: 150px;">
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

{{-- Modal Detail Produk --}}
  <div class="modal fade" id="modalProduk" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailLabel">Data Produk Pesanan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered mb-0">
          <thead>
            <th>
              Nama Produk
            </th>
            <th>
              Qty
            </th>
            <th>
              Sub Total
            </th>
          </thead>
          <tbody class="dataProduk">

          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

{{-- End Detail Produk --}}


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

    $('#namaUsahaDetail').html(item.usaha.nama_usaha ?? '-');

    $('#totalDetail').html(item.total_harga ?? '-');
    $('#metodePembayaranDetail').html(item.metode_pembayaran ?? '-');
    $('#tanggalDetail').html(item.tanggal ?? '-');
    $('#statusDetail').html(item.status ?? '-');
    $('#keteranganDetail').html(item.keterangan ?? '-');

    if (item.bukti_bayar) {
        $('#buktiBayarDetail').attr('src', '/storage/' + item.bukti_bayar).show();
    } else {

        $('#buktiDetail').html('-');
        $('#buktiBayarDetail').attr('src', '').hide();
    }


});

  // btnProduk

  $('.btnProduk').on('click', function () {
    var item = $(this).data('item');
    console.log(item);
    $('.dataProduk').empty();
    $.each(item.detail_transaksi, function (index, detail) {
      console.log(detail);
      $('.dataProduk').append(`
        <tr>
          <td>${detail.produk.nama_produk}</td>
          <td>${detail.kuantitas}</td>
          <td>${detail.subtotal}</td>
        </tr>
      `);
    })

  });

  $(".btnUploadBukti").on('click', function() {
    var item = $(this).data('item') ;
    console.log(item);
    $("#rekening").html(item.usaha.rekening ?? '-');
    $("#no_rek").html(item.usaha.no_rek ?? '-');
    $('#formBuktiBayar').attr('action', '/uploadbuktibayar/' + item.transaksi_id);
  }
)



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
