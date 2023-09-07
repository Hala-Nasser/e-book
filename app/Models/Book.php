<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Book extends Model
{
    use HasFactory;
    use Sluggable;
    // use SoftDeletes;

    protected $fillable=[
        'name',
        'author_name',
        'sub_category_id',
        'publish_date',
        'description',
        'price',
        'image',
    ];

    public function subCategory(){
        return $this->belongsTo(SubCategory::class);
    }

    public function media(){
        return $this->hasMany(MediaBook::class);
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
