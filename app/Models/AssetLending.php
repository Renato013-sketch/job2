<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Asset;

class AssetLending extends Model
{
    use HasFactory;
    protected $fillable = [
        'date_lending',
        'name',
        'asset_id',
        'qty',
        'note',
    ];
    public $table = 'asset_lendings';
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}
