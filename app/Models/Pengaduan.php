<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $fillable = [
        'kategori',
        'upload_file',
        'nama_perusahaan',
        'lokasi',
        'judul',
        'deskripsi',
        'nama',
        'email',
        'no_hp',
    ];
}
