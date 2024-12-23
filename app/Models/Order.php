<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'customer_id', 'shipping_id', 'order_status', 'order_code', 'created_at'
    ];

    protected $primaryKey ='order_id';
    protected $table ='tbl_order';

    public function shipping()
    {
        return $this->belongsTo(Shipping::class, 'shipping_id', 'shipping_id'); // Kiểm tra tên khóa ngoại và bảng có chính xác không
    }    
}
