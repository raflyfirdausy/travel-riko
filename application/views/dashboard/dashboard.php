<style>
    .card-title {
        padding: 0 8px;
    }
</style>

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">

                <div class="col-md-4">
                    <div class="card info-card">
                        <div class="card-body p-3">
                            <h5 class="card-title" style="padding:0 8px">Total Pengguna</h5>
                            <div class="d-flex align-items-center">
                                <div style="color:#2eca6a;background:#e0f8e9" class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="totalPetugas"><?= $total["user"] ?></h6>
                                    <span class="text-muted small pt-2 ps-1">Pengguna</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card info-card">
                        <div class="card-body p-3">
                            <h5 class="card-title" style="padding:0 8px">Total Kota</h5>
                            <div class="d-flex align-items-center">
                                <div style="color:#4154f1;background:#f6f6fe" class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div class="ps-3">
                                <h6 id="totalPetugas"><?= $total["kota"] ?></h6>
                                    <span class="text-muted small pt-2 ps-1">Kota</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card info-card">
                        <div class="card-body p-3">
                            <h5 class="card-title" style="padding:0 8px">Total Kendaraan</h5>
                            <div class="d-flex align-items-center">
                                <div style="color:#ff771d;background:#ffecdf" class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fas fa-car"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="totalLokasi"><?= $total["kendaraan"] ?></h6>
                                    <span class="text-muted small pt-2 ps-1">Kendaraan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card info-card">
                        <div class="card-body p-3">
                            <h5 class="card-title" style="padding:0 8px">Pesanan Menunggu</h5>
                            <div class="d-flex align-items-center">
                                <div style="color:#ca2eab;background:#fac8f0" class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="totalPetugas"><?= $total["menunggu"] ?></h6>
                                    <span class="text-muted small pt-2 ps-1">Pesanan</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card info-card">
                        <div class="card-body p-3">
                            <h5 class="card-title" style="padding:0 8px">Pesanan Diproses</h5>
                            <div class="d-flex align-items-center">
                                <div style="color:#17850d;background:#ccfac8" class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="ps-3">
                                <h6 id="totalPetugas"><?= $total["diproses"] ?></h6>
                                    <span class="text-muted small pt-2 ps-1">Pesanan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card info-card">
                        <div class="card-body p-3">
                            <h5 class="card-title" style="padding:0 8px">Pesanan Ditolak</h5>
                            <div class="d-flex align-items-center">
                                <div style="color:#850d0f;background:#fac5c6" class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fas fa-times"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="totalLokasi"><?= $total["ditolak"] ?></h6>
                                    <span class="text-muted small pt-2 ps-1">Pesanan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
    var chart
    document.addEventListener("DOMContentLoaded", () => {
        chart = new ApexCharts(document.querySelector("#reportsChart"), {
            chart: {
                height: 350,
                type: 'area',
                sparkline: {
                    enabled: false,
                },
                animations: {
                    enabled: true,
                    easing: 'easeout',
                    speed: 1000,
                    animateGradually: {
                        enabled: true,
                        delay: 150
                    },
                    dynamicAnimation: {
                        enabled: true,
                        speed: 500
                    }
                },
                toolbar: {
                    show: true
                },
            },
            theme: {
                mode: 'light',
                palette: 'palette1',
            },
            series: [],
            markers: {
                size: 4
            },
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.3,
                    opacityTo: 0.4,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                type: 'category',
                categories: []
            },
            yaxis: [],
            noData: {
                text: "<?= $petugas ?>"
            },
        })
        chart.render()
    });

    $(document).ready(e => {
        //getGrafik()
    })

    const getGrafik = () => {
        $.ajax({
            type: "GET",
            dataType: "JSON",
            url: "/api/web/dashboard/grafik",
            success: function(result) {
                if (result.code == 200) {
                    chart.updateSeries(result.data.series)
                    chart.updateOptions({
                        xaxis: {
                            categories: result.data.categories
                        }
                    })
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                toastr.error(xhr.responseText, 'Gagal', {
                    closeButton: true,
                    timeOut: 5000
                });
            }
        })
    }
</script>