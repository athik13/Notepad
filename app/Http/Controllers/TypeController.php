<?php

namespace App\Http\Controllers;

use App\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Mohamedathik\PhotoUpload\Upload;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::all();
        return view('admin.admin.type',compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
        ]);



        $type = Type::create([
            'name' => request('name'),
            'description' => request('description'),
            //'user_id' => auth()->id(),
        ]);

        if (\Request::has('image')) {
            $file = $request->image;
            $file_name = $file->getClientOriginalName();
            $location = "/images";
            $url_original = Upload::upload_original($file, $file_name, $location);

            $type->photo_url = '/storage'.$url_original;
            $type->save();
        }

        return redirect('admin/type')->with('alert-success', 'Successfully added a new Product Catergory');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        return view('admin.admin.type', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {
        $this->validate(request(), [
            'name' => 'required',
        ]);

        $type->name = request('name');
        $type->description = request('description');
        $type->user_id = auth()->id();
        $type->save();

        if (\Request::has('image')) {
            $file = $request->image;
            $file_name = $file->getClientOriginalName();
            $location = "/images";
            $url_original = Upload::upload_original($file, $file_name, $location);

            $type->photo_url = '/storage'.$url_original;
            $type->save();
        }

        return redirect('admin/type')->with('alert-success', 'Successfully updated Product Catergory');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {

    }
}
