<?php

namespace App\Http\Controllers\Admin;


use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;


class ProductImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $files = [];
        foreach ($request->file('files') as $file) {
            if ($file->isValid()) {
                $nama_image = md5(now() . "_") . $file->getClientOriginalName();
                $file->storeAs("img/products_image", $nama_image);
                $files[] = [
                    'product_id' => $request->product_id,
                    'image_name' => $nama_image,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        ProductImage::insert($files);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductImage  $productImages
     * @return \Illuminate\Http\Response
     */
    public function show(ProductImage $productImages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductImage  $productImages
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductImage $productImages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductImage  $productImages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductImage $productImages)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductImage  $productImages
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductImage $productImages)
    {
        Storage::delete('img/products_image/' . $productImages->image_name);
        $productImages->delete();
        return redirect()->back()->with('error', 'Gambar Telah Dihapus');
    }
}
