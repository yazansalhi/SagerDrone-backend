<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    public $timestamps = true;

    protected $fillable =['name'];

    protected $visible =['name','products'];

    public function products()
    {
    return $this->belongsToMany(Product::class);
    }
}
