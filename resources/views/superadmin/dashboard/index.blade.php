@extends('layouts.dashboard')

@section('content')
<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Dashboard</h1>

					<div class="row">
						<div class="col-xl-6 col-xxl-5 d-flex">
							<div class="w-100">
								<div class="row">
									<div class="col-sm-6">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Penjualan</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="shopping-bag"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3">{{$totalPenjualan}}</h1>
												<div class="mb-0">
													
													<span class="text-muted">Barang</span>
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Pendapatan</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="dollar-sign"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3">{{formatRupiah($totalPendapatan) ?? 0}}</h1>
												
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Total Admin</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="user"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3">{{$totalAdmin}}</h1>
												
											</div>
										</div>
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Total Pelanggan</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="users"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3">{{$totalPelanggan}}</h1>
												
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-xl-6 col-xxl-7">
							<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0">Riwayat Pendapatan Bulan Ini</h5>
								</div>
								<div class="card-body py-3">
									<div class="chart chart-sm">
										<canvas id="chartjs-dashboard-line"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>

					{{-- <div class="row">
						<div class="col-12 col-md-6 col-xxl-3 d-flex order-2 order-xxl-3">
							<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0">Browser Usage</h5>
								</div>
								<div class="card-body d-flex">
									<div class="align-self-center w-100">
										<div class="py-3">
											<div class="chart chart-xs">
												<canvas id="chartjs-dashboard-pie"></canvas>
											</div>
										</div>

										<table class="table mb-0">
											<tbody>
												<tr>
													<td>Chrome</td>
													<td class="text-end">4306</td>
												</tr>
												<tr>
													<td>Firefox</td>
													<td class="text-end">3801</td>
												</tr>
												<tr>
													<td>IE</td>
													<td class="text-end">1689</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-12 col-xxl-6 d-flex order-3 order-xxl-2">
							<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0">Real-Time</h5>
								</div>
								<div class="card-body px-4">
									<div id="world_map" style="height:350px;"></div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6 col-xxl-3 d-flex order-1 order-xxl-1">
							<div class="card flex-fill">
								<div class="card-header">

									<h5 class="card-title mb-0">Calendar</h5>
								</div>
								<div class="card-body d-flex">
									<div class="align-self-center w-100">
										<div class="chart">
											<div id="datetimepicker-dashboard"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div> --}}

					<div class="row">
						<div class="col-12 col-lg-8 col-xxl-9 d-flex">
							<div class="card flex-fill">
								<div class="card-header">

									<h5 class="card-title mb-0">Transaksi Terakhir</h5>
								</div>
								<table class="table table-hover my-0">
									<thead>
										<tr>
											<th>NO</th>
											<th class="">Usaha</th>
											<th class="d-none d-xl-table-cell">Tanggal</th>
											<th class="d-none d-xl-table-cell">Pelanggan</th>
											<th class="">Total Harga</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
                                        @foreach($transaksiTerakhir as $item)
										<tr>
											<td>{{$loop->iteration}}</td>
											<td class="d-none d-xl-table-cell">{{$item->usaha->nama_usaha}}</td>
											<td class="d-none d-xl-table-cell">{{formatTanggal($item->tanggal)}}</td>
											<td class="d-none d-xl-table-cell">{{$item->pelanggan->nama}}</td>
											<td><span class="badge bg-success">{{formatRupiah($item->total_harga)}}</span></td>
											<td class="d-none d-md-table-cell">
                                                <button class="btn btn-success" class="d-flex align-items-center"> 
                                                <i data-feather="eye"></i>
                                                <span>
                                                    Detail
                                                </span>
                                            </button></td>
										</tr>
                                        @endforeach
										
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-12 col-lg-4 col-xxl-3 d-flex">
							<div class="card flex-fill w-100">
								<div class="card-header">

										<h5 class="card-title mb-0">Penjualan Perbulan</h5>
								</div>
								<div class="card-body d-flex w-100">
									<div class="align-self-center chart chart-lg">
										<canvas id="chartjs-dashboard-bar"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</main>

            
@push('scripts')
			
	<script>
document.addEventListener("DOMContentLoaded", function () {
    $.ajax({
        url: "{{ route('getChartData') }}",
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response); // ✅ Ini hasilnya di console

            var ctx = document.getElementById("chartjs-dashboard-line").getContext("2d");
            var gradient = ctx.createLinearGradient(0, 0, 0, 225);
            gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
            gradient.addColorStop(1, "rgba(215, 227, 244, 0)");

            new Chart(ctx, {
                type: "line",
                data: {
                    labels: response.labels,
                    datasets: [{
                        label: "Transaksi Selesai",
                        fill: true,
                        backgroundColor: gradient,
                        borderColor: "#467fcf",
                        data: response.data
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        filler: {
                            propagate: false
                        }
                    },
                    tooltips: {
                        intersect: false
                    },
                    hover: {
                        intersect: true
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                color: "rgba(0,0,0,0.0)"
                            }
                        }],
                        yAxes: [{
                           ticks: {
        // Format angka ke Rp
        callback: function (value) {
            return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        // Batas maksimum jumlah label di Y-axis
        maxTicksLimit: 6,
        // Boleh ditambahkan agar skala tidak mentok
        suggestedMin: 0,
        suggestedMax: 2500000
    },
                            gridLines: {
                                color: "rgba(0,0,0,0.0)"
                            }
                        }]
                    }
                }
            });
        },
        error: function (xhr) {
            console.error("Gagal ambil data chart:", xhr);
        }
    });
});


</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    $.ajax({
        url: "/chart/monthly",
        method: "GET",
        success: function (response) {
            const ctx = document.getElementById("chartjs-dashboard-bar").getContext("2d");
            console.log('Response chart:', response);

            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: response.labels, // gunakan labels dari response
                    datasets: [{
                        label: "Pendapatan Bulanan",
                        backgroundColor: window.theme.primary,
                        borderColor: window.theme.primary,
                        hoverBackgroundColor: window.theme.primary,
                        hoverBorderColor: window.theme.primary,
                        data: response.data.map(val => parseInt(val)), // pastikan datanya angka
                        barPercentage: 0.75,
                        categoryPercentage: 0.5
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: { display: false },
                    scales: {
                        yAxes: [{
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString("id-ID");
                                },
                                beginAtZero: true
                            },
                            gridLines: {
                                display: false
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                color: "transparent"
                            }
                        }]
                    }
                }
            });
        }
    });
});
</script>


@endpush
      @endsection