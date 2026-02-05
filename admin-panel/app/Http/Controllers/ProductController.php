<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(5);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {

        // validation on user data
        $request->validate([
            'primary_image' => 'required|image',
            'name' => 'required|string',
            'category' => 'required|integer',
            'description' => 'required',
            'price' => 'required|integer',
            'status' => 'required|integer',
            'quantity' => 'required|integer',
            'sale_price' => 'nullable|integer',
            'date_on_sale_from' => 'nullable|date_format:Y/m/d H:i:s',
            'date_on_sale_to' => 'nullable|date_format:Y/m/d H:i:s',
            'images.*' => 'nullable|image'
        ]);

        // For better SEO, the original image name and extension are separated.
        // To ensure uniqueness, the current milliseconds are appended before the extension,
        // then the file is saved.

        $primaryImage = $request->primary_image;
        $primaryImageName = pathinfo($primaryImage->getClientOriginalName(), PATHINFO_FILENAME);
        $primaryImageExtension = $primaryImage->getClientOriginalExtension();
        $primaryImageFullName = $primaryImageName . '-' . Carbon::now()->microsecond . '.' . $primaryImageExtension;

        $request->primary_image->storeAs('images/products/', $primaryImageFullName);

        DB::beginTransaction();

        $product = Product::create([
            'name' => $request->name,
            'slug' => $this->makeSlug($request->name),
            'category_id' => $request->category,
            'status' => $request->status,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'sale_price' => $request->sale_price !== null ? $request->sale_price : 0,
            'date_on_sale_from' => $request->date_on_sale_from !== null ? getMiladiDate($request->date_on_sale_from) : null,
            'date_on_sale_to' => $request->date_on_sale_to !== null ? getMiladiDate($request->date_on_sale_to) : null,
            'description' => $request->description,
            'primary_image' => $primaryImageFullName
        ]);

        if ($request->images !== null) {
            $images = $request->images;
            foreach ($images as $image) {
                $imageName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $imageExtension = $image->getClientOriginalExtension();
                $imageFullName = $imageName . '-' . Carbon::now()->microsecond . '.' . $imageExtension;
                $image->storeAs('images/products/', $imageFullName);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imageFullName,
                ]);
            }
        }

        DB::commit();

        return redirect()->route('product.create')->with('success', 'محصول با موفقیت ایجاد شد');
    }

    public function makeSlug($string)
    {
        $slug = slugify($string);
        $count = Product::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        $result = $count ? $slug . "-" . $count : $slug;
        return $result;
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        // validation on user data
        $request->validate([
            'primary_image' => 'nullable|image',
            'name' => 'required|string',
            'category' => 'required|integer',
            'description' => 'required',
            'price' => 'required|integer',
            'status' => 'required|integer',
            'quantity' => 'required|integer',
            'sale_price' => 'nullable|integer',
            'date_on_sale_from' => 'nullable|date_format:Y/m/d H:i:s',
            'date_on_sale_to' => 'nullable|date_format:Y/m/d H:i:s',
            'images.*' => 'nullable|image'
        ]);

        // For better SEO, the original image name and extension are separated.
        // To ensure uniqueness, the current milliseconds are appended before the extension,
        // then the file is saved.

        if ($request->primary_image != null) {
            Storage::delete('/images/products/' . $product->primary_image);

            $primaryImage = $request->primary_image;
            $primaryImageName = pathinfo($primaryImage->getClientOriginalName(), PATHINFO_FILENAME);
            $primaryImageExtension = $primaryImage->getClientOriginalExtension();
            $primaryImageFullName = $primaryImageName . '-' . Carbon::now()->microsecond . '.' . $primaryImageExtension;

            $request->primary_image->storeAs('images/products/', $primaryImageFullName);
        }

        DB::beginTransaction();

        $product->update([
            'name' => $request->name,
            'category_id' => $request->category,
            'status' => $request->status,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'sale_price' => $request->sale_price !== null ? $request->sale_price : 0,
            'date_on_sale_from' => $request->date_on_sale_from !== null ? getMiladiDate($request->date_on_sale_from) : null,
            'date_on_sale_to' => $request->date_on_sale_to !== null ? getMiladiDate($request->date_on_sale_to) : null,
            'description' => $request->description,
            'primary_image' => $request->primary_image != null ? $primaryImageFullName : $product->primary_image
        ]);

        if ($request->images !== null) {
            $images = $request->images;
            foreach ($product->images as $image) {
                Storage::delete('/images/products/' . $image->image);
                $image->delete();
            }
            foreach ($images as $image) {
                $imageName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $imageExtension = $image->getClientOriginalExtension();
                $imageFullName = $imageName . '-' . Carbon::now()->microsecond . '.' . $imageExtension;
                $image->storeAs('images/products/', $imageFullName);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imageFullName,
                ]);
            }
        }

        DB::commit();

        return redirect()->route('product.index')->with('success', 'محصول با موفقیت ویرایش شد');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')->with('warning', 'محصول با موفقیت حذف شد');
    }
}
