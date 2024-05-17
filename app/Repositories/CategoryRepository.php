<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getDetailsAjax($request)
    {
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 100);
        $order = $request->query('order', array(1, 'desc'));
        $sortColumns = array(
            0 => 'category.id',
        );
        $query =  Category::select('*')->withCount('products');
        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);
        $json = array(
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        );
        $no = $start + 1;
        $categoryData = $query->get();

        foreach ($categoryData as $category) {
            $status = $category['status'];
            $edit = route("categories.edit", $category['id']);
            $getId = $category['id'];
            $action = ' ';
            
            
             $statusToggle = $category['status'] == '1' ? 'checked' : '';
            

          

            $action = '';
            $ids = '
                <input type="checkbox" name="ids[]"  value="'.$getId.'" class="form-check-input '.$getId.' w-20px h-20px  id_check" data-id="' . $getId . '" id="cate-id">
               ';
                $status = '<div class="col-lg-8 d-flex align-items-center">
                <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                    <input type="checkbox" name="select" class="form-check-input status_'.$getId.' w-45px h-30px toggle-class status_check" data-id="' . $getId . '" id="status" data-on="Active" data-off="InActive" ' . $statusToggle . '>
                   </div>
                   </div>';

                $action .= '<div style="float:right;"><a href="' . $edit . '" title="Edit" class="navi-link" style="margin-right: 7px;">
                                       <span class="navi-icon">
                                           <i class="fa fa-edit text-primary" style="font-size:1.5rem;"></i>
                                       </span>
                                   </a>';
            

            
                $action .= ' <a href="javascript:void(0);" data-id="' . $getId . '" class="navi-link delToolType deletecategory" title="Delete">
                                   <span class="navi-icon">
                                       <i class="fa fa-trash text-danger" style="font-size:1.5rem;"></i>
                                   </span>

                               </a> </div>';
            

            $json['data'][] = [
                $ids ." ".$no,
                $category['name'],
                $category['products_count'],
                $status,
                $action
            ];
            $no++;
        }
        return $json;
    }

    public function storeData($data)
    {
        $data = Category::create($data);
        
        return $data;
    }
    
    public function updateData($where, $data)
    {
        
        $updateData = Category::where($where)->update($data);
        return $updateData;
    }

   

    
    public function getDataById($id)
    {
        return Category::findOrfail($id);
    }

   
    public function delete($id)
    {
        return Category::where('id', $id)->delete();
    }
    public function bulkDelete($ids)
    {
        return Category::whereIn('id', $ids)->delete();
    }
    
}
