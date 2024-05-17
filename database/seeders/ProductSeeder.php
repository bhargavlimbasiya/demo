<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\ProducVariationt;
use Illuminate\Support\Facades\DB;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
        ['name' => 'product one', 'description' => 'product one description','price'=>200,
        'category_id'=>1,
         'image'=>['image1','image2'],
         'color'=>['grey','black'],
         'size' =>['s','m']
        ],
       
        ['name' => 'product one', 'description' => 'product one description','price'=>100,'category_id'=>2,
        'image'=>['image3','image4'],
        'color'=>['red','pink'],
        'size' =>['xl','xxl']
         ]
    ];
    $images=[];
    $variationt =[];
    DB::beginTransaction();

try {
    foreach($products as $product){
     
        $insert= Product::create(['name'=>$product['name'],'description'=> $product['description'],'status'=>$product['status']
        ,'price'=>$product['price'],'category_id'=>$product['category_id']]);
     
     foreach($product['image'] as $image){
       $images[]=  ['image'=>$image,'product_id'=>$insert->id];
        }
        foreach($product['color'] as $key=>$color){
         $variationt[]=  ['colour'=>$color,'size'=>$product['size'][$key]??"",'product_id'=>$insert->id];
          }

     }
     ProductImages::insert($images);
     ProducVariationt::insert($variationt);

    DB::commit();
    // all good
} catch (\Exception $e) {
    info($e);
    DB::rollback();
    // something went wrong
}
        
    }
}
