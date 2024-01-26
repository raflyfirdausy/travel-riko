<!DOCTYPE html>
<html lang="id">

<head>
    <title><?= !empty($title) ? ($title . " | " . env("APP_SIMPLE_NAME")) : env("APP_NAME") ?></title>

    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="<?= env("APP_NAME") ?>">
    <meta name="author" content="<?= env("APP_AUTHOR_NAME") ?>">

    <!-- Favicons -->
    <link href="<?= getFavicon() ?>" rel="icon">
    <link href="<?= getFavicon() ?>" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?= nice() ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= nice() ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= nice() ?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?= nice() ?>assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="<?= nice() ?>assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="<?= nice() ?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="<?= nice() ?>assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <link href="<?= nice() ?>assets/extra-libs/toastr/dist/build/toastr.min.css" rel="stylesheet">
    <link href="<?= nice("assets/extra-libs/fontawesome-free/css/all.min.css") ?>" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <!-- Template Main CSS File -->
    <link href="<?= nice() ?>assets/css/style.css" rel="stylesheet">

    <script src="<?= nice() ?>assets/libs/jquery/dist/jquery.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>


    <link href="<?= great('assets/extra-libs/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'); ?>" rel="stylesheet">
    <link href="<?= nice("assets/extra-libs/toastr/dist/build/toastr.min.css") ?>" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    <script src="<?= asset('RFL_HELPER/RFL_core.js'); ?>"></script>
    <script src="<?= asset('RFL_HELPER/RFL_format.js'); ?>"></script>
    <style>
        .float-right {
            float: right;
        }
    </style>
    <script>
        const BASE_URL = "<?= base_url() ?>"
        let NEED_TO_SELECT = []
    </script>
</head>

<body>
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="<?= base_url() ?>" class="logo d-flex align-items-center">
                <span class="d-none d-lg-block"><?= getSetting("JUDUL_WEBSITE") ?: env("APP_TITLE") ?></span>
            </a>
        </div>
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="<?= base_url("auth/login") ?>">
                        <img src="<?= getFavicon() ?>" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block ps-2">
                            MASUK APLIKASI
                        </span>
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    <main id="main" class="main" style="margin-left: 0;">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Tanggal Pemesanan <span class="text-danger">*</span></label>
                            <input required type="date" name="tanggal_pemesanan" id="tanggal_pemesanan" class="form-control" min="<?= date("Y-m-d") ?>" value="<?= date("Y-m-d") ?>">
                        </div>
                        <div class="col-md-6 mt-2">
                            <br>
                            <button class="btn btn-primary" onclick="lihatJadwal()" id="btnLihatJadwal">Lihat Jadwal</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <div class="row mt-3" id="layoutTable">
                            <div class="table-responsive">
                                <table id="table_data" class="table table-sm nowrap table-bordered table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Gambar</th>
                                            <th>Kota Asal</th>
                                            <th>Kota Tujuan</th>
                                            <th>Nama Kendaraan</th>
                                            <th>Waktu Berangkat</th>
                                            <th>Waktu Sampai</th>
                                            <th>Sisa Kursi</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bodyTable"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer" style="margin-left: 0;">
        <div class="copyright">
            Copyright &copy; <?= date("Y") ?> <strong><span><?= env("APP_NAME") ?></span></strong> All Rights Reserved | Made with ❤️ by <a href="https://instagram.com/rafly_firdausy"><strong>Ultranesia.com</strong></a>
        </div>
        <div class="credits">
            Version <strong><?= VERSION ?></strong> | Rendered by <strong><?= $this->benchmark->elapsed_time() ?></strong> second and <strong><?= $this->benchmark->memory_usage() ?></strong> Memory <span><?= env("APP_ENV") != "production" ? " | DEV" : "" ?></span>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <?php $this->load->view("template/great/great_script") ?>


    <script>
        $(document).ready(e => {
            lihatJadwal()
        })
        const lihatJadwal = () => {
            let tanggal = $("#tanggal_pemesanan").val()
            Swal.fire({
                title: 'Mohon Tunggu Beberapa Saat',
                text: 'Sedang mengambil data...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                    $.ajax({
                        type: "GET",
                        dataType: "JSON",
                        contentType: "application/json; charset=utf-8",
                        url: "<?= base_url("jadwal/lihat-jadwal/") ?>" + tanggal,
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: function(result) {
                            Swal.close()
                            if (result.code == 200) {
                                setData(result.data)
                            } else {
                                Swal.fire({
                                    title: 'Gagal',
                                    html: result.message,
                                    icon: 'error',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Tutup'
                                })
                            }

                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            Swal.fire({
                                title: 'Gagal',
                                text: xhr.responseText,
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Tutup'
                            })
                        }
                    })
                }
            })
        }

        const setData = (data) => {
            console.log({
                data
            })
            const defaultRow = /* html */ `
            <tr>
                <td class="text-center" colspan="9">Mohon maaf, jadwal tidak ditemukan. Silahkan ubah tanggal pemesanan</td>
            </tr>
        `
            $("#bodyTable").html(defaultRow)
            let htmlAppend = ""
            data.forEach((currentValue, index, dataArray) => {
                htmlAppend += /* html */ `
                <tr>
                    <td class="text-center">${index+1}</td>
                    <td class="text-center"><img style="cursor: pointer;" onclick="showModalIframe('Detail Kendaraan', '${currentValue.image_kendaraan}', 'YA')" height="50px" src="${currentValue.image_kendaraan}" alt="${currentValue.nama_kendaraan}"></td>
                    <td>${currentValue.nama_kota_asal}</td>
                    <td>${currentValue.nama_kota_tujuan}</td>
                    <td>${currentValue.nama_kendaraan}</td>
                    <td>${currentValue.waktu_berangkat}</td>
                    <td>${currentValue.waktu_sampai}</td>
                    <td>${currentValue.sisa_kursi}</td>
                    <td>${formatRupiah(currentValue.harga)}</td>                    
                </tr>
            `
            })
            if (htmlAppend !== "") $("#bodyTable").html(htmlAppend)
        }
    </script>
</body>