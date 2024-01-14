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
    <?php $this->load->view("template/great/great_header") ?>
    <?php $this->menu->generate() ?>

    <main id="main" class="main">
        <?php $this->load->view("template/great/great_pagetitle") ?>