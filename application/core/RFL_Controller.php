<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RFL_Controller extends APP_Controller
{
    public $module;
    public $model;
    public $modelView;
    public $fieldForm;
    public $RFL_data;
    public $pathUrl;
    public $kolomLabelSelect2           = NULL;
    public $enableAddButton             = TRUE;
    public $enableExportImportButton    = TRUE;
    public $kondisiGetData              = [];
    public $additionalDataCreate        = [];
    public $additionalDataUpdate        = [];

    public $userData;
    public $_session;


    public function __construct()
    {
        parent::__construct();

        $directory              = $this->router->directory;
        $class                  = $this->router->class;
        $this->pathUrl          = $directory . $class;

        $this->_session         = $this->session->userdata(SESSION);        
    }

    protected function loadRFLView($view = NULL, $local_data = array(), $asData = FALSE)
    {
        $this->RFL_data    = [
            "RFL_MODAL"                     => "template/RFL_modal",
            "RFL_MODAL_IFRAME"              => "template/RFL_modal_iframe",
            "RFL_TABLE"                     => "template/RFL_table",
            "RFL_MASTER"                    => "template/RFL_master",


            "URL_GET_DATA"                  => base_url() . $this->pathUrl . "/get-data/",         //! WAJIB ADA
            "URL_CREATE_DATA"               => base_url() . $this->pathUrl . "/create/",           //! WAJIB ADA
            "URL_UPDATE_DATA"               => base_url() . $this->pathUrl . "/update/",           //! WAJIB ADA
            "URL_DELETE_DATA"               => base_url() . $this->pathUrl . "/delete/",           //! WAJIB ADA                
            "URL_DETAIL_DATA"               => base_url() . $this->pathUrl . "/get/",              //! WAJIB ADA 
            "URL_GET_MODAL"                 => base_url() . $this->pathUrl . "/get-modal/",        //! WAJIB ADA

            "URL_FORMAT_IMPORT"             => base_url() . $this->pathUrl . "/format-import/",    //! WAJIB ADA
            "URL_IMPORT_DATA"               => base_url() . $this->pathUrl . "/proses-import/",    //! WAJIB ADA
            "URL_EXPORT_DATA"               => base_url() . $this->pathUrl . "/proses-export/",    //! WAJIB ADA

            "ENABLE_ADD_BUTTON"             => $this->enableAddButton,
            "ENABLE_EXPORT_IMPORT_BUTTON"   => $this->enableExportImportButton
        ];

        $data = array_merge($this->RFL_data, $local_data);
        $this->loadViewBack($view, $data, $asData);
    }

    public function index()
    {
        $data       = [
            "FIELD_FORM"    => $this->fieldForm,
            "title"         => $this->module
        ];

        $this->loadRFLView("template/RFL_master", $data);
    }

    public function get_data($fieldForm = NULL, $modelView = NULL, $kondisiGetData = NULL)
    {
        header('Content-Type: application/json');

        if ($modelView != null)         $this->modelView        = $modelView;
        if ($kondisiGetData != null)    $this->kondisiGetData   = $kondisiGetData;
        if ($fieldForm != null)         $this->fieldForm        = $fieldForm;

        $limit              = $this->input->post("length")  ?: 10;
        $offset             = $this->input->post("start")   ?: 0;

        $data               = $this->_filterDataTable($this->modelView, $this->fieldForm)->where($this->kondisiGetData)->order_by("created_at", "DESC")->as_array()->limit($limit, $offset)->get_all() ?: [];
        // $query              = $this->db->last_query();
        $dataFilter         = $this->_filterDataTable($this->modelView, $this->fieldForm)->where($this->kondisiGetData)->order_by("created_at", "DESC")->count_rows() ?: 0;
        $dataCountAll       = $this->modelView->where($this->kondisiGetData)->count_rows() ?: 0;

        echo json_encode([
            "draw"              => $this->input->post("draw", TRUE),
            "data"              => $data,
            "recordsFiltered"   => $dataFilter,
            "recordsTotal"      => $dataCountAll,
            // "query"             => $query
        ]);
    }

    public function get_select()
    {
        if (empty($this->model->label_select2_field)) {
            if (isset($this->model->fieldForm()[0]["name"])) {
                $this->model->label_select2_field = $this->model->fieldForm()[0]["name"];
            } else {
                echo json_encode([
                    "code"      => 404,
                    "message"   => "Kolom label select 2 belum diatur pada model $this->module",
                    "data"      => []
                ]);
                die;
            }
        }

        $label                  = $this->model->label_select2_field;
        $page                   = $this->input->get("page")                 ?: "1";
        $perPage                = $this->input->get("perpage")              ?: "50";
        $search                 = $this->input->get("search");

        $fields                 = [
            $this->model->primary_key . " AS id",
            $label . " AS text"
        ];

        $kondisi                = [];
        if (!empty($search)) $kondisi["LOWER($label) LIKE"] = "%" . strtolower($search) . "%";

        $orderBy                = ["$label" => "ASC"];

        $data = $this->model->slice($fields, $kondisi, $page, $perPage, $orderBy);

        echo json_encode([
            "code"      => 200,
            "field"     => $this->model->label_select2_field,
            "data"      => $data
        ]);
    }

    protected function _filterDataTable($model, $fieldForm = NULL)
    {
        if ($fieldForm != null)             $this->fieldForm                = $fieldForm;

        $inputKolom     = $this->input->post("columns");
        $index          = 2; //! 0 = Nomer | 1 = Aksi
        foreach ($this->fieldForm as $form) {
            $isHideFromTable = isset($form["hideFromTable"]) ? $form["hideFromTable"] : FALSE;
            if (!$isHideFromTable) {
                if (isset($inputKolom) && !empty($inputKolom[$index]["search"]["value"])) {
                    if (!isset($form["name_alias"])) {
                        $name = $form["name"];
                        $model = $model->where("LOWER($name)", "LIKE", strtolower($inputKolom[$index]["search"]["value"]));
                    } else {
                        $name = $form["name_alias"];
                        $model = $model->where("LOWER($name)", "LIKE", strtolower($inputKolom[$index]["search"]["value"]));
                    }
                }
                $index++;
            }
        }

        if (isset($inputKolom) && !empty($inputKolom[$index]["search"]["value"])) {
            $name = "created_at";
            $model = $model->where("LOWER($name)", "LIKE", strtolower($inputKolom[$index]["search"]["value"]));
        }

        return $model;
    }

    public function create($fieldForm = NULL, $module = NULL, $model = NULL, $additionalDataCreate = NULL)
    {
        header('Content-Type: application/json');

        if ($fieldForm != null)             $this->fieldForm                = $fieldForm;
        if ($module != null)                $this->module                   = $module;
        if ($model != null)                 $this->model                    = $model;
        if ($additionalDataCreate != null)  $this->additionalDataCreate     = $additionalDataCreate;

        $config     = $this->_getConfigValidation("CREATE");
        if (!empty($config)) $this->runValidation($config);

        foreach ($this->fieldForm as $form) {
            //TODO : CHECK IF EXIST INPUT TYPE FILE
            if ($form["type"] === "file") {
                if (!isset($form["accept"])) {
                    echo json_encode([
                        "code"      => 503,
                        "message"   => "Terjadi kesalahan saat menambahkan data $this->module. Keterangan : filetype " . $form["label"] . " belum diatur. Silahkan diatur terlebih dahulu"
                    ]);
                    die;
                }

                if (!isset($form["location"])) {
                    echo json_encode([
                        "code"      => 503,
                        "message"   => "Terjadi kesalahan saat menambahkan data $this->module. Keterangan : lokasi upload " . $form["label"] . " belum diatur. Silahkan diatur terlebih dahulu"
                    ]);
                    die;
                }

                if (!isset($form["maxSize"])) {
                    echo json_encode([
                        "code"      => 503,
                        "message"   => "Terjadi kesalahan saat menambahkan data $this->module. Keterangan : batas maksimum ukuran file " . $form["label"] . " belum diatur. Silahkan diatur terlebih dahulu"
                    ]);
                    die;
                }
            }
        }

        $whereIsUnique  = [];
        $data           = [];
        $filesUploaded  = [];
        foreach ($this->fieldForm as $form) {

            $isHideFromCreate   = isset($form["hideFromCreate"])    ? $form["hideFromCreate"]       : FALSE;
            $isHideFromInsert   = isset($form["hideFromInsert"])    ? $form["hideFromInsert"]       : FALSE;
            $isReadOnlyInsert   = isset($field["readOnlyInsert"])   ? $field["readOnlyInsert"]      : FALSE;
            $isSaveAsHash       = isset($form["saveAsHash"])        ? $form["saveAsHash"]           : FALSE;
            $required           = isset($form["required"])          ? $form["required"]             : FALSE;
            $value              = $this->input->post($form["name"], TRUE);
            if ((!$isHideFromCreate && !$isReadOnlyInsert && !$isHideFromInsert) && $form["type"] !== "file") {
                $data[$form["name"]] = $isSaveAsHash ? password_hash($value, PASSWORD_DEFAULT) : $value;
            }

            // $isHideFromCreate = isset($form["hideFromCreate"])  ? $form["hideFromCreate"]   : FALSE;
            // $isSaveAsHash     = isset($form["saveAsHash"])      ? $form["saveAsHash"]       : FALSE;
            // if (!$isHideFromCreate && $form["type"] !== "file") {
            //     $value               = $this->input->post($form["name"], TRUE);
            //     $data[$form["name"]] = $isSaveAsHash ? password_hash($value, PASSWORD_DEFAULT) : $value;
            // }

            //! PREPARE FOR CHECK WHERE IS UNIQUE
            if (isset($form["isUnique"]) && $form["isUnique"]) {
                $fieldUnique                    = $form["name"];
                $whereIsUnique[]                = [
                    "label"                     => $form["label"],
                    "query"                     => [
                        "LOWER($fieldUnique)"   => strtolower(trim($this->input->post($fieldUnique)))
                    ]
                ];
            }

            //! UPLOAD FILE IF EXISTS        
            if (!empty($_FILES[$form["name"]]["name"])) {
                $configUpload   = [
                    "upload_path"       => $form["location"],
                    "allowed_types"     => $form["accept"],
                    "max_size"          => $form["maxSize"],
                    "encrypt_name"      => TRUE,
                    "remove_space"      => TRUE,
                    "overwrite"         => TRUE,
                ];

                if (!file_exists($configUpload['upload_path'])) {
                    mkdir($configUpload['upload_path'], 0777, TRUE);
                }

                $this->upload->initialize($configUpload);
                $upload                 = $this->upload->do_upload($form["name"]);
                if (!$upload) {
                    echo json_encode([
                        "code"          => 503,
                        "message"       => "Terjadi kesalahan saat mengupload file. Keterangan : " . $this->upload->display_errors("", ""),
                        "data"          => NULL
                    ]);
                    die;
                }

                $dataUpload             = $this->upload->data();
                $data[$form["name"]]    = $dataUpload["file_name"];
                $filesUploaded[]        = $form["location"] . $dataUpload["file_name"];
            }
        }

        if (!empty($whereIsUnique)) {
            foreach ($whereIsUnique as $wiu) {
                $cek    = $this->model->where($wiu["query"])->get();
                if ($cek) {

                    foreach ($filesUploaded as $fu) {
                        if (is_file($fu)) unlink($fu);
                    }

                    echo json_encode([
                        "code"      => 503,
                        "message"   => "Terjadi kesalahan saat menambahkan data $this->module. Keterangan : " . $wiu["label"] . " sudah ada, silahkan gunakan yang lain"
                    ]);
                    die;
                }
            }
        }

        $dataInsert = array_merge($data, $this->additionalDataCreate);
        $insert     = $this->model->insert($dataInsert);
        if (!$insert) {

            foreach ($filesUploaded as $fu) {
                if (is_file($fu)) unlink($fu);
            }

            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat menambahkan data $this->module"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Berhasil menambahkan data " . ucwords($this->module)
        ]);
    }

    public function update($fieldForm = NULL, $module = NULL, $model = NULL, $additionalDataUpdate = NULL)
    {
        header('Content-Type: application/json');

        if ($fieldForm != null)             $this->fieldForm                = $fieldForm;
        if ($module != null)                $this->module                   = $module;
        if ($model != null)                 $this->model                    = $model;
        if ($additionalDataUpdate != null)  $this->additionalDataUpdate     = $additionalDataUpdate;

        $config     = $this->_getConfigValidation("UPDATE");
        if (!empty($config)) $this->runValidation($config);

        //! CHECK DATA
        $id_data    = $this->input->post("id_data");
        $cekData    = $this->model->where([$this->model->primary_key => $id_data])->get();
        if (!$cekData) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data $this->module tidak ditemukan"
            ]);
            die;
        }

        //! CHECK IF EXIST INPUT TYPE FILE
        $listTypeFile   = [];
        foreach ($this->fieldForm as $form) {
            if ($form["type"] === "file") {
                if (!isset($form["accept"])) {
                    echo json_encode([
                        "code"      => 503,
                        "message"   => "Terjadi kesalahan saat menambahkan data $this->module. Keterangan : filetype " . $form["label"] . " belum diatur. Silahkan diatur terlebih dahulu"
                    ]);
                    die;
                }

                if (!isset($form["location"])) {
                    echo json_encode([
                        "code"      => 503,
                        "message"   => "Terjadi kesalahan saat menambahkan data $this->module. Keterangan : lokasi upload " . $form["label"] . " belum diatur. Silahkan diatur terlebih dahulu"
                    ]);
                    die;
                }

                if (!isset($form["maxSize"])) {
                    echo json_encode([
                        "code"      => 503,
                        "message"   => "Terjadi kesalahan saat menambahkan data $this->module. Keterangan : batas maksimum ukuran file " . $form["label"] . " belum diatur. Silahkan diatur terlebih dahulu"
                    ]);
                    die;
                }

                $listTypeFile[] = ["location" => $form["location"], "name" => $form["name"]];
            }
        }

        $dataUpdate         = [];
        $whereIsUnique      = [];
        $filesUploaded      = [];
        $filesNameUploaded  = [];
        foreach ($this->fieldForm as $form) {
            $isHideFromEdit   = isset($form["hideFromEdit"])    ? $form["hideFromEdit"]     : FALSE;
            $isHideFromUpdate = isset($form["hideFromUpdate"])  ? $form["hideFromUpdate"]   : FALSE;
            $isReadOnlyEdit   = isset($field["readOnlyEdit"])   ? $field["readOnlyEdit"]    : FALSE;
            $isSaveAsHash     = isset($form["saveAsHash"])      ? $form["saveAsHash"]       : FALSE;
            $requiredEdit     = isset($form["required_edit"])   ? $form["required_edit"]    : FALSE;
            $value            = $this->input->post($form["name"], TRUE);
            if ((!$isHideFromEdit && !$isReadOnlyEdit && !$isHideFromUpdate || $requiredEdit) && $form["type"] !== "file") {
                if ($isSaveAsHash) {
                    if (!empty($value)) {
                        $dataUpdate[$form["name"]] = password_hash($value, PASSWORD_DEFAULT);
                    }
                } else {
                    $dataUpdate[$form["name"]] = $value;
                }
            }

            //! PREPARE FOR CHECK WHERE IS UNIQUE
            if (isset($form["isUnique"]) && $form["isUnique"]) {
                $fieldUnique                    = $form["name"];
                $whereIsUnique[]                = [
                    "label"                     => $form["label"],
                    "query"                     => [
                        "LOWER($fieldUnique)"   => strtolower(trim($this->input->post($fieldUnique)))
                    ]
                ];
            }

            //! UPLOAD FILE IF EXISTS        
            if (!empty($_FILES[$form["name"]]["name"])) {
                $configUpload   = [
                    "upload_path"       => $form["location"],
                    "allowed_types"     => $form["accept"],
                    "max_size"          => $form["maxSize"],
                    "encrypt_name"      => TRUE,
                    "remove_space"      => TRUE,
                    "overwrite"         => TRUE,
                ];

                if (!file_exists($configUpload['upload_path'])) {
                    mkdir($configUpload['upload_path'], 0777, TRUE);
                }

                $this->upload->initialize($configUpload);
                $upload                 = $this->upload->do_upload($form["name"]);
                if (!$upload) {
                    echo json_encode([
                        "code"          => 503,
                        "message"       => "Terjadi kesalahan saat mengupload file. Keterangan : " . $this->upload->display_errors("", ""),
                        "data"          => NULL
                    ]);
                    die;
                }

                $dataUpload                 = $this->upload->data();
                $dataUpdate[$form["name"]]  = $dataUpload["file_name"];
                $filesUploaded[]            = $form["location"] . $dataUpload["file_name"];
                $filesNameUploaded[]        = $form["name"];
            }
        }

        //! CHECK WHERE IS UNIQUE
        if (!empty($whereIsUnique)) {
            foreach ($whereIsUnique as $wiu) {
                $cek    = $this->model->where($wiu["query"])->where("uuid", "!=", $id_data)->get();
                if ($cek) {

                    foreach ($filesUploaded as $fu) {
                        if (is_file($fu)) unlink($fu);
                    }

                    echo json_encode([
                        "code"      => 503,
                        "message"   => "Terjadi kesalahan saat memperbaharui data $this->module. Keterangan : " . $wiu["label"] . " sudah ada, silahkan gunakan yang lain"
                    ]);
                    die;
                }
            }
        }

        //! PROSES UPDATE
        $dataUpdateFinal    = array_merge($dataUpdate, $this->additionalDataUpdate);
        $update             = $this->model->where([$this->model->primary_key => $cekData[$this->model->primary_key]])->update($dataUpdateFinal);
        if (!$update) {

            foreach ($filesUploaded as $fu) {
                if (is_file($fu)) unlink($fu);
            }

            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat mengedit " . ucwords($this->module)
            ]);
            die;
        }

        //! DELETE PREVIOUS FILE 
        foreach ($listTypeFile as $ltf) {
            if (
                isset($cekData[$ltf["name"]])                   &&
                !empty($cekData[$ltf["name"]])                  &&
                in_array($ltf["name"], $filesNameUploaded)
            ) {
                $pathCheckFile = $ltf["location"] . $cekData[$ltf["name"]];
                if (is_file($pathCheckFile)) unlink($pathCheckFile);
            }
        }

        echo json_encode([
            "code"      => 200,
            "message"   =>  ucwords($this->module) . " berhasil di ubah !"
        ]);
    }

    public function delete($model = NULL, $module = NULL)
    {
        header('Content-Type: application/json');

        if ($model != null)                 $this->model                    = $model;
        if ($module != null)                $this->module                   = $module;

        $id_data    = $this->input->post("id_data");
        $delete     = $this->model->where([$this->model->primary_key => $id_data])->delete();
        if (!$delete) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat menghapus $this->module"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Data $this->module berhasil di hapus !",
            "query"     => $this->db->last_query()
        ]);
    }

    public function get($id = NULL, $modelView = NULL, $module = NULL)
    {
        header('Content-Type: application/json');

        if ($modelView != null)             $this->modelView                = $modelView;
        if ($module != null)                $this->module                   = $module;

        $data = $this->modelView->where([$this->modelView->primary_key => $id])->get();
        if (!$data) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data $this->module tidak ditemukan "
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Data $this->module ditemukan",
            "data"      => $data
        ]);
    }

    public function get_modal($fieldName = NULL)
    {
        header('Content-type: application/json');

        if (empty($fieldName)) {
            echo json_encode([
                "code"      => 200,
                "message"   => "Field Name tidak boleh kosong",
                "data"      => NULL
            ], JSON_UNESCAPED_SLASHES);
            die;
        }

        $fieldFormSelect    = NULL;
        $fieldFormName      = "";
        $fieldPath          = "";
        foreach ($this->fieldForm as $ff) {
            if ($ff["name"] == $fieldName) {
                if (isset($ff["options"]["fieldForm"]) && !empty($ff["options"]["fieldForm"])) {
                    $fieldFormName      = $ff["label"];
                    $fieldFormSelect    = $ff["options"]["fieldForm"];
                    $fieldPath          = $ff["options"]["path"];
                } else {
                    echo json_encode([
                        "code"      => 200,
                        "message"   => "Field Form pada $fieldName tidak boleh kosong",
                        "data"      => NULL
                    ], JSON_UNESCAPED_SLASHES);
                    die;
                }
                break;
            }
        }

        $data = [
            "FIELD_FORM_SELECT"         => $fieldFormSelect,
            "FIELD_ACTION"              => $fieldPath . "/create",
            "modal_title"               => "Tambah " . $fieldFormName,
            "form_id"                   => generator(50)
        ];

        echo json_encode([
            "code"      => 200,
            "message"   => "Berhasil load modal",
            "data"      => $this->load->view("template/RFL_modal_add_select", $data, TRUE)
        ], JSON_UNESCAPED_SLASHES);
    }

    public function _getConfigValidation($mode)
    {
        $fieldForm = $this->fieldForm;
        $config = [];
        foreach ($fieldForm as $field) {
            $isReadOnlyEdit = isset($field["readOnlyEdit"]) ? $field["readOnlyEdit"] : FALSE;
            if (
                (
                    ($mode == "CREATE" && !$field["hideFromCreate"]) ||
                    ($mode == "UPDATE" && !$field["hideFromEdit"] && !$isReadOnlyEdit)
                ) &&
                $field["type"] !== "file"
            ) {
                $optionsData = isset($field["options"]["data"]) ? $field["options"]["data"] : [];
                $rules = [];

                $isRequired         = ($mode == "UPDATE" && isset($field["required_edit"]))
                    ? ($field["required_edit"]  ? TRUE : FALSE)
                    : ($field["required"]       ? TRUE : FALSE);

                if ($isRequired) {
                    $rules[] = "required";
                }

                if (isset($field["insertValidation"])) {
                    $rules[] = $field["insertValidation"];
                }

                if ($field["type"] == "select" && is_array($optionsData)) {
                    $options = array_column($optionsData, "value");
                    $rules[] = "in_list[" . implode(",", $options) . "]";
                }

                if (!empty($rules)) {
                    $config[] = [
                        "field" => $field["name"],
                        "label" => $field["label"],
                        "rules" => implode("|", $rules),
                    ];
                }
            }
        }

        return $config;
    }

    public function format_import()
    {
        $title          = "Format Import " . $this->module;
        $subtitle       = "Keterangan : untuk kolom yang bertanda * WAJIB diisi";

        $fieldForm      = $this->fieldForm ?: [];
        $fieldCanImport = [];
        $typeExclude    = ["file"];

        foreach ($fieldForm as $ff) {
            if (isset($ff["type"]) && !in_array($ff["type"], $typeExclude)) {
                $fieldCanImport[] = [
                    "name"      => $ff["name"],
                    "label"     => $ff["label"],
                    "required"  => isset($ff["required"])           ? $ff["required"]           : FALSE,
                ];
            }
        }

        $spreadsheet    = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $worksheet      = $spreadsheet->getActiveSheet();

        $highestColumn  = getColumnFromNumber(sizeof($fieldCanImport));

        $titleStyle = [
            'font' => [
                'bold'  => true,
                'size'  => 14
            ],
            'alignment' => [
                'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText'      => TRUE
            ],
        ];

        $worksheet->mergeCells("A1:" . $highestColumn . "1");
        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($titleStyle);
        $worksheet->setCellValue('A1', $title);

        $worksheet->mergeCells("A3:" . $highestColumn . "3");
        $worksheet->setCellValue('A3', $subtitle);

        $headRow    = 4;

        for ($i = 0; $i < sizeof($fieldCanImport); $i++) {
            $currentColumn  = getColumnFromNumber($i + 1);
            $headTitle      = $fieldCanImport[$i]["label"] . ($fieldCanImport[$i]["required"] ? "*" : "");
            $worksheet->setCellValue(($currentColumn . $headRow), $headTitle);
            $worksheet->getColumnDimension($currentColumn)->setAutoSize(true);
        }

        $headStyle = [
            'font' => [
                'bold' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'wrapText'      => TRUE
            ]
        ];
        $spreadsheet->getActiveSheet()
            ->getStyle('A' . $headRow . ":" . $highestColumn . $headRow)
            ->applyFromArray($headStyle);


        $fileName   = slug("Format Import " . $this->module . " Downloaded at " . date("Y m d H i s") . " WIB");
        //TODO : WRITE AND DOWNLOAD
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function proses_import()
    {
        $fieldForm      = $this->fieldForm ?: [];
        $fieldCanImport = [];
        $typeExclude    = ["file"];

        foreach ($fieldForm as $ff) {
            if (isset($ff["type"]) && !in_array($ff["type"], $typeExclude)) {
                $currentFieldImport = [
                    "type"      => $ff["type"],
                    "name"      => $ff["name"],
                    "label"     => $ff["label"],
                    "required"  => isset($ff["required"])           ? $ff["required"]           : FALSE,
                    "model"     => isset($ff["options"]["model"])   ? $ff["options"]["model"]   : NULL
                ];

                $fieldCanImport[] = array_merge($ff, $currentFieldImport);
            }
        }

        //!TODO : CHECK IF CHAINING          
        foreach ($fieldCanImport as $fci) {
            $currentField   = $fci;
            if ($currentField["model"] !== NULL) {
                if (!isset($currentField["model"]["name"]) || !isset($currentField["model"]["field"])) {
                    echo json_encode([
                        "code"      => 503,
                        "message"   => "Terjadi kesalahan saat import data $this->module. Keterangan : konfigurasi model pada " . $currentField["label"] . " tidak sesuai format"
                    ]);
                    die;
                }
            }
        }

        $pathExcel      = NULL;
        $formNameFile   = "file_import";
        if (!empty($_FILES[$formNameFile]["name"])) {
            $configUpload   = [
                "upload_path"       => LOKASI_EXCEL_IMPORT,
                "allowed_types"     => "xlsx",
                "max_size"          => 50 * 1024,
                "encrypt_name"      => TRUE,
                "remove_space"      => TRUE,
                "overwrite"         => TRUE,
            ];

            $this->upload->initialize($configUpload);
            $upload                         = $this->upload->do_upload($formNameFile);
            if ($upload) {
                $dataUpload                 = $this->upload->data();
                $pathExcel                  = $dataUpload["full_path"];
            } else {
                echo json_encode([
                    "code"      => 503,
                    "message"   => "Terjadi kesalahan saat mengimport data $this->module. Keterangan : " . $this->upload->display_errors("", "")
                ]);
                die;
            }
        }

        if (!$pathExcel) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat import data $this->module. Keterangan : File Excel tidak valid"
            ]);
            die;
        }

        $inputFileType  = 'Xlsx';
        $inputFileName  = $pathExcel;
        $reader         = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $spreadsheet    = $reader->load($inputFileName);
        $worksheet      = $spreadsheet->getActiveSheet();
        $highestRow     = $worksheet->getHighestRow();
        $highestColumn  = $worksheet->getHighestColumn();
        $startRowInsert = 5;

        $dataArray      = $worksheet->rangeToArray(
            'A' . $startRowInsert . ':' . $highestColumn . $highestRow,     // The worksheet range that we want to retrieve
            NULL,        // Value that should be returned for empty cells
            TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
            TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
            FALSE         // Should the array be indexed by cell row and cell column
        );

        if (is_file($pathExcel)) unlink($pathExcel);

        if (sizeof($dataArray) < 1) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat mengimport data $this->module. Keterangan : data import tidak boleh kosong"
            ]);
            die;
        }

        if (sizeof($fieldCanImport) !== sizeof($dataArray[0])) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat import data $this->module. Keterangan : jumlah field dan jumlah kolom tidak match. field : " . sizeof($fieldCanImport) . " dan kolom : " . sizeof($dataArray[0])
            ]);
            die;
        }

        $dataInsert     = [];
        foreach ($dataArray as $da) {
            for ($i = 0; $i < sizeof($da); $i++) {
                $currentField                       = $fieldCanImport[$i];
                $currentValue                       = $da[$i];

                $currentRow[$currentField["name"]]  = $currentValue;

                if ($currentField["model"] !== NULL) {
                    $modelName  = $currentField["model"]["name"];
                    $fieldname  = $currentField["model"]["field"];
                    $this->load->model($modelName);
                    $cek = $this->{$modelName}->where(["LOWER($fieldname)" => strtolower($currentValue)])->get();
                    if (!$cek) {
                        $uuidInsert = $this->{$modelName}->insert([$fieldname => $currentValue]);
                        $currentRow[$currentField["name"]] = $uuidInsert;
                    } else {
                        $currentRow[$currentField["name"]] = $cek[$this->{$modelName}->primary_key];
                    }
                }
            }

            $currentRowMerge    = array_merge($currentRow, $this->additionalDataCreate);
            $dataInsert[]       = $currentRowMerge;
        }

        $insertImport = $this->model->insert($dataInsert);
        if (!$insertImport) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat import data $this->module karena gagal insert database"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Berhasil melakukan import data " . ucwords($this->module) . " Sebanyak " . sizeof($dataInsert) . " data"
        ]);
    }

    public function proses_export()
    {
        $title          = "Export Data " . $this->module;
        $subtitle       = "Diunduh pada : " . datetime_indo(date("Y-m-d H:i:s"), TRUE) . " WIB";

        $fieldForm      = $this->fieldForm ?: [];
        $fieldCanImport = [];
        $typeExclude    = ["file", "password"];
        $fieldSelect    = [];

        foreach ($fieldForm as $ff) {
            if (isset($ff["type"]) && !in_array($ff["type"], $typeExclude)) {
                $currentFieldImport = [
                    "type"      => $ff["type"],
                    "name"      => $ff["name"],
                    "label"     => $ff["label"],
                    "required"  => isset($ff["required"])           ? $ff["required"]           : FALSE,
                    "model"     => isset($ff["options"]["model"])   ? $ff["options"]["model"]   : NULL
                ];

                $fieldMerge         = array_merge($ff, $currentFieldImport);
                $fieldCanImport[]   = $fieldMerge;

                $fieldSelect[]      = isset($fieldMerge["name_alias"]) ? $fieldMerge["name_alias"] : $fieldMerge["name"];
            }
        }
        $fieldSelect[]              = "updated_at";

        $spreadsheet        = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $worksheet          = $spreadsheet->getActiveSheet();

        $widthColumnWithNo  = sizeof($fieldCanImport) + 2; //? ADD NO and Terakhir Diperbaharui
        $highestColumn      = getColumnFromNumber($widthColumnWithNo);

        $titleStyle = [
            'font' => [
                'bold'  => true,
                'size'  => 14
            ],
            'alignment' => [
                'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText'      => TRUE
            ],
        ];

        $subtitleStyle = [
            'alignment' => [
                'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText'      => TRUE
            ],
        ];

        $worksheet->mergeCells("A1:" . $highestColumn . "1");
        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($titleStyle);
        $worksheet->setCellValue('A1', $title);

        $worksheet->mergeCells("A2:" . $highestColumn . "2");
        $worksheet->setCellValue('A2', $subtitle);
        $spreadsheet->getActiveSheet()->getStyle('A2')->applyFromArray($subtitleStyle);

        $headRow        = 4;
        $startRowData   = $headRow + 1;

        $worksheet->setCellValue(("A" . $headRow), "No");
        $worksheet->getColumnDimension("A")->setAutoSize(true);

        for ($i = 0; $i < sizeof($fieldCanImport); $i++) {
            $currentColumn  = getColumnFromNumber($i + 2);
            $headTitle      = $fieldCanImport[$i]["label"];
            $worksheet->setCellValue(($currentColumn . $headRow), $headTitle);
            $worksheet->getColumnDimension($currentColumn)->setAutoSize(true);
        }
        $lastColumn     = getColumnFromNumber($widthColumnWithNo);
        $worksheet->setCellValue(($lastColumn . $headRow), "Terakhir Diperbaharui");
        $worksheet->getColumnDimension($lastColumn)->setAutoSize(true);

        $headStyle = [
            'font' => [
                'bold' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'wrapText'      => TRUE
            ]
        ];
        $spreadsheet->getActiveSheet()
            ->getStyle('A' . $headRow . ":" . $highestColumn . $headRow)
            ->applyFromArray($headStyle);

        //TODO : GET DATA
        $dataExport = $this->modelView
            ->fields($fieldSelect)
            ->where($this->kondisiGetData)
            ->order_by("created_at", "ASC")
            ->get_all();

        $baris      = $startRowData;
        $no         = 1;
        foreach ($dataExport as $de) {
            $worksheet->getCell('A' . $baris)->setValue($no++);
            for ($i = 1; $i < ($widthColumnWithNo - 1); $i++) {
                $worksheet->getCell(getColumnFromNumber($i + 1) . $baris)->setValue($de[$fieldSelect[$i - 1]]);
            }
            $worksheet->getCell($lastColumn . $baris)->setValue($de["updated_at"]);
            $baris++;
        }

        $styleBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText'      => TRUE
            ]
        ];


        $worksheet->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $highestRow     = $worksheet->getHighestRow();
        $highestColumn  = $worksheet->getHighestColumn();
        $worksheet->getStyle('A' . $startRowData . ':' . $highestColumn . $highestRow)->applyFromArray($styleBorder);



        $fileName   = slug("Export " . $this->module . " Downloaded at " . date("Y m d H i s") . " WIB");
        //TODO : WRITE AND DOWNLOAD
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

}
