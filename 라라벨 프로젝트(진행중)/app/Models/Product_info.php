<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_info extends Model
{
    use HasFactory;
    protected $table = 'product_info';
    protected $primaryKey = 'product_code';
    const UPDATED_AT = 'update_date';
    const CREATED_AT = 'regist_date';

    /**
     * Get the sales_info record associated with the user.
     */
    public function sales_info()
    {
        return $this->hasMany('App\Models\Sales_info');
    }
}
