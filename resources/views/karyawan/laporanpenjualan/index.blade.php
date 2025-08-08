@extends('layouts.dashboard')

@section('content')
<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Rekap Laporan Penjualan</h1>


					<div class="row">
						<div class="col-12 col-lg-12 col-xxl-9 d-flex">
							<div class="card flex-fill">
								<div class="card-header">

									{{-- <h5 class="card-title mb-0">Data usaha</h5> --}}

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



                                      <form method="GET" action="{{ route('rekaplaporanpenjualan') }}" class="row gy-2 mt-3 gx-2 align-items-end mb-3">

    <div class="col-sm-2">
        <label for="tanggal_mulai" class="form-label small mb-1">Mulai</label>
        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control form-control"
               value="{{ request('tanggal_mulai') }}">
    </div>
    <div class="col-sm-2">
        <label for="tanggal_akhir" class="form-label small mb-1">Akhir</label>
        <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control form-control"
               value="{{ request('tanggal_akhir') }}">
    </div>

    <div class="col-sm-4 d-flex gap-2">
        <button type="submit" class="btn  btn-primary">Filter</button>
        <a href="{{ route('rekaplaporanpenjualan') }}" class="btn  btn-secondary">Reset</a>
         <a href="{{ route('eksporlaporanpenjualan', request()->all()) }}" target="_blank" class="btn  btn-success">
            Ekspor PDF
        </a>
    </div>
</form>
								</div>
                                <!-- wadah table -->

                                <div class="table-responsive">



								<table class="table table-hover my-0">
                                <thead>
										<tr>
											<th>NO</th>
											<th class="">Tanggal</th>
											<th class="">Usaha</th>
											<th class="d-none d-xl-table-cell">Metode Bayar</th>
											<th class="d-none d-xl-table-cell">Total</th>

										</tr>
									</thead>
									<tbody>
                                                                        
@if($laporan->count() == 0)
    <tr>
        <td colspan="5" class="text-center">Tidak Ada Laporan</td>
    </tr>
@else
    @foreach($laporan as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ formatTanggal($item->tanggal) }}</td>
            <td class="d-none d-xl-table-cell">
                {{ $item->usaha->nama_usaha ?? '-' }}
            </td>
            <td class="d-none d-xl-table-cell">
                {{ $item->metode_pembayaran ?? '-' }}
            </td>
            <td>{{ formatRupiah($item->total_harga) }}</td>
        </tr>
    @endforeach
@endif

									</tbody>
								</table>
                                     </div>
                                <div class="d-flex mt-3 mr-3 p-3 justify-content-end">
                                    {{ $laporan->links() }}

                                </div>
							</div>
						</div>
					</div>

				</div>
			</main>



@push('scripts')
    <script>
        $(document).ready(function() {
        $('.btnDetail').on('click', function () {
    var item = $(this).data('item');
    console.log(item);

    $('#namaUsahaDetail').html(item.nama_usaha ?? '-');
    $('#emailDetail').html(item.email ?? '-');
    $('#adminDetail').html(item.admin?.nama ?? '-');
    $('#rekeningDetail').html(item.rekening ?? '-');
    $('#noRekeningDetail').html(item.no_rek ?? '-');
    $('#noTeleponDetail').html(item.no_telepon ?? '-');
    $('#keteranganDetail').html(item.keterangan ?? '-');
    $('#alamatDetail').html(item.alamat ?? '-');
});


           $('.btnEdit').on('click', function () {
    const item = $(this).data('item');
  const id = item.usaha_id;

  $('#editUsahaForm').attr('action', '/usaha/' + id);

  $('#editNamaUsaha').val(item.nama_usaha);
  $('#editEmail').val(item.email);
  $('#editAdmin').val(item.admin_id);
  $('#editRekening').val(item.rekening);
  $('#editNoRek').val(item.no_rek);
  $('#editNoTelepon').val(item.no_telepon);
  $('#editKeterangan').val(item.keterangan);
  $('#editAlamat').val(item.alamat);
   $('#editUsahaForm').attr('action', '/updateusaha/' + item.usaha_id); // ganti 'id' jika ID utama bukan 'id'
});

        });

         $('.btnHapus').on('click', function () {
      const item = $(this).data('item');


      // Set nama di modal
      $('#namaHapus').text(item.nama_usaha);

      // Set action form
      $('#formHapususaha').attr('action', '/hapususaha/' + item.usaha_id);
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
