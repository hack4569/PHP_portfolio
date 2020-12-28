<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales_info extends Model
{
    use HasFactory;

    protected $table = 'sales_info';
    protected $primaryKey = 'key_id';
    const UPDATED_AT = 'update_time';
    const CREATED_AT = 'regist_time';

    public function product_info()
    {
        return $this->belongsTo('App\Models\Product_info');
    }
}
