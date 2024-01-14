<div class="card">
    <div class="card-header">
        <a href="<?= back() ?>" type="button" class="btn btn-primary float-left"><i class="fas fa-chevron-left"></i> Kembali</a>
        <div class="dropdown float-right">

            <?php if (isset($ENABLE_EXPORT_IMPORT_BUTTON) && $ENABLE_EXPORT_IMPORT_BUTTON) : ?>
                <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownImportExport" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-folder"></i> Import & Export
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownImportExport">
                    <button data-bs-toggle="modal" data-bs-target="#modal_import" class="dropdown-item"><i class="fas fa-file-import"></i> Import</button>
                    <a href="<?= $URL_EXPORT_DATA ?>" class="dropdown-item"><i class="fas fa-file-export"></i> Export</a>
                </div>
            <?php endif ?>

            <?php if (isset($ENABLE_ADD_BUTTON) && $ENABLE_ADD_BUTTON) : ?>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal_tambah">
                    <i class="fas fa-plus"></i> Tambah Data <?= $title ?>
                </button>
            <?php endif ?>
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

<?php if (isset($ENABLE_EXPORT_IMPORT_BUTTON) && $ENABLE_EXPORT_IMPORT_BUTTON) : ?>
    <div class="modal fade" id="modal_import" tabindex="-1">
        <form id="form_import" action="<?= $URL_IMPORT_DATA  ?>" method="post" enctype="multipart/form-data">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title text-white">Import Data <?= $this->module ?></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group px-1">
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="mb-2">Silahkan upload file Excel yang berisi format yang sudah ditentukan.
                                        <button class="btn btn-danger text-white btn-sm">
                                            <a class="text-white" href="<?= $URL_FORMAT_IMPORT ?>">Download Format Excel Disini</a>
                                        </button>
                                    </span>
                                </div>
                                <div class="col-md-12">
                                    <label for="file_server" class="mb-0 control-label">File (.xlsx) <span class="text-danger">*</span> </label>
                                    <input accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" class="form-control" type="file" name="file_import" id="file_import">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-danger proses_btn">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php endif ?>