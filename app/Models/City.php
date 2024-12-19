<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'name_city', 'type'
    ];

    protected $primaryKey ='matp';
    protected $table ='tbl_tinhthanhpho';
}
