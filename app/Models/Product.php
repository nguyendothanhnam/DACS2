<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    // Tên bảng liên kết với model
    protected $table = 'tbl_product';

    // Khóa chính
    protected $primaryKey = 'product_id';

    // Các cột được phép gán tự động (mass assignment)
    protected $fillable = [
        'product_name',
        'product_price',
        'product_desc',
        'product_content',
        'category_id',
        'brand_id',
        'product_status',
        'product_image',
    ];

    public $timestamps = true;

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
