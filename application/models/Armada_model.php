<?php

class Armada_model extends RFL_Model
{
    public $table                   = 'm_armada';
    public $primary_key             = 'uuid';
    public $return_as               = "array";
    public $uuid                    = TRUE;
    public $soft_deletes            = TRUE;
    public $timestamps              = TRUE;
    public $label_select2_field     = "nama";

    public function __construct()
    {
        parent::__construct();
    }

    public function fieldForm()
    {
        return [
            [
                "col"               => 12,
                "type"              => "file",
                "accept"            => "jpg|jpeg|png",
                "name"              => "image",
                "name_alias"        => "image",
                "label"             => "Gambar Kendaraan",
                "location"          => LOKASI_ARMADA,
                "maxSize"           => 5 * 1024,
                "iframe"            => TRUE,
                "isImage"           => TRUE,
                "required"          => TRUE,
                "required_edit"     => FALSE,
                "hideFromTable"     => FALSE,
                "hideFromEdit"      => FALSE,
                "hideFromCreate"    => FALSE,
            ],
            [
                "col"               => 6,
                "type"              => "text",
                "name"              => "nama",
                "name_alias"        => "nama",
                "label"             => "Nama Kendaraan",
                "numberOnly"        => FALSE,
                "required"          => TRUE,
                "required_edit"     => TRUE,
                "hideFromTable"     => FALSE,
                "hideFromEdit"      => FALSE,
                "hideFromCreate"    => FALSE,
                "isUnique"          => FALSE
            ],
            [
                "col"               => 6,
                "type"              => "text",
                "name"              => "nopol",
                "name_alias"        => "nopol",
                "label"             => "Nomor Kendaraan",
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
                "name"              => "bbm",
                "label"             => "Jenis BBM",
                "numberOnly"        => FALSE,
                "required"          => TRUE,
                "hideFromTable"     => FALSE,
                "hideFromEdit"      => FALSE,
                "hideFromCreate"    => FALSE,
                "options"       => [
                    "chain"         => FALSE,
                    "to"            => NULL,
                    "serverSide"    => FALSE,
                    "data"          => [
                        [
                            "label" => "BENSIN",
                            "value" => "BENSIN",
                        ],
                        [
                            "label" => "SOLAR",
                            "value" => "SOLAR",
                        ],
                        [
                            "label" => "BATTERY",
                            "value" => "BATTERY",
                        ]
                    ],
                ],
            ],
            [
                "col"               => 4,
                "type"              => "text",
                "name"              => "warna",
                "name_alias"        => "warna",
                "label"             => "Warna",
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
                "type"              => "text",
                "name"              => "kapasitas",
                "name_alias"        => "kapasitas",
                "label"             => "Kapasitas (Orang)",
                "numberOnly"        => TRUE,
                "required"          => TRUE,
                "required_edit"     => TRUE,
                "hideFromTable"     => FALSE,
                "hideFromEdit"      => FALSE,
                "hideFromCreate"    => FALSE,
                "isUnique"          => FALSE
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
