<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'category_id',
        'name',
        'image',
        'status',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }


    public function  books()
    {
        return $this->hasMany(Book::class);
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
