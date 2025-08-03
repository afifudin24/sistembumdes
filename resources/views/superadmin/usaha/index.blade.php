@extends('layouts.dashboard')

@section('content')
<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Kelola Data Usaha</h1>


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


                                    <div>

                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahusaha">
                                            Tambah Usaha
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
											<th class="">Admin</th>
											<th class="d-none d-xl-table-cell">Email</th>
											<th class="d-none d-xl-table-cell">Alamat</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
                                        @foreach($usaha as $item)
										<tr>
											<td>{{$loop->iteration}}</td>
											<td class="">{{$item->nama_usaha}}</td>
											<td class="d-none d-xl-table-cell">{{$item->admin->nama}}</td>

                                         <td class="d-none d-xl-table-cell">
                                        {{$item->email}}
                                        </td>
											<td><span>{{$item->alamat}}</span></td>
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
                                    {{ $usaha->links() }}

                                </div>
							</div>
						</div>
					</div>

				</div>
			</main>

          <!-- modal detail -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailLabel">Detail Usaha</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered mb-0">
          <tbody>
            <tr>
              <th scope="row">Nama Usaha</th>
              <td id="namaUsahaDetail">-</td>
            </tr>
            <tr>
              <th scope="row">Email</th>
              <td id="emailDetail">-</td>
            </tr>
            <tr>
              <th scope="row">Admin</th>
              <td id="adminDetail">-</td>
            </tr>
            <tr>
              <th scope="row">Rekening</th>
              <td id="rekeningDetail">-</td>
            </tr>
            <tr>
              <th scope="row">No Rekening</th>
              <td id="noRekeningDetail">-</td>
            </tr>
            <tr>
              <th scope="row">No Telepon</th>
              <td id="noTeleponDetail">-</td>
            </tr>
            <tr>
              <th scope="row">Keterangan</th>
              <td id="keteranganDetail">-</td>
            </tr>
            <tr>
              <th scope="row">Alamat</th>
              <td id="alamatDetail">-</td>
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
<!-- End modal detail -->



          <!-- modal edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="editUsahaForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditLabel">Edit Usaha</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="editNamaUsaha" class="form-label">Nama Usaha</label>
            <input type="text" class="form-control" id="editNamaUsaha" name="nama_usaha" required>
          </div>

          <div class="mb-3">
            <label for="editEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="editEmail" name="email" required>
          </div>

          <div class="mb-3">
            <label for="editAdmin" class="form-label">Admin</label>
            <select class="form-select" id="editAdmin" name="admin_id" required>
              <option value="" disabled selected>Pilih Admin</option>
              @foreach ($admin as $adm)
                <option value="{{ $adm->admin_id }}">{{ $adm->nama }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="editRekening" class="form-label">Rekening</label>
            <select class="form-select" id="editRekening" name="rekening" required>
              <option value="" disabled selected>Pilih Rekening</option>
              <option value="BRI">Bank Rakyat Indonesia</option>
              <option value="BCA">Bank Central Asia</option>
              <option value="Mandiri">Bank Mandiri</option>
              <option value="BSI">Bank Syariah Indonesia</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="editNoRek" class="form-label">No Rekening</label>
            <input type="text" class="form-control" id="editNoRek" name="no_rek" required>
          </div>

          <div class="mb-3">
            <label for="editNoTelepon" class="form-label">No Telepon</label>
            <input type="text" class="form-control" id="editNoTelepon" name="no_telepon" required>
          </div>

          <div class="mb-3">
            <label for="editKeterangan" class="form-label">Keterangan</label>
            <textarea class="form-control" id="editKeterangan" name="keterangan" required></textarea>
          </div>

          <div class="mb-3">
            <label for="editAlamat" class="form-label">Alamat</label>
            <textarea class="form-control" id="editAlamat" name="alamat" required></textarea>
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


            <!-- form tambah  usaha -->
                <div class="modal fade" id="modalTambahusaha" tabindex="-1" aria-labelledby="modalTambahusahaLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="tambahusaha" action="{{ route('tambahusaha') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahusahaLabel">Tambah usaha</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="namaUsahaTambah" class="form-label">Nama Usaha</label>
            <input type="text" class="form-control" id="namaUsahaTambah" name="nama_usaha" required>
          </div>
          <div class="mb-3">
            <label for="emailTambah" class="form-label">Email</label>
            <input type="text" class="form-control" id="emailTambah" name="email" required>
          </div>



          <div class="mb-3">
            <label for="adminTambah" class="form-label">Admin</label>
            <select class="form-select" id="adminTambah" name="admin_id" required>
               <option value="" selected disabled>Pilih Admin</option>
               @foreach($admin as $adm)
               <option value="{{$adm->admin_id}}">{{$adm->nama}}</option>
               @endforeach

            </select>
          </div>
          <div class="mb-3">
            <label for="rekeningtambah" class="form-label">Rekening</label>
            <select class="form-select" id="rekeningtambah" name="rekening" required>
              <option value="" selected disabled>Pilih Rekening</option>

              <option value="BRI">Bank Rakyat Indonesia</option>
              <option value="BCA">Bank Central Asia</option>
              <option value="Mandiri">Bank Mandiri</option>
              <option value="BSI">Bank Syariah Indonesia</option>

            </select>
          </div>
          <div class="mb-3">
            <label for="norektambah" class="form-label">No Rekening</label>
            <input type="text" class="form-control" id="norektambah" name="no_rek" required>
          </div>
          <div class="mb-3">
            <label for="notelepontambah" class="form-label">No Telepon</label>
            <input type="text" class="form-control" id="notelepontambah" name="no_telepon" required>
          </div>
            <div class="mb-3">
            <label for="keteranganTambah" class="form-label">Keterangan <span class="text-danger">*</span></label>
            <textarea class="form-control" id="keteranganTambah" name="keterangan" required></textarea>
        </div>
            <div class="mb-3">
            <label for="alamatTambah" class="form-label">Alamat <span class="text-danger">*</span></label>
            <textarea class="form-control" id="alamatTambah" name="alamat" required></textarea>
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

            <!-- end form tambah  usaha -->

            <!-- modal konfirmasi hapus -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="formHapususaha" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-header">
          <h5 class="modal-title" id="modalHapusLabel">Konfirmasi Hapus</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <p>Apakah Anda yakin ingin menghapus usaha <strong id="namaHapus"></strong>?</p>
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
