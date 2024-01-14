<div class="modal fade" id="<?= $modal_id ?>" role="dialog" aria-labelledby="<?= $modal_id ?>_label">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-<?= $modal_edit ? "primary" : "success" ?>">
                <h4 class="modal-title text-white"><?= $modal_title . " " . $title ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="<?= $modal_form_id ?>" enctype='multipart/form-data'>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <?php
                            foreach ($FIELD_FORM as $form) : ?>

                                <?php
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

                                ?>

                                <div class="mt-1 col-md-<?= (($form["type"] == "hidden") ? 12 : (isset($form["col"]) && is_numeric($form["col"]) ? $form["col"] : 12)) ?>" <?= $colId; ?> <?= $colStyle; ?>>

                                    <?php if ($modal_edit) : ?>
                                        <?php if (!$isHideFromEdit && $form["type"] != "hidden") : ?>
                                            <label for="<?= $form["name"] ?>" class="mb-0 control-label"><?= $form["label"] ?> <?= $isRequired ? '<span class="text-danger">*</span>' : '' ?> </label>
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
                                            <?php else : ?>
                                                <?php
                                                $idFormTo = $form["options"]["to"] . ($modal_edit ? "_edit" : "");
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
                                            <?php endif ?>
                                        <?php else : ?>
                                            <?php if (!$ishideFromCreate) : ?>
                                                <input <?= $form["type"] == "number" ? "step='any'" : "" ?> <?= ($form["type"] == "file" && isset($form["accept"])) ? "accept=" . generateAcceptFiles($form["accept"]) : "" ?> <?= $isRequired ?> <?= $readOnly ?> class="form-control<?= $form["type"] == "file" ? "-file" : "" ?>" onkeyup="<?= isset($form["numberOnly"]) && $form["numberOnly"]  ? "validateNumberOnly(this)" : "" ?>" type="<?= $form["type"] ?>" name="<?= $form["name"] ?>" id="<?= $idForm ?>" value="<?= isset($form["value"]) ? $form["value"] : "" ?>">
                                            <?php endif ?>
                                        <?php endif ?>
                                    <?php endif ?>

                                    <?php if ($modal_edit) : ?>
                                        <?php if (isset($form["note_edit"]) && !empty($form["note_edit"]) && !$form["hideFromEdit"]) : ?>
                                            <small class="text-danger"><?= $form["note_edit"] ?></small>
                                        <?php endif ?>
                                    <?php else : ?>
                                        <?php if (isset($form["note_create"]) && !empty($form["note_create"]) && !$form["hideFromCreate"]) : ?>
                                            <small class="text-info"><?= $form["note_create"] ?></small>
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
                    <?php if ($modal_edit) : ?>
                        <input type="hidden" name="id_data" id="id_data">
                    <?php endif ?>
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-<?= $modal_edit ? "primary" : "success" ?> proses_btn">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>