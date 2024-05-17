<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class product extends Model
{
    use HasFactory, softDeletes;
    protected $table = 'product';
    protected $guarded = ['id'];

    public function category()
    {
        return $this->hasOne(Category::class);
    }


    
}
