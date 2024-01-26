<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Masuk | <?= $app_complete_name ?></title>
    <meta name="description" content="<?= env("APP_NAME") ?>">
    <meta name="author" content="<?= env("APP_AUTHOR_NAME") ?>">
    <link rel="icon" href="<?= logo_aplikasi() ?>">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?= nice("assets/vendor/bootstrap/css/bootstrap.min.css") ?>" rel="stylesheet">
    <link href="<?= nice("assets/vendor/bootstrap-icons/bootstrap-icons.css") ?>" rel="stylesheet">
    <link href="<?= nice("assets/vendor/boxicons/css/boxicons.min.css") ?>" rel="stylesheet">
    <link href="<?= nice("assets/vendor/quill/quill.snow.css") ?>" rel="stylesheet">
    <link href="<?= nice("assets/vendor/quill/quill.bubble.css") ?>" rel="stylesheet">
    <link href="<?= nice("assets/vendor/remixicon/remixicon.css") ?>" rel="stylesheet">
    <link href="<?= nice("assets/vendor/simple-datatables/style.css") ?>" rel="stylesheet">
    <script src="<?= nice() ?>assets/libs/jquery/dist/jquery.min.js"></script>
    <link href="<?= great('assets/extra-libs/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'); ?>" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?= nice("assets/css/style.css") ?>" rel="stylesheet">
</head>

<style type="text/css">
    .bg {
        background-image: url('<?= asset("img/app/bg.jpg") ?>');
        background-size: cover;
        box-shadow: inset 0 0 0 2000px rgba(0, 0, 0, 0.6);
    }
</style>

<body>
    <main class="bg">
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="card mb-3">
                                <div class="card-body p-3">
                                    <div class="pt-2">
                                        <div class="text-center">
                                            <a href="<?= base_url() ?>" style="font-size:24px;" class="h1 text-center card-title pb-0 pt-0"><b><?= env("APP_SIMPLE_NAME") ?></b></a>
                                        </div>
                                        <p class="text-center small">Selamat mendaftar sebagai pengguna untuk mendapatkan fasilitas booking travel secara online</p>
                                    </div>
                                    <hr>
                                    <form action="<?= base_url('auth/register_proses') ?>" id="registerForm" method="POST" class="row g-3 needs-validation">
                                        <?php if ($this->session->flashdata("gagal")) : ?>
                                            <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                                                <strong>Gagal !</strong> <?= $this->session->flashdata("gagal") ?>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        <?php unset($_SESSION["gagal"]);
                                        endif; ?>


                                        <div class="col-12">
                                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                            <div class="input-group has-validation">
                                                <input type="text" name="nama_lengkap" placeholder="Silahkan isi nama lengkap kamu" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Telepon <span class="text-danger">*</span></label>
                                            <div class="input-group has-validation">
                                                <input type="tel" name="telp" placeholder="Silahkan isi no telepon" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                            <div class="input-group has-validation">
                                                <select required name="jenis_kelamin" id="jenis_kelamin" class="form-control select2">
                                                    <option value="">Pilih Jenis Kelamin</option>
                                                    <option value="LAKI-LAKI">LAKI-LAKI</option>
                                                    <option value="PEREMPUAN">PEREMPUAN</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Username <span class="text-danger">*</span></label>
                                            <div class="input-group has-validation">
                                                <input type="text" name="username" placeholder="Silahkan isi username untuk masuk aplikasi" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Password <span class="text-danger">*</span></label>
                                            <div class="input-group has-validation">
                                                <input type="password" name="password" placeholder="Silahkan isi password" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                            <div class="input-group has-validation">
                                                <input type="password" name="konfirmasi_password" placeholder="Silahkan isi konfirmasi password" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary w-100 proses_btn" type="submit">Daftar</button>
                                        </div>

                                        <div class="col-12">
                                            <p class="small mb-0">Sudah punya akun ? <a href="<?= base_url("auth/login") ?>">Masuk disini</a></p>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Vendor JS Files -->
    <script src="<?= nice("assets/vendor/apexcharts/apexcharts.min.js") ?>"></script>
    <script src="<?= nice("assets/vendor/bootstrap/js/bootstrap.bundle.min.js") ?>"></script>
    <script src="<?= nice("assets/vendor/chart.js/chart.umd.js") ?>"></script>
    <script src="<?= nice("assets/vendor/echarts/echarts.min.js") ?>"></script>
    <script src="<?= nice("assets/vendor/quill/quill.min.js") ?>"></script>
    <script src="<?= nice("assets/vendor/simple-datatables/simple-datatables.js") ?>"></script>
    <script src="<?= nice("assets/vendor/tinymce/tinymce.min.js") ?>"></script>
    <script src="<?= nice("assets/vendor/php-email-form/validate.js") ?>"></script>

    <!-- Template Main JS File -->
    <script src="<?= nice("assets/js/main.js") ?>"></script>
    <script src="<?= great('assets/extra-libs/sweetalert2/sweetalert2.min.js'); ?>"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $("#registerForm").submit(e => {
            e.preventDefault()
            var form = $(`#registerForm`)[0]
            var data = new FormData(form)

            $(".proses_btn").prop('disabled', true)
            $(".proses_btn").text("Sedang proses pendaftaran...")

            Swal.fire({
                title: 'Mohon Tunggu Beberapa Saat',
                text: 'Sedang menyimpan data...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                    $.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: "<?= base_url("auth/register-proses") ?>",
                        data: data,
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: function(result) {
                            $(".proses_btn").prop('disabled', false)
                            $(".proses_btn").text("Daftar")
                            if (result.code == 200) {
                                Swal.fire({
                                    title: 'Sukses',
                                    text: result.message,
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Tutup'
                                }).then((result) => {
                                    $(`#registerForm`).trigger("reset");
                                    location.href = "<?= base_url("auth/login") ?>";
                                })
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
                            $(".proses_btn").prop('disabled', false)
                            $(".proses_btn").text("Simpan")
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
        })
    </script>

</body>

</html>