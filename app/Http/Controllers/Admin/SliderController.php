<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Slider;
use App\Helper\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::all();
        return view('admin.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slider.create');
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
            'file' => 'required|array',
            'file.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required',
            'type' => 'required',
            'height' => 'required|numeric',
            'width' => 'required|numeric',
        ]);

        if(!$validator->passes()) {
            return response()->json(['status'=>'Success','code' => 403,'message'=>$validator->errors()->toArray()]);
        }else{
            try{
                $files = $request->file('file');
                foreach($files as $file)
                {
                    list($width, $height) = getimagesize($file);
                    if($width > 551 || $height > 440)
                    {
                        $fileOldName = $file->getClientOriginalName();
                        $image = Images::imageResize($file,$request->width,$request->height);
                        $fileName = time().$fileOldName;
                        $location = public_path().'/slider/';
                        $allFileName[] = $location.$fileName;
                        $image->save($location.$fileName,100);   
                    }
                }
                $slider = new Slider;
                $slider->image = json_encode($allFileName);
                $slider->description = $request->description;
                $slider->type = $request->type;
                $slider->save();
                return response()->json(['status'=>'Success','message'=>'Slider Added Successfully']);
            }catch(\Exception $e){
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
        $slider = Slider::find($id);
        return view('admin.slider.edit', compact('slider'));
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
        $validator = Validator::make($request->all(), [
            'file' => 'required|array',
            'file.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required',
            'type' => 'required',
            'height' => 'required|numeric',
            'width' => 'required|numeric',
        ]);

        if(!$validator->passes()) {
            return response()->json(['status'=>'Success','code' => 403,'message'=>$validator->errors()->toArray()]);
        }else{
            try{
                $slider = Slider::find($id);
                if(!empty($request->file('file')))
                {
                    $files = $request->file('file');
                    foreach($files as $file)
                    {
                        list($width, $height) = getimagesize($file);
                        if($width > 551 || $height > 440)
                        {
                            $fileOldName = $file->getClientOriginalName();
                            $image = Images::imageResize($file,$request->width,$request->height);
                            $fileName = time().$fileOldName;
                            $location = public_path().'/slider/';
                            $allFileName[] = $location.$fileName;
                            $image->save($location.$fileName,100);   
                        }
                    }
                    $slider->image = json_encode($allFileName);
                }
                
                $slider->description = $request->description;
                $slider->type = $request->type;
                $slider->save();
                return response()->json(['status'=>'Success','message'=>'Slider Updated Successfully']);
            }catch(\Exception $e){
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
        try{
            $slider = Slider::find($id);
            $slider->delete();
            return response()->json(['status'=>'Success','message'=>'Slider Deleted Successfully']);
        }catch(\Exception $e){
            return response()->json(['status'=>$e, 'message'=>$e->getMessage()]);
        }
    }
}
