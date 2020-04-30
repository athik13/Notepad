<?php

namespace App\Http\Controllers;

use App\Products;
use App\Type;
use App\SubType;
use App\ProductPhotos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Mohamedathik\PhotoUpload\Upload;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = ProductPhotos::all();
        $subTypes = SubType::all();
        $products = Products::all();
        return view('admin.admin.products-add',compact('products', 'subTypes', 'colors'));
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
            'rprice' => 'required'
        ]);


        $product = Products::create([
            'name' => request('name'),
            'description' => request('description'),
            'retail_price' => request('rprice'),
            'wholesale_price' => request('wprice'),
            'sub_type_id' => request('sub_type_id'),
            'featured_product' => (request('fproduct') == null ? '0' : request('fproduct')),
            'toppicks' => (request('toppicks') == null ? '0' : request('toppicks')),
            'qty' => request('qty'),
           // 'user_id' => auth()->id(),
        ]);


        $files = $request->image;

        if ($files !== NULL) {
            $i = 0;

            foreach ($files as $file) {
                $i++;
                $m = ($i == '1') ? '1' : '0';

                $file_name = $file->getClientOriginalName();
                $location = "/images";
                $url_original = Upload::upload_original($file, $file_name, $location);
                $url_thumbnail = Upload::upload_thumbnail($file, $file_name, $location);

                ProductPhotos::create([
                    'product_id' => $product->id,
                    'main' => $m,
                    'color' => request('color'),
                    'url_original' => $url_original,
                    'url_thumbnail' => $url_thumbnail,
                ]);

            }
        }

        return redirect('admin/product')->with('alert-success', 'Successfully added a new Product');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products $products)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $products)
    {
        //
    }

    public function showImages(Products $product)
    {
        return view('admin.admin.products-photos', compact('product'));
    }

    public function storeImages(Request $request)
    {
        $product = Products::findOrFail(request('product_id'));

        $files = $request->image;
        if ($files !== NULL) {
            $i = 0;

            foreach ($files as $file) {
                $i++;
                $m = ($i == '1') ? '1' : '0';

                $file_name = $file->getClientOriginalName();
                $location = "/images";
                $url_original = Upload::upload_original($file, $file_name, $location);
                $url_thumbnail = Upload::upload_thumbnail($file, $file_name, $location);

                ProductPhotos::create([
                    'product_id' => $product->id,
                    'main' => $m,
                    'color' => request('color'),
                    'url_original' => $url_original,
                    'url_thumbnail' => $url_thumbnail,
                ]);

            }
        }

        return redirect()->back()->with('alert-success', 'Successfully uploaded Images');

    }

    public function updateImageColor(Request $request)
    {
        $image = ProductPhotos::find($request->image_id);
        $image->color = $request->color;
        $image->save();

        return redirect()->back()->with('alert-success', 'Successfully updated image color');
    }
}
