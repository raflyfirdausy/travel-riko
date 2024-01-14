  <!-- Vendor JS Files -->
  <script src="<?= great() ?>assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="<?= great() ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= great() ?>assets/vendor/chart.js/chart.umd.js"></script>
  <script src="<?= great() ?>assets/vendor/echarts/echarts.min.js"></script>
  <script src="<?= great() ?>assets/vendor/quill/quill.min.js"></script>
  <script src="<?= great() ?>assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="<?= great() ?>assets/vendor/php-email-form/validate.js"></script>

  <script src="<?= great('assets/extra-libs/sweetalert2/sweetalert2.min.js'); ?>"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="<?= great('assets/extra-libs/toastr/dist/build/toastr.min.js'); ?>"></script>


  <!-- Template Main JS File -->
  <script src="<?= great() ?>assets/js/main.js"></script>

  <script>
    $(".select2").select2({
      // theme: 'bootstrap-5',
      width: '100%',
    })

    $(".select2bs4").select2({
      theme: 'bootstrap-5',
      width: '100%',
    })

    $('.modal').on('shown.bs.modal', function(e) {
      $(this).find('.select2').select2({
        width: '100%',
        theme: 'bootstrap-5',
        dropdownParent: $(this).find('.modal-content')
      });
    })

    NEED_TO_SELECT.forEach((currentValue, index, arr) => {
      generateSelect2InModalServerSide(currentValue["id"], currentValue["path"], currentValue["placeholder"])
    })
  </script>



  <?php if ($this->session->flashdata("sukses")) : ?>
    <script>
      toastr.success('<?= $this->session->flashdata("sukses") ?>', 'Sukses', {
        closeButton: true,
        timeOut: 5000
      });
    </script>
  <?php unset($_SESSION["sukses"]);
  endif; ?>

  <?php if ($this->session->flashdata("gagal")) : ?>
    <script>
      toastr.error('<?= $this->session->flashdata("gagal") ?>', 'Gagal', {
        closeButton: true,
        timeOut: 5000
      });
    </script>
  <?php unset($_SESSION["gagal"]);
  endif; ?>