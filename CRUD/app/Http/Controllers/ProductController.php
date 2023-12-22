<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct() {
        $this->middleware('auth')->except(['index','show']);
        // or
        //    $this->middleware('auth')->only('delete','update',"edit",'create','store');
    }

    public function index()
    {
        $products=Product::latest()->paginate(2);
        return view("products.index",compact("products"))
         ->with("i",request()->input("page",1) -1 * 2);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("products.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'details'=>'required',
            'image'=>'required|image|mimes:jpeg,png,jpg|max:10000',
        ]);
        $input = $request->all();
        if($image = $request->file('image')){
            $path='images/';
            $profileImage=date('YmdHis').".".$image->getClientOriginalExtension();
            $image->move($path,$profileImage);
            $input['image'] = "$profileImage";
        }

        Product::create($input);
        return redirect()->route('products.index')
        ->with('success',"Products added successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show',compact('product'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit',compact('product'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'=>'required',
            'details'=>'required',
        ]);
        $input = $request->all();
        if($image = $request->file('image')){
            $path='images/';
            $profileImage=date('YmdHis').".".$image->getClientOriginalExtension();
            $image->move($path,$profileImage);
            $input['image'] = "$profileImage";
        }else{
            unset($input['image']);
        }

        $product->update($input);
        return redirect()->route('products.index')
        ->with('success',"Products updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product ->delete();
        return redirect()->route('products.index')
        ->with('success',"Products deleted successfully");

    }
}
