<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class ProductImages extends Model
{
    use HasFactory, softDeletes;
    protected $table = 'product_images';
    protected $guarded = ['id'];

    

    
}
