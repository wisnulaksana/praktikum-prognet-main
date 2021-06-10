<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Carts;
use App\Models\Discounts;
use App\Models\ProductImage;
use App\Models\Response;
use App\Models\ReviewProducts;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::all();
        return view('admin/product/index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorys = Category::all();
        return view('admin/product/add', compact('categorys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = $request->category_id; // arrays of role ids
        $products = new Products;
        $products->product_name = $request->product_name;
        $products->price = $request->price;
        $products->stock = $request->stock;
        $products->weight = $request->weight;
        $products->description = $request->description;
        $products->product_rate = '0';
        $products->save();
        $products->category()->attach($category);

        $idproduct = Products::orderBy('id', 'desc')->first()->id;

        if ($idproduct) {
            $files = [];
            foreach ($request->file('files') as $file) {
                if ($file->isValid()) {
                    $nama_image = md5(now() . "_") . $file->getClientOriginalName();
                    $file->storeAs("img/products_image", $nama_image);
                    $files[] = [
                        'product_id' => $idproduct,
                        'image_name' => $nama_image,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
            ProductImage::insert($files);
        }
        return redirect(Route('product'))->with('success', 'Berhasil menambahkan Product');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Products $product)
    {
        $notificationId = request('id');

        $adminUnreadNotification = auth()->user()
            ->unreadNotifications
            ->where('id', $notificationId)
            ->first();
        // dd($notificationId);
        if ($adminUnreadNotification) {
            $adminUnreadNotification->update(['read_at' => now()]);
        }
        $responses = Response::all();
        return view('/admin/product/show', compact('product', 'responses'));
    }

    public function discounts(Products $product)
    {
        $discounts =  Discounts::where('id_product', $product->id)->get();
        return view('/admin/discounts/index', compact('product', 'discounts'));
    }

    public function discounts_store(Request $request)
    {

        $discounts = $request->all();
        Discounts::create($discounts);
        return redirect()->back()->with('success', 'Diskon Berhasil Ditambahkan');
    }

    public function discounts_destroy(Discounts $discounts)
    {
        $discounts->delete();
        return redirect()->back()->with('error', 'Data Telah Dihapus');
    }

    public function discounts_update(Discounts $discounts, Request $request)
    {

        $discount = $request->all();
        $discounts->update($discount);
        return redirect()->back()->with('info', 'Diskon Berhasil Update');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Products $product)
    {
        $categorys = Category::all();
        return view('admin/product/edit', compact('categorys', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products $product)
    {
        $category = $request->category_id; // arrays of role ids
        Products::find($product->id)->category()->sync($category);

        $products = $request->except(['category_id']); // pengecualian request
        $product->update($products);
        return redirect(Route('product'))->with('info', 'Product Telah Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $product)
    {
        foreach ($product->reviews as $review) {
            Response::where('review_id', $review->id)->delete();
        }
        Carts::where('product_id', $product->id)->delete();

        $product->Transactions()->detach();
        $product->category()->detach();
        Discounts::where('id_product', $product->id)->delete();

        foreach ($product->product_image as $image) {
            Storage::delete('img/products_image/' . $image->image_name);
        }
        ProductImage::where('product_id', $product->id)->delete();
        ReviewProducts::where('product_id', $product->id)->delete();

        $product->delete();
        return redirect(Route('product'))->with('error', 'Data Telah Dihapus');
    }
}
