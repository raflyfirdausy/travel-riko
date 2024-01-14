<?php

class Jadwal_model extends RFL_Model
{
    public $table                   = 'm_jadwal';
    public $primary_key             = 'uuid';
    public $return_as               = "array";
    public $uuid                    = TRUE;
    public $soft_deletes            = TRUE;
    public $timestamps              = TRUE;

    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            "Armada_model"  => "kendaraan",
            "Kota_model"    => "kota"
        ]);
    }

    public function fieldForm()
    {

        $kota         = $this->kota->generateSelect();
        $kendaraan    = $this->kendaraan->generateSelect();

        return [
            [
                "col"               => 12,
                "type"              => "file",
                "accept"            => "jpg|jpeg|png",
                "name"              => "image_kendaraan",
                "label"             => "Gambar Kendaraan",
                "location"          => LOKASI_ARMADA,
                "maxSize"           => 5 * 1024,
                "iframe"            => TRUE,
                "isImage"           => TRUE,
                "required"          => TRUE,
                "required_edit"     => FALSE,
                "hideFromTable"     => FALSE,
                "hideFromEdit"      => TRUE,
                "hideFromCreate"    => TRUE,
            ],
            [
                "col"               => 6,
                "type"              => "select",
                "name"              => "uuid_kota_asal",
                "name_alias"        => "nama_kota_asal",
                "label"             => "Kota Asal",
                "numberOnly"        => FALSE,
                "required"          => TRUE,
                "hideFromTable"     => FALSE,
                "hideFromEdit"      => FALSE,
                "hideFromCreate"    => FALSE,
                "options"       => [
                    "chain"         => FALSE,
                    "to"            => NULL,
                    "data"          => $kota,
                    "serverSide"    => FALSE,
                    "addButton"     => FALSE,
                    "path"          => base_url("master/kota"),
                    "fieldForm"     => $this->kota->fieldForm(),
                    "model"         => [
                        "name"      => "Kota_model",
                        "field"     => "nama"
                    ]
                ],
            ],
            [
                "col"               => 6,
                "type"              => "select",
                "name"              => "uuid_kota_tujuan",
                "name_alias"        => "nama_kota_tujuan",
                "label"             => "Kota Tujuan",
                "numberOnly"        => FALSE,
                "required"          => TRUE,
                "hideFromTable"     => FALSE,
                "hideFromEdit"      => FALSE,
                "hideFromCreate"    => FALSE,
                "options"       => [
                    "chain"         => FALSE,
                    "to"            => NULL,
                    "data"          => $kota,
                    "serverSide"    => FALSE,
                    "addButton"     => FALSE,
                    "path"          => base_url("master/kota"),
                    "fieldForm"     => $this->kota->fieldForm(),
                    "model"         => [
                        "name"      => "Kota_model",
                        "field"     => "nama"
                    ]
                ],
            ],
            [
                "col"               => 4,
                "type"              => "select",
                "name"              => "uuid_kendaraan",
                "name_alias"        => "nama_kendaraan",
                "label"             => "Nama Kendaraan",
                "numberOnly"        => FALSE,
                "required"          => TRUE,
                "hideFromTable"     => FALSE,
                "hideFromEdit"      => FALSE,
                "hideFromCreate"    => FALSE,
                "options"       => [
                    "chain"         => FALSE,
                    "to"            => NULL,
                    "data"          => $kendaraan,
                    "serverSide"    => FALSE,
                    "addButton"     => FALSE,
                    "path"          => base_url("/master/kendaraan"),
                    "fieldForm"     => $this->kendaraan->fieldForm(),
                    "model"         => [
                        "name"      => "Kendaraan_model",
                        "field"     => "nama"
                    ]
                ],
            ],
            [
                "col"               => 4,
                "type"              => "select",
                "name"              => "no_hari",
                "name_alias"        => "nama_hari",
                "label"             => "Hari",
                "numberOnly"        => FALSE,
                "required"          => TRUE,
                "hideFromTable"     => FALSE,
                "hideFromEdit"      => FALSE,
                "hideFromCreate"    => FALSE,
                "options"       => [
                    "chain"         => FALSE,
                    "to"            => NULL,
                    "data"          =>  [
                        [
                            "value" => 1,
                            "label" => "SENIN"
                        ],
                        [
                            "value" => 2,
                            "label" => "SELASA"
                        ],
                        [
                            "value" => 3,
                            "label" => "RABU"
                        ],
                        [
                            "value" => 4,
                            "label" => "KAMIS"
                        ],
                        [
                            "value" => 5,
                            "label" => "JUMAT"
                        ],
                        [
                            "value" => 6,
                            "label" => "SABTU"
                        ],
                        [
                            "value" => 7,
                            "label" => "MINGGU"
                        ],
                    ],
                    "serverSide"    => FALSE,
                    "addButton"     => FALSE,
                ],
            ],
            [
                "col"               => 4,
                "type"              => "text",
                "name"              => "harga",
                "name_alias"        => "harga",
                "label"             => "Harga",
                "numberOnly"        => TRUE,
                "required"          => TRUE,
                "required_edit"     => TRUE,
                "hideFromTable"     => FALSE,
                "hideFromEdit"      => FALSE,
                "hideFromCreate"    => FALSE,
            ],
            [
                "col"               => 4,
                "type"              => "time",
                "name"              => "waktu_berangkat",
                "name_alias"        => "waktu_berangkat",
                "label"             => "Waktu Berangkat",
                "numberOnly"        => FALSE,
                "required"          => TRUE,
                "required_edit"     => TRUE,
                "hideFromTable"     => FALSE,
                "hideFromEdit"      => FALSE,
                "hideFromCreate"    => FALSE,
                "isUnique"          => FALSE
            ],
            [
                "col"               => 4,
                "type"              => "time",
                "name"              => "waktu_sampai",
                "name_alias"        => "waktu_sampai",
                "label"             => "Waktu Sampai",
                "numberOnly"        => FALSE,
                "required"          => TRUE,
                "required_edit"     => TRUE,
                "hideFromTable"     => FALSE,
                "hideFromEdit"      => FALSE,
                "hideFromCreate"    => FALSE,
                "isUnique"          => FALSE
            ],
            [
                "col"               => 4,
                "type"              => "select",
                "name"              => "aktif",
                "name_alias"        => "aktif",
                "label"             => "Aktif",
                "numberOnly"        => FALSE,
                "required"          => TRUE,
                "hideFromTable"     => FALSE,
                "hideFromEdit"      => FALSE,
                "hideFromCreate"    => FALSE,
                "options"       => [
                    "chain"         => FALSE,
                    "to"            => NULL,
                    "data"          => [
                        [
                            "value" => "YA",
                            "label" => "YA"
                        ],
                        [
                            "value" => "TIDAK",
                            "label" => "TIDAK",
                        ]
                    ],
                    "serverSide"    => FALSE,
                    "addButton"     => FALSE,
                ],
            ],
            [
                "col"               => 12,
                "type"              => "textarea",
                "name"              => "keterangan",
                "name_alias"        => "keterangan",
                "label"             => "Keterangan",
                "numberOnly"        => FALSE,
                "required"          => FALSE,
                "required_edit"     => FALSE,
                "hideFromTable"     => FALSE,
                "hideFromEdit"      => FALSE,
                "hideFromCreate"    => FALSE,
            ],
        ];
    }
}
