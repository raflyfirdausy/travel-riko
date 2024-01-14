<?php

class Kota_model extends RFL_Model
{
    public $table                   = 'm_kota';
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
                "type"              => "text",
                "name"              => "nama",
                "name_alias"        => "nama",
                "label"             => "Nama Kota",
                "numberOnly"        => FALSE,
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
