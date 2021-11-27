<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    
    public $timestamps = true;

    protected $fillable =['name','description','quantity','price','image','create_user_id'];

    protected $visible =['id','name','description','quantity','price','image','create_user_id'];

    public function categories()
    {
    return $this->belongsToMany(Category::class);
    }
    
}
