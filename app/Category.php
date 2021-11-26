<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    public $timestamps = true;

    protected $fillable =['name'];

    protected $visible =['name'];

    public function product()
    {
    return $this->belongsToMany(Product::class);
    }
}
