<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Helper\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validator
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if(!$validator->passes()) {
            return response()->json(['status'=>'Success','code' => 403,'message'=>$validator->errors()->toArray()]);
        }else{
            try {
                // validate
                $validate = $request->validated();
                if(!empty($request->file('file')))
                {
                    $file = $request->file('file');
                    $fileOldName = $file->getClientOriginalName();
                    $image = Images::imageResize($file,20,20);
                    $fileName = time().$fileOldName;
                    $location = public_path().'/thumbnail/';
                    $allFileName = $location.$fileName;
                    $image->save($location.$fileName,100);
                }
                $category = new Category;
                $category->name = $validate['name'];
                $category->image = $allFileName;
                $category->save();
                return response()->json(['status'=>'Success','message'=>'Category Added Successfully']);
            } catch (\Exception $e) {
                return response()->json(['status'=>$e, 'message'=>$e->getMessage()]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validator
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if(!$validator->passes()) {
            return response()->json(['status'=>'Success','code' => 403,'message'=>$validator->errors()->toArray()]);
        }else{
            try {
                // validate
                $validate = $request->validated();
                if(!empty($request->file('file')))
                {
                    $file = $request->file('file');
                    $fileOldName = $file->getClientOriginalName();
                    $image = Images::imageResize($file,20,20);
                    $fileName = time().$fileOldName;
                    $location = public_path().'/thumbnail/';
                    $allFileName = $location.$fileName;
                    $image->save($location.$fileName,100);
                }
                $category = Category::find($id);
                unlink($category->image);
                $category->name = $validate['name'];
                $category->image = $allFileName;
                $category->save();
                return response()->json(['status'=>'Success','message'=>'Category Updated Successfully']);
            } catch (\Exception $e) {
                return response()->json(['status'=>$e, 'message'=>$e->getMessage()]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $category = Category::find($id);
            unlink($category->image);
            $category->delete();
            return response()->json(['status'=>'Success','message'=>'Category Deleted Successfully']);
        } catch (\Exception $e) {
            return response()->json(['status'=>$e, 'message'=>$e->getMessage()]);
        }
    }
}
