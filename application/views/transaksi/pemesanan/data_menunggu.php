<section class="section">
    <div class="card">
        <div class="card-header">
            <a href="<?= back() ?>" type="button" class="btn btn-primary float-left"><i class="fas fa-chevron-left"></i> Kembali</a>
            <div class="dropdown float-right">
                <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownImportExport" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-folder"></i> Export Data
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownImportExport">                    
                    <a href="<?= $URL_EXPORT_DATA ?>" class="dropdown-item"><i class="fas fa-file-export"></i> Export</a>
                </div>
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive" style="min-height: 350px;">
                <table id="table_data" class="table table-sm nowrap table-bordered table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 3%">No.</th>
                            <th style="width: 1%">Aksi</th>
                            <?php foreach ($FIELD_FORM as $form) :
                                $isHideFromTable = isset($form["hideFromTable"]) ? $form["hideFromTable"] : FALSE;
                            ?>
                                <?php if ($form["type"] != "hidden" && !$isHideFromTable) : ?>
                                    <th><?= $form["label"] ?></th>
                                <?php endif ?>
                            <?php endforeach ?>
                            <th>Terakhir Diperbaharui</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <?php $this->load->view($RFL_MODAL, [
        "modal_id"      => "modal_tambah",
        "modal_title"   => "Form Tambah",
        "modal_form_id" => "form_add",
        "modal_edit"    => FALSE
    ]) ?>

    <?php $this->load->view($RFL_MODAL, [
        "modal_id"      => "modal_edit",
        "modal_title"   => "Form Edit",
        "modal_form_id" => "form_edit",
        "modal_edit"    => TRUE
    ]) ?>

    <?php $this->load->view($RFL_MODAL_IFRAME) ?>
    <div id="section_modal_select"></div>

</section>

