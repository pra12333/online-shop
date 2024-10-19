<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function createproduct(){
        return view('create');
    }

    public function store(Request $request)
{
    // Validate the input fields
    $request->validate([
        'productname' => 'required|string|max:255',
        'price' => 'required|numeric',
        'available_stock' => 'required|integer',
        'description' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Ensure the uploaded file is an image
    ]);

    // Handle image upload
    $imagePath = null;
    if ($request->hasFile('image')) {
        // Store the image in the 'public/products' directory
        $imagePath = $request->file('image')->store('products', 'public');
    }

    // Create the product with the validated data and the image path
    Product::create([
        'productname' => $request->productname,
        'price' => $request->price,
        'available_stock' => $request->available_stock,
        'description' => $request->description,
        'image' => $imagePath,  // Save image path if uploaded
    ]);

    // Redirect back with a success message
    return redirect('index')->with('success', 'Product created successfully');
}


    public function edit($id){
        $product = Product::findOrFail($id);
        return view('edit',compact('product'));
    }
    public function update(Request $request, $id)
    {
        // Validate the input fields
        $request->validate([
            'productname' => 'required|string|max:255',
            'price' => 'required|numeric',
            'available_stock' => 'required|integer',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Ensure the uploaded file is an image
        ]);
    
        // Find the product to update
        $product = Product::findOrFail($id);
    
        // Handle image upload if a new image is uploaded
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }
    
            // Store the new image in the 'public/products' directory
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;  // Update the product's image path
        }
    
        // Update other product fields
        $product->productname = $request->productname;
        $product->price = $request->price;
        $product->available_stock = $request->available_stock;
        $product->description = $request->description;
        
        // Save the product
        $product->save();
    
        return redirect('index')->with('success', 'Product updated successfully');
    }
    

    public function destroy($id) {
        $product =Product::findOrFail($id);
        $product->delete();
        return redirect('index')->with('success','product deleted successfully');
    }

    public function showindex(){
        return view('index');
    }

    // method to show all products
    public function index(){
        // retrieve all products from the db
        $products = Product::all();

        // pass the products to the index view
        return view('index',compact('products'));
    }
    public function buyProduct(Request $request, $id)
    {
        // Validate the quantity input
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
    
        // Fetch the product
        $product = Product::findOrFail($id);
    
        // Check if the product has enough stock
        if ($product->available_stock >= $request->quantity) {
            // Reduce the stock by the selected quantity
            $product->available_stock -= $request->quantity;
            $product->save();
    
            // Create the order
            Order::create([
                'user_id' => 1, // Assuming you're using static user ID for now, replace with Auth::id() for logged-in users
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
    
            return redirect()->back()->with('success', 'Product purchased successfully');
        } else {
            return redirect()->back()->with('error', 'Not enough stock available');
        }
    }
    

}
