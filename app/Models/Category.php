<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Category extends Model
{
    use HasFactory, softDeletes;
    protected $table = 'category';
    protected $guarded = ['id'];

    public function products()
    {
        return $this->belongsTo(Product::class,'id','category_id');
    }


    
}
