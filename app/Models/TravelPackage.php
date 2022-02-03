<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\TravelGallery;

class TravelPackage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'location',
        'description',
        'featured_events',
        'languages',
        'foods',
        'departure_date',
        'duration',
        'type',
        'price'
    ];

    protected $hidden = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function booted()
    {
        static::creating(function ($travel_package) {
            $travel_package->slug = Str::slug($travel_package->title);
        });

        static::updating(function ($travel_package) {
            $travel_package->slug = Str::slug($travel_package->title);
        });
    }

    public function travel_galleries(): HasMany
    {
        return $this->hasMany(TravelGallery::class);
    }
}
