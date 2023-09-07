<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Cviebrock\EloquentSluggable\Sluggable;


class Category extends Model
{
    use HasFactory;
    // use Sluggable;
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
            // return "Active";
            return '<div class="badge badge-light-success" style="font-size:1.15rem">Active</div>';
        } else {
            // return "Inactive";
            return '<div class="badge badge-light-primary" style="font-size:1.15rem">Inactive</div>';
        }
    }
}
