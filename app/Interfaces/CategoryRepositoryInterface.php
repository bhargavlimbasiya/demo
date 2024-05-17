<?php

namespace App\Interfaces;

interface CategoryRepositoryInterface
{
    public function getDetailsAjax($request);
    public function storeData($details);
    public function updateData($where, $data);
    public function getDataById($id);
    public function delete($id);
    public function bulkDelete($ids);
    
}
