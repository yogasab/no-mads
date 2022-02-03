<?php

namespace App\Models;

use App\Models\TravelPackage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TravelGallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function travel_package(): BelongsTo
    {
        return $this->belongsTo(TravelPackage::class, 'travel_packages_id', 'id');
    }
}
