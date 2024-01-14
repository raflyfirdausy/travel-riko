<?php

class Booking_model extends RFL_Model
{
    public $table                   = 'tr_booking';
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
                "name"              => "transfer_bukti",
                "label"             => "Bukti Transfer",
                "location"          => LOKASI_TRANSFER,
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
                "name"              => "nama_pemesan",
                "name_alias"        => "nama_pemesan",
                "label"             => "Nama Pemesan",
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
                "name"              => "no_hp",
                "name_alias"        => "no_hp",
                "label"             => "Telp",
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
                "name"              => "nama_kota_asal",
                "name_alias"        => "nama_kota_asal",
                "label"             => "Kota Asal",
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
                "name"              => "nama_kota_tujuan",
                "name_alias"        => "nama_kota_tujuan",
                "label"             => "Kota Tujuan",
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
                "name"              => "nama_kendaraan",
                "name_alias"        => "nama_kendaraan",
                "label"             => "Kendaraan",
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
                "col"               => 6,
                "type"              => "text",
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
                "col"               => 6,
                "type"              => "text",
                "name"              => "harga",
                "name_alias"        => "harga",
                "label"             => "Harga",
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
                "name"              => "tanggal_pemesanan",
                "name_alias"        => "tanggal_pemesanan",
                "label"             => "Tanggal Pemesanan",
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
                "name"              => "lokasi_penjemputan",
                "name_alias"        => "lokasi_penjemputan",
                "label"             => "Lokasi Penjemputan",
                "numberOnly"        => FALSE,
                "required"          => TRUE,
                "required_edit"     => TRUE,
                "hideFromTable"     => FALSE,
                "hideFromEdit"      => FALSE,
                "hideFromCreate"    => FALSE,
                "isUnique"          => FALSE
            ],
        ];
    }

    public function fieldFormSemua()
    {
        return [
            [
                "col"               => 12,
                "type"              => "file",
                "accept"            => "jpg|jpeg|png",
                "name"              => "transfer_bukti",
                "label"             => "Bukti Transfer",
                "location"          => LOKASI_TRANSFER,
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
                "name"              => "status",
                "name_alias"        => "status",
                "label"             => "Status Pemesanan",
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
                "name"              => "nama_pemesan",
                "name_alias"        => "nama_pemesan",
                "label"             => "Nama Pemesan",
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
                "name"              => "no_hp",
                "name_alias"        => "no_hp",
                "label"             => "Telp",
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
                "name"              => "nama_kota_asal",
                "name_alias"        => "nama_kota_asal",
                "label"             => "Kota Asal",
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
                "name"              => "nama_kota_tujuan",
                "name_alias"        => "nama_kota_tujuan",
                "label"             => "Kota Tujuan",
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
                "name"              => "nama_kendaraan",
                "name_alias"        => "nama_kendaraan",
                "label"             => "Kendaraan",
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
                "col"               => 6,
                "type"              => "text",
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
                "col"               => 6,
                "type"              => "text",
                "name"              => "harga",
                "name_alias"        => "harga",
                "label"             => "Harga",
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
                "name"              => "tanggal_pemesanan",
                "name_alias"        => "tanggal_pemesanan",
                "label"             => "Tanggal Pemesanan",
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
                "name"              => "lokasi_penjemputan",
                "name_alias"        => "lokasi_penjemputan",
                "label"             => "Lokasi Penjemputan",
                "numberOnly"        => FALSE,
                "required"          => TRUE,
                "required_edit"     => TRUE,
                "hideFromTable"     => FALSE,
                "hideFromEdit"      => FALSE,
                "hideFromCreate"    => FALSE,
                "isUnique"          => FALSE
            ],
        ];
    }
}
