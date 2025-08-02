@extends('layouts.dashboard')

@section('content')
<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Data Super Admin</h1>
						

					<div class="row">
						<div class="col-12 col-lg-12 col-xxl-9 d-flex">
							<div class="card flex-fill">
								<div class="card-header">

									{{-- <h5 class="card-title mb-0">Data Super Admin</h5> --}}
								</div>
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
                                        @foreach($superadmin as $item)
										<tr>
											<td>{{$loop->iteration}}</td>
											<td class="">{{$item->nama}}</td>
											<td class="d-none d-xl-table-cell">{{$item->username}}</td>
                                            @if($item->status == 'aktif')
                                            <td class="d-none d-xl-table-cell text-capitalize">{{$item->status}}</td>
                                            @else
                                         <td class="d-none d-xl-table-cell text-capitalize ">
                                            <div class="d-flex flex-column align-items-start">

                                                <p>
                                                    {{$item->status}}
                                                    
                                                </p>
                                                
                                                <a class="btn btn-success mt-2" href="/aktifkanuser/{{$item->id}}">Aktifkan</a>
                                            </div>
</td>

                                            @endif
											
											<td><span>{{$item->no_hp}}</span></td>
										<td class="">
    <!-- Detail Button -->
    <button class="btn btn-success">
        <span class="d-none d-xl-inline">Detail</span>
        <i data-feather="eye" class="d-inline d-xl-none"></i>
    </button>

    <!-- Edit Button -->
    <button class="btn btn-warning btn-small">
        <span class="d-none d-xl-inline">Edit</span>
        <i data-feather="edit" class="d-inline d-xl-none"></i>
    </button>

    <!-- Delete Button -->
    <button class="btn btn-danger">
        <span class="d-none d-xl-inline">Hapus</span>
        <i data-feather="trash-2" class="d-inline d-xl-none"></i>
    </button>
</td>

										</tr>
                                        @endforeach
										
									</tbody>
								</table>
                                <div class="d-flex mt-3 mr-3 p-3 justify-content-end">
                                    {{ $superadmin->links() }}

                                </div>
							</div>
						</div>
					</div>
				
				</div>
			</main>

            
@push('scripts')



@endpush
      @endsection