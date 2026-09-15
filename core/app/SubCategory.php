<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{

    public function category(){
    	return $this->belongsTo(Category::class);
    }

    public function post(){
    	return $this->hasMany(Post::class, 'sub_category_id', 'id')->where('status', 1)->orderBy('id', 'ASC');
    }

}
