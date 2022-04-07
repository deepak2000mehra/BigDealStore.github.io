<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\SubCategory;
use App\Models\Admin\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = SubCategory::with('category')->get();
        return view('admin.subcategory.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.subcategory.create', compact('categories'));
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
            'category_id' => 'required',
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
                    $file->move($location, $fileName);
                    $subcategory = new SubCategory();
                    $subcategory->name = $request->name;
                    $subcategory->category_id = $request->category_id;
                    $subcategory->image = $fileName;
                    $subcategory->save();
                    return response()->json(['status'=>'Success','code' => 200,'message'=>'SubCategory Added Successfully']);
                }
            } catch (\Exception $e) {
                return response()->json(['status'=>'Success','code' => 500,'message'=>$e->getMessage()]);
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
        $subcategory = SubCategory::find($id);
        $categories = Category::all();
        return view('admin.subcategory.edit', compact('subcategory', 'categories'));
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
            'category_id' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if(!$validator->passes()) {
            return response()->json(['status'=>'Success','code' => 403,'message'=>$validator->errors()->toArray()]);
        }else{
            try {
                if(!empty($request->file('file')))
                {
                    $file = $request->file('file');
                    $fileOldName = $file->getClientOriginalName();
                    $image = Images::imageResize($file,20,20);
                    $fileName = time().$fileOldName;
                    $location = public_path().'/thumbnail/';
                    $file->move($location, $fileName);
                    $subcategory = SubCategory::find($id);
                    $subcategory->name = $request->name;
                    $subcategory->category_id = $request->category_id;
                    $subcategory->image = $fileName;
                    $subcategory->save();
                    return response()->json(['status'=>'Success','code' => 200,'message'=>'SubCategory Updated Successfully']);
                }
            } catch (\Exception $e) {
                return response()->json(['status'=>'Success','code' => 500,'message'=>$e->getMessage()]);
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
        // delete
        $subcategory = SubCategory::find($id);
        $subcategory->delete();
        return response()->json(['status'=>'Success','code' => 200,'message'=>'SubCategory Deleted Successfully']);
    }
}
