<?php

namespace App\Http\Controllers;

use App\Type;
use App\SubType;
use Illuminate\Http\Request;

class SubTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subTypes = SubType::all();
        $types = Type::all();
        return view('admin.admin.subType',compact('types', 'subTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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



        SubType::create([
            'type_id' => request('type_id'),
            'name' => request('name'),
            'description' => request('description'),
            //'user_id' => auth()->id(),
        ]);

        return redirect('admin/sub-type')->with('alert-success', 'Successfully added a new Product Catergory');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubType  $subType
     * @return \Illuminate\Http\Response
     */
    public function show(SubType $subType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubType  $subType
     * @return \Illuminate\Http\Response
     */
    public function edit(SubType $subType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubType  $subType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubType $subType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubType  $subType
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubType $subType)
    {
        //
    }
}
