<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_info extends Model
{
    use HasFactory;
    protected $table = 'product_info';
    protected $primaryKey = 'product_code';
    const UPDATED_AT = 'regist_date';
}
