@extends('layouts.dashboard')

@section('content')
<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Data Karyawan</h1>


					<div class="row">
						<div class="col-12 col-lg-12 col-xxl-9 d-flex">
							<div class="card flex-fill">
								<div class="card-header">

									{{-- <h5 class="card-title mb-0">Data Karyawan</h5> --}}

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

                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKaryawan">
                                            Tambah Karyawan
                                        </button>
                                    </div>
								</div>
                                <!-- wadah table -->

                                <div class="table-responsive">



								<table class="table table-hover my-0">
									<thead>
										<tr>
											<th>NO</th>
											<th class="">Nama</th>
											<th class="">Username</th>
											<th class="d-none d-xl-table-cell">Status</th>
											<th class="d-none d-xl-table-cell">No Hp</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
                                        @foreach($karyawan as $item)
										<tr>
											<td>{{$loop->iteration}}</td>
											<td class="">{{$item->nama}}</td>
											<td class="d-none d-xl-table-cell">{{$item->username}}</td>
                                            @if($item->status_akun == 'aktif')
                                            <td class="d-none d-xl-table-cell text-capitalize">{{$item->status_akun}}</td>
                                            @else
                                         <td class="d-none d-xl-table-cell text-capitalize ">
                                            <div class="d-flex flex-column align-items-start">

                                                <p>
                                                    {{$item->status_akun}}

                                                </p>

                                                <a class="btn btn-success mt-2" href="/aktifkankaryawan/{{$item->karyawan_id}}">Aktifkan</a>
                                            </div>
</td>

                                            @endif

											<td><span>{{$item->no_hp}}</span></td>
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
                                    {{ $karyawan->links() }}

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
        <h5 class="modal-title" id="modalDetailLabel">Detail Karyawan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered mb-0">
          <tbody>
            <tr>
              <th scope="row">Nama</th>
              <td id="namaDetail">-</td>
            </tr>
            <tr>
              <th scope="row">Username</th>
              <td id="usernameDetail">-</td>
            </tr>
            <tr>
              <th scope="row">Status</th>
              <td id="statusDetail">-</td>
            </tr>
               <tr>
              <th scope="row">Usaha</th>
              <td id="usahaDetail">-</td>
            </tr>
            <tr>
              <th scope="row">No HP</th>
              <td id="nohpDetail">-</td>
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
      <form id="editKaryawan" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditLabel">Edit Karyawan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="editNama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="editNama" name="nama" required>
          </div>
          <div class="mb-3">
            <label for="editUsername" class="form-label">Username</label>
            <input type="text" class="form-control" id="editUsername" name="username" required>
          </div>
          <div class="mb-3">
            <label for="editStatus" class="form-label">Status</label>
            <select class="form-select" id="editStatus" name="status_akun" required>
              <option value="aktif">Aktif</option>
              <option value="nonaktif">Nonaktif</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="editNoHp" class="form-label">No HP</label>
            <input type="text" class="form-control" id="editNoHp" name="nohp">
          </div>
            <div class="mb-3">
            <label for="alamatTambah" class="form-label">Alamat <span class="text-danger">*</span></label>
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


            <!-- end modal edit -->

            <!-- form tambah  Karyawan -->
                <div class="modal fade" id="modalTambahKaryawan" tabindex="-1" aria-labelledby="modalTambahKaryawanLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="tambahKaryawan" action="{{ route('tambahKaryawan') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahKaryawanLabel">Tambah Karyawan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="namaTambah" class="form-label">Nama</label>
            <input type="text" class="form-control" id="namaTambah" name="nama" required>
          </div>
          <div class="mb-3">
            <label for="usernameTambah" class="form-label">Username</label>
            <input type="text" class="form-control" id="usernameTambah" name="username" required>
          </div>
         <div class="mb-3">
  <label for="passwordTambah" class="form-label">Password</label>
  <div class="input-group">
    <input type="password" class="form-control" id="passwordTambah" name="password" required>
    <!-- <button class="btn btn-outline-secondary" type="button" id="togglePassword">
      <i data-feather="eye" id="iconPassword"></i>
    </button> -->
  </div>
</div>


          <div class="mb-3">
            <label for="statusTambah" class="form-label">Status</label>
            <select class="form-select" id="statusTambah" name="status_akun" required>
              <option value="aktif">Aktif</option>
              <option value="nonaktif">Nonaktif</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="nohpTambah" class="form-label">No HP</label>
            <input type="text" class="form-control" id="nohpTambah" name="nohp" required>
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

            <!-- end form tambah  Karyawan -->

            <!-- modal konfirmasi hapus -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="formHapusKaryawan" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-header">
          <h5 class="modal-title" id="modalHapusLabel">Konfirmasi Hapus</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <p>Apakah Anda yakin ingin menghapus  Karyawan <strong id="namaHapus"></strong>?</p>
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
            $('.btnDetail').on('click', function() {
                var item = $(this).data('item');
                $('#namaDetail').html(item.nama);
                $('#usernameDetail').html(item.username);
                $('#statusDetail').html(item.status_akun);
                $('#nohpDetail').html(item.no_hp);
                $('#alamatDetail').html(item.alamat);
                $('#usahaDetail').html(item.usaha.nama_usaha);


            });

            $('.btnEdit').on('click', function() {
                var item = $(this).data('item');
                $('#editNama').val(item.nama);
                $('#editUsername').val(item.username);
                $('#editStatus').val(item.status_akun);
                $('#editAlamat').val(item.alamat);
                $('#editUsaha').val(item.usaha_id);
                $('#editNoHp').val(item.no_hp);
                $('#editKaryawan').attr('action', '/updatekaryawan/' + item.karyawan_id);
            });
        });

         $('.btnHapus').on('click', function () {
      const item = $(this).data('item');


      // Set nama di modal
      $('#namaHapus').text(item.nama);

      // Set action form
      $('#formHapusKaryawan').attr('action', '/hapuskaryawan/' + item.karyawan_id);
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
