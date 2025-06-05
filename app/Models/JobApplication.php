<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

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
        'user_id',
    ];

    protected $casts = [
        'tanggal_lamar' => 'date',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
