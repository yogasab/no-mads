<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
