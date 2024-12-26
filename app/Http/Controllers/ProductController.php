<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class ProductController extends Controller
{
    //

    public function create()
    {
        if(!Auth::user()->hasPermissionTo('product.create')){
            abort(403, 'You are not allowed to create product');
        }
        $categories = Category::all();
        return view('admin.pages.product.create', compact('categories'));
    }
    public function getSubcategories($category_id)
    {
        $subcategories = SubCategory::where('category_id', $category_id)->get();
        return response()->json($subcategories);
    }

    public function store(Request $request){
        if(!Auth::user()->hasPermissionTo('product.create')){
            abort(403, 'You are not allowed to create product');
        }
        $validate = $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:7168',
        ]);
        // Main image upload
        $main_image_file = $request->file('photo');
        $main_image_name = Str::slug($request->name) . '-' . time() . '.' . $main_image_file->getClientOriginalExtension();
        $main_image_path = 'admin/images/main_image';
        $main_image_file->move(public_path($main_image_path), $main_image_name);
        $main_imagePath = $main_image_path . '/' . $main_image_name;


        $obj =new Product();
        $obj->name = $request->name;
        $obj->slug = Str::slug($request->name);
        $obj->category_id = $request->category_id;
        $obj->sub_category_id = $request->sub_category_id;
        $obj->photo = $main_imagePath;
        $obj-> save();
        return redirect('admin/getAllProducts');
    }

    public function getAllProducts(){
        if(!Auth::user()->hasPermissionTo('product.view')){
            abort(403, 'You are not allowed to view product');
        }
        $products = Product::with(['category', 'subCategory'])->get();
        return view('admin.pages.product.all', compact('products'));
    }

    public function edit($id){
        if(!Auth::user()->hasPermissionTo('product.edit')){
            abort(403, 'You are not allowed to edit product');
        }
        // Retrieve the product by its ID
        $product = Product::findOrFail($id);

        // Retrieve all categories
        $categories = Category::all();

        // Retrieve subcategories related to the product's category
        $sub_categories = SubCategory::where('category_id', $product->category_id)->get();

        // Pass the product, categories, and subcategories to the view
        return view('admin.pages.product.edit', compact('product', 'categories', 'sub_categories'));
    }

    public function update(Request $request, $id){
        if(!Auth::user()->hasPermissionTo('product.edit')){
            abort(403, 'You are not allowed to edit product');
        }
        $validate = $request->validate([
        'name' => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'sub_category_id' => 'required|exists:sub_categories,id',
        'photo' => 'image|mimes:jpeg,png,jpg|max:7168',
        ]);

        // Find the product
        $product = Product::findOrFail($id);

        // Handle main image upload if a new image is provided
        if ($request->hasFile('photo')) {
            $main_image_file = $request->file('photo');
            $main_image_name = Str::slug($request->name) . '-' . time() . '.' . $main_image_file->getClientOriginalExtension();
            $main_image_path = 'admin/images/main_image';
            $main_image_file->move(public_path($main_image_path), $main_image_name);
            $main_imagePath = $main_image_path . '/' . $main_image_name;
            $product->photo = $main_imagePath;
        }

        // Update product details
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->save();
        return redirect()->back()->with('msg', 'product updated successfully');
    }

    public function delete($id){
        if(!Auth::user()->hasPermissionTo('product.delete')){
            abort(403, 'You are not allowed to delete product');
        }
        Product::find($id)->delete();
        return redirect()->back()->with('msg', 'Category deleted successfully');
    }
}