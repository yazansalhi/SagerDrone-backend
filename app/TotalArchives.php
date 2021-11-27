<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TotalArchives extends Model
{
    protected $table = 'total_archives';
    
    public $timestamps = true;

    protected $fillable =['products','categories','users'];

    protected $visible =['products','categories','users'];

  
}
