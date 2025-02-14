<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        // dd($request->all());
        $product =  new Product();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = $image->store('', 'public');
            $filePath = 'uploads/' . $fileName;
            $product->image =  $filePath;
        }

        $product->name = $request->name;
        $product->price = $request->price;
        $product->short_description = $request->short_description;
        $product->qty = $request->qty;
        $product->sku = $request->sku;
        $product->long_description = $request->description;
        $product->save();

        if ($request->has('colors') && $request->filled('colors')) {
            foreach ($request->colors as $color) {
                ProductColor::create([
                    'product_id' => $product->id,
                    'name' => $color,
                ]);
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $fileName = $image->store('', 'public');
                $filePath = 'uploads/' . $fileName;
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $filePath
                ]);
            }
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function getProducts(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::with('images')->select([
                'id',
                'image',
                'name',
                'price',
                'short_description',
                'qty',
                'sku',
                'long_description',
                'created_at',
                'updated_at'
            ]);

            return DataTables::of($products)
                ->addColumn('image', function ($row) {
                    $mainImage = '<img src="' . asset($row->image) . '" width="50" height="50" class="img-thumbnail me-1">';
                    $additionalImages = '';
                    foreach ($row->images as $img) {
                        $additionalImages .= '<img src="' . asset($img->path) . '" width="50" height="50" class="img-thumbnail me-1">';
                    }
                    return '<div class="d-flex">' . $mainImage . $additionalImages . '</div>';
                })
                ->editColumn('created_at', function ($row) {
                    return date('Y-m-d H:i', strtotime($row->created_at));
                })
                ->editColumn('updated_at', function ($row) {
                    return date('Y-m-d H:i', strtotime($row->updated_at));
                })
                ->editColumn('long_description', function ($row) {
                    return strip_tags($row->long_description);
                })
                ->addColumn('action', function ($row) {
                    return '<div class="btn-group">
                                <a href="' . route('products.edit', $row->id) . '" class="btn btn-sm btn-info">✏ Edit</a>
                                <a href="#" class="btn btn-sm btn-danger deleteBtn" data-id="' . $row->id . '">🗑 Delete</a>
                            </div>';
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }
    }
}
