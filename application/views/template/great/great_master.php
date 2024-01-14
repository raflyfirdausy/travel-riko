<!DOCTYPE html>
<html lang="id">

<head>
    <title><?= !empty($title) ? ($title . " | " . env("APP_SIMPLE_NAME")) : env("APP_NAME") ?></title>

    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="<?= env("APP_NAME") ?>">
    <meta name="author" content="<?= env("APP_AUTHOR_NAME") ?>">

    <!-- Favicons -->
    <link href="<?= logo_klinik() ?>" rel="icon">
    <link href="<?= logo_klinik() ?>" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?= great() ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= great() ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= great() ?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?= great() ?>assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="<?= great() ?>assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="<?= great() ?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="<?= great() ?>assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link href="<?= great() ?>assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <link href="<?= great() ?>assets/extra-libs/toastr/dist/build/toastr.min.css" rel="stylesheet">
    <link href="<?= lte("plugins/fontawesome-free/css/all.min.css") ?>" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?= great() ?>assets/css/style.css" rel="stylesheet">

    <script src="<?= great() ?>assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?= great() ?>assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>

    <script src="<?= asset('RFL_HELPER/RFL_core.js'); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.min.js " integrity="sha512-eVL5Lb9al9FzgR63gDs1MxcDS2wFu3loYAgjIH0+Hg38tCS8Ag62dwKyH+wzDb+QauDpEZjXbMn11blw8cbTJQ==" crossorigin=" anonymous "></script>
    <script>
        <?php $SOCKET_SERVER = getSocketUrl(); ?>
        var socketIO = io.connect('<?= "$SOCKET_SERVER/" ?>', {
            transports: ['websocket', 'polling', 'flashsocket']
        });

        socketIO.on('connect', () => {
            const sessionID = socketIO.id
            console.log(sessionID)
            $("#socket_id").html("Websocket : <strong>Connected</strong>")
        })

        socketIO.on("user_online", data => {
            $("#userOnline").html("User Online : <strong>" + data + " Orang</strong> ")
        })
    </script>
</head>

<body>
    <?php $this->load->view("template/great/great_header") ?>
    
    <?php $this->menu->generate() ?>

    <main id="main" class="main">
        <?php $this->load->view("template/great/great_pagetitle") ?>
    </main>

    <?php $this->load->view("template/great/great_footer") ?>
    <?php $this->load->view("template/great/great_script") ?>
</body>

</html>