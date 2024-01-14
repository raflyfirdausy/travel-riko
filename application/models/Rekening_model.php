<?php

class Rekening_model extends RFL_Model
{
    public $table                   = 'm_rekening';
    public $primary_key             = 'uuid';
    public $return_as               = "array";
    public $uuid                    = TRUE;
    public $soft_deletes            = TRUE;
    public $timestamps              = TRUE;

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
                "label"             => "Icon",
                "location"          => LOKASI_REKENING,
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
                "name"              => "bank",
                "name_alias"        => "bank",
                "label"             => "Nama Bank",
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
                "name"              => "no_rek",
                "name_alias"        => "no_rek",
                "label"             => "Nomor Rekening",
                "numberOnly"        => TRUE,
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
                "name"              => "nama",
                "name_alias"        => "nama",
                "label"             => "Nama Pemilik",
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
                "type"              => "select",
                "name"              => "active",
                "label"             => "Aktif ?",
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
                            "label" => "YA",
                            "value" => "YA",
                        ],
                        [
                            "label" => "TIDAK",
                            "value" => "TIDAK",
                        ]
                    ],
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
