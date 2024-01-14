<div class="modal fade" id="modal_add_select" role="dialog" aria-labelledby="modal_add_select_label">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title text-white"><?= $modal_title ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= $FIELD_ACTION ?>" method="POST" id="<?= $form_id ?>" enctype='multipart/form-data'>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <?php
                            foreach ($FIELD_FORM_SELECT as $form) : ?>

                                <?php

                                $modal_edit         = isset($modal_edit)                ? $modal_edit               : FALSE;
                                $modal_form_id      = "modal_add_select";
                                $idForm             = $form["name"] . ($modal_edit ? "_edit" : "");
                                $isRequired         = $modal_edit && isset($form["required_edit"]) ? ($form["required_edit"] ? "required" : "") : ($form["required"] ? "required" : "");
                                $isHideFromTable    = isset($form["hideFromTable"])     ? $form["hideFromTable"]    : FALSE;
                                $isHideFromEdit     = isset($form["hideFromEdit"])      ? $form["hideFromEdit"]     : FALSE;
                                $ishideFromCreate   = isset($form["hideFromCreate"])    ? $form["hideFromCreate"]   : FALSE;
                                $isReadOnly         = isset($form["readOnly"])          ? $form["readOnly"]         : FALSE;
                                $isReadOnlyEdit     = isset($form["readOnlyEdit"])      ? ($form["readOnlyEdit"] && $modal_edit) : FALSE;
                                $readOnly           = $isReadOnly || $isReadOnlyEdit    ? "readonly"                : "";

                                $colId              = isset($form["colProperty"]["id"])     ? 'id="' . $form["colProperty"]["id"] . $modal_form_id . '"'    : "";
                                $colStyle           = isset($form["colProperty"]["style"])  ? 'style="' . $form["colProperty"]["style"] . '"'               : "";

                                $addButton          = $form["type"] == "select" &&
                                    isset($form["options"]["addButton"])        &&
                                    $form["options"]["addButton"] === TRUE      &&
                                    isset($form["options"]["fieldForm"])        &&
                                    !empty($form["options"]["fieldForm"]);

                                // $form["col"]        = $addButton ? ($form["col"] - 1) : $form["col"];
                                $colFix             = (($form["type"] == "hidden") ? 12 : (isset($form["col"]) && is_numeric($form["col"]) ? $form["col"] : 12));

                                ?>

                                <div class="mt-1 col-md-<?= $colFix ?> <?= $addButton ? "col-sm-" . $colFix : "" ?> <?= $colId; ?> <?= $colStyle; ?>>

                                    <?php if ($modal_edit) : ?>
                                        <?php if (!$isHideFromEdit && $form["type"] != "hidden") : ?>
                                            <label for=" <?= $form["name"] ?>" class="mb-0 control-label"><?= $form["label"] ?> <?= $isRequired ? '<span class="text-danger">*</span>' : '' ?> </label>
                                    <?php if ($form["type"] === "file") : ?>
                                        <br>
                                    <?php endif ?>
                                <?php endif ?>
                            <?php else : ?>
                                <?php if (!$ishideFromCreate && $form["type"] != "hidden") : ?>
                                    <label for="<?= $form["name"] ?>" class="mb-0 control-label"><?= $form["label"] ?> <?= $isRequired ? '<span class="text-danger">*</span>' : '' ?> </label>
                                <?php endif ?>
                                <?php if ($form["type"] === "file") : ?>
                                    <br>
                                <?php endif ?>
                            <?php endif ?>

                            <?php if ($form["type"] == "textarea") : ?>
                                <?php if (($modal_edit && !$isHideFromEdit) || (!$modal_edit && !$ishideFromCreate)) : ?>
                                    <textarea <?= $isRequired ?> class="form-control" name="<?= $form["name"] ?>" id="<?= $idForm ?>" rows="<?= isset($form["rows"]) ? $form["rows"] : 3 ?>" <?= $readOnly ?>></textarea>
                                <?php endif ?>
                            <?php elseif ($form["type"] == "select") : ?>
                                <?php if (($modal_edit && !$isHideFromEdit) || (!$modal_edit && !$ishideFromCreate)) : ?>
                                    <?php if (!$form["options"]["chain"]) : ?>
                                        <select <?= $isRequired ?> class="form-control select2" id="<?= $idForm ?>" name="<?= $form["name"] ?>" style="width: 100%;" <?= $readOnly != "" ? "disabled" : "" ?>>
                                            <option value="">Pilih <?= strtolower($form["label"]) ?></option>
                                            <?php foreach ($form["options"]["data"] as $opt) : ?>
                                                <option value="<?= $opt["value"] ?>"><?= $opt["label"] ?></option>
                                            <?php endforeach ?>
                                        </select>

                                        <?php if (isset($form["options"]["path"]) && $form["options"]["serverSide"] === TRUE) : ?>
                                            <script>
                                                NEED_TO_SELECT.push({
                                                    id: "#<?= $idForm ?>",
                                                    path: "<?= $form["options"]["path"] ?>",
                                                    placeholder: "<?= "Silahkan pilih " . $form["label"] ?>"
                                                })
                                            </script>
                                        <?php endif ?>

                                    <?php else : ?>
                                        <?php
                                            $idFormTo   = $form["options"]["to"] . ($modal_edit ? "_edit" : "");
                                            $indexChain = array_search($form["options"]["to"], array_column($FIELD_FORM, "name"));
                                        ?>
                                        <select <?= $isRequired ?> class="form-control select2" id="<?= $idForm ?>" name="<?= $form["name"] ?>" style="width: 100%;" <?= $readOnly != "" ? "disabled" : "" ?>>
                                            <option value="">Pilih <?= strtolower($FIELD_FORM[$indexChain]["label"]) ?> terlebih dahulu</option>
                                        </select>
                                    <?php endif ?>
                                <?php endif ?>
                            <?php else : ?>
                                <?php if ($modal_edit) : ?>
                                    <?php if (!$isHideFromEdit) : ?>
                                        <input <?= $form["type"] == "password" ? "autocomplete='false'" : "autocomplete='true'" ?> <?= $form["type"] == "number" ? "step='any'" : "" ?> <?= ($form["type"] == "file" && isset($form["accept"])) ? "accept=" . generateAcceptFiles($form["accept"]) : "" ?> <?= $isRequired ?> <?= $readOnly ?> class="form-control<?= $form["type"] == "file" ? "-file" : "" ?>" onkeyup="<?= isset($form["numberOnly"]) && $form["numberOnly"] ? "validateNumberOnly(this)" : "" ?>" type="<?= $form["type"] ?>" name="<?= $form["name"] ?>" id="<?= $idForm ?>" value="<?= $form["type"] == "password" ? "" : (isset($form["value"]) ? $form["value"] : "") ?>">
                                        <?php if (isset($form["note_edit"]) && !empty($form["note_edit"])) : ?>
                                            <small class="text-danger"><?= $form["note_edit"] ?></small>
                                        <?php endif ?>
                                    <?php endif ?>
                                <?php else : ?>
                                    <?php if (!$ishideFromCreate) : ?>
                                        <input <?= $form["type"] == "number" ? "step='any'" : "" ?> <?= ($form["type"] == "file" && isset($form["accept"])) ? "accept=" . generateAcceptFiles($form["accept"]) : "" ?> <?= $isRequired ?> <?= $readOnly ?> class="form-control<?= $form["type"] == "file" ? "-file" : "" ?>" onkeyup="<?= isset($form["numberOnly"]) && $form["numberOnly"]  ? "validateNumberOnly(this)" : "" ?>" type="<?= $form["type"] ?>" name="<?= $form["name"] ?>" id="<?= $idForm ?>" value="<?= isset($form["value"]) ? $form["value"] : "" ?>">
                                        <?php if (isset($form["note_create"]) && !empty($form["note_create"])) : ?>
                                            <small class="text-info"><?= $form["note_create"] ?></small>
                                        <?php endif ?>
                                    <?php endif ?>
                                <?php endif ?>
                            <?php endif ?>

                            <?php if ($form["type"] == "file") : ?>
                                <?php $keteranganNoteFile = [];
                                    if (isset($form["maxSize"])) {
                                        $keteranganNoteFile[] = "Ukuran Maksimal : " . formatBytes($form["maxSize"]);
                                    }

                                    if (isset($form["accept"])) {
                                        $keteranganNoteFile[] = "File diterima : " . str_replace("|", ", ", $form["accept"]);
                                    }
                                ?>
                                <?php if (!empty($keteranganNoteFile)) : ?>
                                    <br>
                                    <small class="text-primary"><?= implode(", ", $keteranganNoteFile) ?></small>
                                <?php endif ?>
                            <?php endif ?>

                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-danger proses_btn_select">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(`#<?= $form_id ?>`).submit(e => {
        e.preventDefault()
        e.stopImmediatePropagation()

        var url = $(`#<?= $form_id ?>`).attr('action')
        var form = $(`#<?= $form_id ?>`)[0]
        var data = new FormData(form)

        $(".proses_btn_select").prop('disabled', true)
        $(".proses_btn_select").text("Sedang menyimpan data...")

        Swal.fire({
            title: 'Mohon Tunggu Beberapa Saat',
            text: 'Sedang menyimpan data...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: url,
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(result) {
                        $(".proses_btn_select").prop('disabled', false)
                        $(".proses_btn_select").text("Simpan")
                        if (result.code == 200) {
                            Swal.fire({
                                title: 'Sukses',
                                text: result.message,
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Tutup'
                            }).then((result) => {
                                $(`#<?= $form_id ?>`).trigger("reset");
                                $(`#modal_add_select`).modal("hide")
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
                        $(".proses_btn_select").prop('disabled', false)
                        $(".proses_btn_select").text("Simpan")
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