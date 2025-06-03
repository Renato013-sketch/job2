<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobApplication extends Model
{
    use HasFactory;
    public $table = 'job_applications';
    protected $fillable = [
        'tanggal_lamar',
        'nama_perusahaan',
        'alamat_perusahaan',
        'posisi',
        'range_gaji',
        'status',
    ];

    protected $casts = [
        'tanggal_lamar' => 'date',
    ];
}
