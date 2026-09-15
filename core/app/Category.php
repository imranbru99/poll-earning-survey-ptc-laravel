<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function subCategory(){
    	return $this->hasMany(App\SubCategory::class, 'category_id', 'id');
    }

    public function forum(){
    	return $this->belongsTo(App\Forum::class);
    }

    public function topics(){
        return $this->hasManyThrough(App\Post::class, SubCategory::class);
    }


}
