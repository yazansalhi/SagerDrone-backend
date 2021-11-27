<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    protected $table = 'category_product';
    public $timestamps = false;

    protected $casts = [
        'category_id' => 'int',
		'product_id' => 'int',
	];

	protected $fillable = [
        'category_id',
		'product_id',
	];

	protected $visible = [
        'category_id',
		'product_id',
	];

	public function product()
	{
		return $this->belongsTo(Product::class,'product_id');
	}

	public function category()
	{
		return $this->belongsTo(Category::class, 'category_id');
	}
}
