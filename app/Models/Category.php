<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Category extends Model
{
    use HasFactory;
    use Sluggable;
    // use SoftDeletes;

    protected $fillable = [
        'name',
        'image',
        'status',
    ];

    public function  subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function getIsActiveAttribute()
    {
        if ($this->status) {
                return '<div class="badge badge-light-success" style="font-size:1.15rem">'.trans("general.active").'</div>';
        } else {
                return '<div class="badge badge-light-primary" style="font-size:1.15rem">'.trans("general.inactive").'</div>';
        }
    }

    public function sluggable(): array
    {
        return [
            'slug' =>
            [
                'source' => 'name'
            ]
        ];
    }
}
