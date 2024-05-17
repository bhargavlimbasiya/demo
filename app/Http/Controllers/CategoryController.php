<?php

namespace App\Http\Controllers;

use App\Interfaces\CategoryRepositoryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryFormRequest;


class CategoryController extends Controller
{
    protected $categoryRepository = "";
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    
        $titles = [
            'title' => 'Category List',
            'breadcrumb_item' => [
                ['title' => 'Dashboard', 'link' => true, 'route' => route('dashboard')],
                ['title' => 'Categories', 'link' => false, 'route' => ''],
            ],
        ];

        return view('category.index', compact('titles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
        $titles = [
            'title' => 'Category List'
        ];
    }

    public function ajaxList(Request $request){
        return $this->categoryRepository->getDetailsAjax($request);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
        $titles = [
            'title' => 'Add User',
            'breadcrumb_item' => [
                ['title' => 'Dashboard', 'link' => true, 'route' => route('dashboard')],
                ['title' => 'Categories', 'link' => true, 'route' => route('categories.index')],
                ['title' => 'Create', 'link' => false, 'route' => ''],
            ],
        ];
        return view('category.create', compact('titles'));
    }

    // User create and update both with this function
    public function store(CategoryFormRequest $request)
    {
        
        try {
            $insertData = array(
                'name' => request('name'),
                'description' => request("description")    
            );
     

                $this->categoryRepository->storeData($insertData);
                $message = 'messages.custom.create_messages';
             

            return $this->sendResponse(true, ['data' => []], trans(
                $message,
                ["attribute" => "Category"]
            ));
        } catch (\Exception $e) {
            return $this->sendResponse(false, [], 'Something went wrong. Try again please..!!');
        }
    }



    public function show(string $id)
    {

    }


    public function edit(string $id)
    {
        $category = $this->categoryRepository->getDataById($id);
        
        $titles = [
            'title' => 'Edit Category',
            'breadcrumb_item' => [
                ['title' => 'Dashboard', 'link' => true, 'route' => route('dashboard')],
                ['title' => 'Users', 'link' => true, 'route' => route('categories.index')],
                ['title' => 'Edit', 'link' => false, 'route' => ''],
            ],
        ];
        return view('category.edit', compact('titles', 'category'));
    }

    public function update($id,CategoryFormRequest $request)
    {
        
        try {
            $updateData = array(
                'name' => request('name'),
                'description' => request("description")    
            );
     
                $this->categoryRepository->updateData(['id'=>$id],$updateData);
                $message = 'messages.custom.create_messages';
             

                  return redirect()->route('categories.index')->with('success', trans(
                    $message,
                    ["attribute" => "Category"]
                ));   

            // return $this->sendResponse(true, ['data' => []], trans(
            //     $message,
            //     ["attribute" => "Category"]
            // ));
        } catch (\Exception $e) {
            info($e);
            return redirect()->back()->with('success','Something went wrong. Try again please..!!');   
            // return $this->sendResponse(false, [], 'Something went wrong. Try again please..!!');
        }
    }


    public function destroy($id)
    {
        try {
            $this->categoryRepository->delete($id);
            return $this->sendResponse(true, ['data' => []], trans(
                'messages.custom.delete_messages',
                ["attribute" => "Category"]
            ));
        } catch (\Exception $e) {
            return $this->sendResponse(false, [], 'Something went wrong. Try again please..!!');
        }
    }

    public function bulkDelete(Request $request )
    {
        try {
            $ids =request('ids');
            $this->categoryRepository->bulkDelete($ids);
            return $this->sendResponse(true, ['data' => []], trans(
                'messages.custom.delete_messages',
                ["attribute" => "Category"]
            ));
        } catch (\Exception $e) {
            return $this->sendResponse(false, [], 'Something went wrong. Try again please..!!');
        }
    }
    public function changeUserStatus(Request $request){
        try {
            $updateData = array(
                'status' => request('status')    
            );
     
                $this->categoryRepository->updateData(['id'=>request('category_id')],$updateData);
                $message = 'messages.custom.create_messages';
           
            return $this->sendResponse(true, ['data' => []], trans(
                'messages.custom.update_messages',
                ["attribute" => "Category Status"]
            ));
        } catch (\Exception $e) {
            return $this->sendResponse(false, [], 'Something went wrong. Try again please..!!');
        }
    }
}