<script>
    let RFL_COLUMNS = [{
            "data": "<?= $this->model->primary_key ?>",
            "sortable": false,
            className: "text-center align-middle",
            render: function(data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        {
            "data": "<?= $this->model->primary_key ?>",
            className: "text-center align-middle",
            render: function(data, type, row, meta) {
                let result = /* html */ `              
                    <div class="dropdown">
                        <button style="width:100%" class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pilih Aksi
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">                                                                                     
                            <a href="<?= base_url('/transaksi/pemesanan/detail/view/') ?>${data}" class="dropdown-item"><i class="fas fa-eye"></i> Detail</a>
                            <a href="<?= base_url('/transaksi/pemesanan/tambah/pembayaran/') ?>${data}" class="dropdown-item"><i class="fas fa-file-invoice-dollar"></i> Pembayaran</a>
                            <button onclick="terimaTolak('${data}')" class="dropdown-item"><i class="fas fa-question"></i> Terima / Tolak</button>                                                                  
                            <button onclick="hapus('${data}')" class="dropdown-item"><i class="fas fa-trash"></i> Hapus</button>                                                                  
                        </div>
                    </div>`
                return result;
            }
        },
    ]
    let HIDE_SEARCH = [0, 1]
    <?php $index = 0;
    foreach ($FIELD_FORM as $form) : $isHideFromTable = isset($form["hideFromTable"]) ? $form["hideFromTable"] : FALSE; ?>
        <?php if (isset($form["search"]) && !$form["search"]) : ?>
            HIDE_SEARCH.push(<?= $index + 2 ?>)
        <?php endif ?>
        <?php if ($form["type"] != "hidden" && !$isHideFromTable) : ?>
            <?php if (isset($form["isImage"]) && $form["isImage"]) : ?>
                <?php if (isset($form["iframe"]) && $form["iframe"]) : ?>
                    RFL_COLUMNS.push({
                        "data": "<?= isset($form["name_alias"]) ? $form["name_alias"] : $form["name"] ?>",
                        "className": "text-center",
                        render: function(data, type, row, meta) {
                            let dataImage = (typeof data !== undefined && data !== "" && data !== null) ? "<?= base_url() . $form["location"] ?>" + data : "<?= NO_IMAGE ?>"
                            return `<img style="cursor: pointer;" onclick="showModalIframe('Detail <?= $form["label"] ?>', '${dataImage}', 'YA')" height="50px" src="${dataImage}" alt="<?= $form["label"] ?>">`;
                        }
                    })
                <?php else : ?>
                    RFL_COLUMNS.push({
                        "data": "<?= isset($form["name_alias"]) ? $form["name_alias"] : $form["name"] ?>",
                        "className": "text-center",
                        render: function(data, type, row, meta) {
                            let dataImage = (typeof data !== undefined && data !== "" && data !== null) ? "<?= base_url() . $form["location"] ?>" + data : "<?= NO_IMAGE ?>"
                            return `<a target="_blank" href="${dataImage}"><img height="50px" src="${dataImage}" alt="<?= $form["label"] ?>"></a>`;
                        }
                    })
                <?php endif ?>
            <?php elseif (isset($form["iframe"]) && $form["iframe"]) : ?>
                RFL_COLUMNS.push({
                    "data": "<?= isset($form["name_alias"]) ? $form["name_alias"] : $form["name"] ?>",
                    "className": "text-center",
                    render: function(data, type, row, meta) {
                        let dataLink = (typeof data !== undefined && data !== "" && data !== null) ? "<?= base_url() . $form["location"] ?>" + data : "/not-found"
                        return `<button type="button" onclick="showModalIframe('Detail <?= $form["label"] ?>', '${dataLink}')" href="${dataLink})" class="btn btn-sm btn-secondary">Lihat <?= $form["label"] ?></button>`;
                    }
                })
            <?php elseif (isset($form["isLink"]) && $form["isLink"]) : ?>
                RFL_COLUMNS.push({
                    "data": "<?= isset($form["name_alias"]) ? $form["name_alias"] : $form["name"] ?>",
                    "className": "text-center",
                    render: function(data, type, row, meta) {
                        let dataLink = (typeof data !== undefined && data !== "" && data !== null) ? "<?= base_url() . $form["location"] ?>" + data : "<?= NO_IMAGE ?>"
                        return `<a target="_blank" href="${dataLink}" class="btn btn-sm btn-success">Lihat <?= $form["label"] ?></a>`;
                    }
                })
            <?php else : ?>
                RFL_COLUMNS.push({
                    "data": "<?= isset($form["name_alias"]) ? $form["name_alias"] : $form["name"] ?>",
                    render: function(data, type, row, meta) {
                        return makeReadMore(data, 50)
                    }
                })
            <?php endif ?>
        <?php endif ?>

    <?php $index++;
    endforeach ?>
    RFL_COLUMNS.push({
        "data": "updated_at"
    })

    var RFL_TABLE = generateDatatable("table_data", "<?= $URL_GET_DATA ?>", RFL_COLUMNS)
    generateAjaxProses("form_add", "<?= $URL_CREATE_DATA ?>", RFL_TABLE)
    generateAjaxProses("form_edit", "<?= $URL_UPDATE_DATA ?>", RFL_TABLE)
    generateAjaxProses("form_import", "<?= $URL_IMPORT_DATA ?>", RFL_TABLE)

    const hapus = id => hapusData(id, "<?= $URL_DELETE_DATA ?>", RFL_TABLE)
    const modalEdit = id => modalEditAction(id, "<?= $URL_DETAIL_DATA ?>", "modal_edit", <?= json_encode($FIELD_FORM) ?>)

    $(document).ready(() => {

        generateSearchTable("table_data", RFL_TABLE, HIDE_SEARCH)
        $(".select2").select2()

        <?php foreach ($FIELD_FORM as $form) :
            $idForm             = $form["name"];
            $idFormEdit         = $form["name"] . "_edit";
            $isRequired         = $form["required"]                 ? "required"                : "";
            $isHideFromTable    = isset($form["hideFromTable"])     ? $form["hideFromTable"]    : FALSE;
            $ishideFromCreate   = isset($form["hideFromCreate"])    ? $form["hideFromCreate"]   : FALSE;
        ?>
            <?php if ($form["type"] == "select" && $form["options"]["chain"]) :
                $idFormTo       = $form["options"]["to"];
                $idFormToEdit   = $form["options"]["to"] . "_edit";
                $indexChain     = array_search($form["options"]["to"], array_column($FIELD_FORM, "name"));
            ?>
                $("#<?= $idFormTo ?>").change(() => {

                    <?php if (isset($form["options"]["reset"])) : ?>
                        <?php foreach ($form["options"]["reset"] as $reset) : ?>
                            $("#<?= $reset ?>").val("").trigger("change")
                        <?php endforeach ?>
                    <?php endif ?>

                    let id = $("#<?= $idFormTo ?>").val()
                    $("#<?= $idForm ?>").html(`<option value="" selected disabled>Sedang mencari data..</option>`)
                    $.ajax({
                        url: "<?= $form["options"]["data"] ?>" + id,
                        type: "GET",
                        dataType: "JSON",
                        contentType: "application/json; charset=utf-8",
                        success: function(result) {
                            let _dataSelect2 = `<option value="" selected>Pilih <?= strtolower($FIELD_FORM[$indexChain]["label"]) ?> terlebih dahulu</option>`
                            if (result.code == 200) {
                                _dataSelect2 = `<option value="" selected>Pilih <?= strtolower($form["label"]) ?></option>`
                                result.data.forEach((currentValue, index, arr) => {
                                    _dataSelect2 += `<option value="${currentValue.value}">${currentValue.label}</option>`
                                })
                            } else {
                                _dataSelect2 = `<option value="" selected>${result.message}</option>`
                            }
                            $("#<?= $idForm ?>").html(_dataSelect2)
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            Swal.fire("Oops", xhr.responseText, "error")
                        }
                    })
                })

                $("#<?= $idFormToEdit ?>").change(() => {


                    let id = $("#<?= $idFormToEdit ?>").val()
                    $("#<?= $idFormEdit ?>").html(`<option value="" selected disabled>Sedang mencari data..</option>`)
                    $.ajax({
                        url: "<?= $form["options"]["data"] ?>" + id,
                        type: "GET",
                        dataType: "JSON",
                        contentType: "application/json; charset=utf-8",
                        success: function(result) {
                            let _dataSelect2 = `<option value="" selected>Pilih <?= strtolower($FIELD_FORM[$indexChain]["label"]) ?> terlebih dahulu</option>`
                            if (result.code == 200) {
                                _dataSelect2 = `<option value="" selected>Pilih <?= strtolower($form["label"]) ?></option>`
                                result.data.forEach((currentValue, index, arr) => {
                                    _dataSelect2 += `<option value="${currentValue.value}">${currentValue.label}</option>`
                                })
                            } else {
                                _dataSelect2 = `<option value="" selected>${result.message}</option>`
                            }
                            $("#<?= $idFormEdit ?>").html(_dataSelect2)
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            Swal.fire("Oops", xhr.responseText, "error")
                        }
                    })
                })

            <?php endif ?>
        <?php endforeach ?>
    })
</script>

<script>
    const terimaTolak = uuid => {
        Swal.fire({
            title: "Konfirmasi",
            text: "Apakah pesanan ini diterima atau ditolak ?",
            icon: "warning",

            confirmButtonColor: "#3085d6",
            confirmButtonText: "Terima",

            showCancelButton: true,
            cancelButtonColor: "#d33",

            cancelButtonText: `Tolak`,
            cancelButtonColor: `#f33b3b`
        }).then((result) => {
            console.log({
                result
            })
            if (result.isConfirmed) {
                proses(uuid, "DIPROSES")
            } else if (result.dismiss == "cancel") {
                proses(uuid, "DITOLAK")
            }
        });
    }

    const proses = (uuid, terimaTolak) => {
        Swal.fire({
            title: 'Mohon Tunggu Beberapa Saat',
            text: 'Sedang memproses data...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
                $.ajax({
                    type: "GET",
                    dataType: "JSON",
                    url: "<?= base_url("transaksi/pemesanan/detail/terima-tolak/") ?>" + uuid + "/" + terimaTolak,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(result) {
                        if (result.code == 200) {
                            Swal.fire({
                                title: 'Sukses',
                                text: result.message,
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Tutup'
                            }).then((result) => {
                                RFL_TABLE.ajax.reload(null, false)
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
</script>