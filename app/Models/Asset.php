<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builders\Relation;
use App\Models\PurchasedAsset;

class Asset extends Model
{
    use HasFactory;

    public $table = 'assets';
    public $asset_name;
    public $serial_number;
    public $cond;
    protected $fillable = [
        'asset_name',
        'serial_number',
        'cond',
    ];
    protected $casts = [
        'cond' => 'string',
    ];

    public function PurchasedAssets()
    {
        return $this->hasMany(PurchasedAsset::class);
    }
    public function purchaseqty()
    {
        return $this->PurchasedAssets()->sum('qty');
    }

    public function getPurchaseqtyAttribute()
    {
        return $this->purchaseqty();
    }
}
