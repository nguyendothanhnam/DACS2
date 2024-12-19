<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'tbl_brand';
    protected $primaryKey = 'brand_id';
    public $timestamps = true;

    // Cột được phép thao tác
    protected $fillable = ['brand_name', 'brand_desc', 'brand_status','meta_keywords',];

    // Lấy tất cả thương hiệu
    public static function getAllBrands()
    {
        return self::all();
    }

    // Lấy thương hiệu theo ID
    public static function getBrandById($id)
    {
        return self::where('brand_id', $id)->first();
    }

    // Thêm thương hiệu mới
    public static function addBrand($data)
    {
        return self::create($data);
    }

    // Cập nhật thương hiệu
    public static function updateBrand($id, $data)
    {
        return self::where('brand_id', $id)->update($data);
    }

    // Xóa thương hiệu
    public static function deleteBrand($id)
    {
        return self::where('brand_id', $id)->delete();
    }
}
