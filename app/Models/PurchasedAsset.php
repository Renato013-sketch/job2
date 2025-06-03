<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Asset;

class PurchasedAsset extends Model
{
    use HasFactory;
    public $table = 'purchased_assets';
    protected $fillable = [
        'asset_id',
        'serial_number',
        'qty',
        'purchase_date',
    ];
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}
