<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
    use HasFactory;
    protected $table = 'attachments';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function product_info(){
        return $this->belongsTo('App\Models\Product_info');
    }
}
