<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'price',
        'image_url'
    ];

    public function scopeSearch($query, $filters)
    {
        if(isset($filters['title'])) {
            $query->whereLike('title', '%'. $filters['title'] . '%');
        }
        
        if(isset($filters['price'])) {
            $query->where('price', '<=', $filters['price']);
        }

        return $query;
    }
}
