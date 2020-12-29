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
    protected $fillable = ['eng_name','kor_name','fst_cate','snd_cate','origin','type','personality','in_price','out_price','descr'];
    /**
     * Get the sales_info record associated with the user.
     */
    public function sales_info()
    {
        return $this->hasMany('App\Models\Sales_info');
    }

    /**
     * Get the sales_info record associated with the user.
     */
    public function attachments()
    {
        return $this->hasOne('App\Models\Attachments');
    }
}
