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
                                    <h6 id="totalPetugas">Loading...</h6>
                                    <span class="text-muted small pt-2 ps-1">Pengguna</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card info-card">
                        <div class="card-body p-3">
                            <h5 class="card-title" style="padding:0 8px">Total Pesanan</h5>
                            <div class="d-flex align-items-center">
                                <div style="color:#4154f1;background:#f6f6fe" class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="totalTempat">Loading...</h6>
                                    <span class="text-muted small pt-2 ps-1">Pesanan</span>
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
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="totalLokasi">Loading...</h6>
                                    <span class="text-muted small pt-2 ps-1">Lokasi</span>
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
    $(document).ready(e => {
        //getData()
    })

    const resetTextColor = (element) => {
        element.removeClass("text-success")
        element.removeClass("text-danger")
        element.removeClass("text-warning")
    }

    const setLoading = () => {
        let textLoading = "<?= $petugas ?>"
        $("#totalKelas").text(textLoading)
        $("#totalMurid").text(textLoading)
        $("#totalNoHp").text(textLoading)
        $("#totalSemua").text(textLoading)
        $("#total7").text(textLoading)
        $("#total8").text(textLoading)
        $("#total9").text(textLoading)

        resetTextColor($("#percentSemua"))
        resetTextColor($("#percent7"))
        resetTextColor($("#percent8"))
        resetTextColor($("#percent9"))
    }

    const getData = () => {
        setLoading()
        $.ajax({
            type: "GET",
            dataType: "JSON",
            url: "/api/web/dashboard/data",
            success: function(result) {
                if (result.code == 200) {
                    let data = result.data
                    $("#totalKelas").text(formatRupiah(data.totalKelas.toString()))
                    $("#totalMurid").text(formatRupiah(data.totalMurid.toString()))
                    $("#totalNoHp").text(formatRupiah(data.totalNoHp.toString()))

                    $("#totalSemua").text(formatRupiah(data.semua.now.toString()))
                    $("#total7").text(formatRupiah(data.kelas7.now.toString()))
                    $("#total8").text(formatRupiah(data.kelas8.now.toString()))
                    $("#total9").text(formatRupiah(data.kelas9.now.toString()))

                    $("#percentSemua").addClass(`text-${data.semua.status}`)
                    $("#percent7").addClass(`text-${data.kelas7.status}`)
                    $("#percent8").addClass(`text-${data.kelas8.status}`)
                    $("#percent9").addClass(`text-${data.kelas9.status}`)

                    $("#percentSemua").text(`${data.semua.percent}%`)
                    $("#percent7").text(`${data.kelas7.percent}%`)
                    $("#percent8").text(`${data.kelas8.percent}%`)
                    $("#percent9").text(`${data.kelas9.percent}%`)

                    $("#keteranganSemua").text(`${data.semua.note} dari hari kemarin (${formatRupiah(data.semua.yesterday.toString())})`)
                    $("#keterangan7").text(`${data.kelas7.note} dari hari kemarin (${formatRupiah(data.kelas7.yesterday.toString())})`)
                    $("#keterangan8").text(`${data.kelas9.note} dari hari kemarin (${formatRupiah(data.kelas8.yesterday.toString())})`)
                    $("#keterangan9").text(`${data.kelas8.note} dari hari kemarin (${formatRupiah(data.kelas9.yesterday.toString())})`)
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                Swal.close()
                toastr.error(xhr.responseText, 'Gagal', {
                    closeButton: true,
                    timeOut: 5000
                });
            }
        })
    }
</script>

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