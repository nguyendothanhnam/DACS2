<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\City;
use App\Models\Province;
use App\Models\Wards;

class Feeship extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'fee_matp',
        'fee_maqh',
        'fee_xaid',
        'fee_feeship'
    ];

    protected $primaryKey = 'fee_id';
    protected $table = 'tbl_feeship';

    public function city()
    {
        return $this->belongsTo(City::class, 'fee_matp', 'matp');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'fee_maqh', 'maqh');
    }

    public function wards()
    {
        return $this->belongsTo(Wards::class, 'fee_xaid', 'xaid');
    }

}
