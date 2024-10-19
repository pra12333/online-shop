<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function showlogin(){
        return view('login');
    }

    
    public function checklogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        // First, attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Check the role after successful authentication
            $user = Auth::user();
    
            // If the user is an admin, redirect to the dashboard
            if ($user->role === 'admin') {
                return redirect()->route('dashboard');
            }
    
            // Otherwise, redirect to the home page for normal users
            return redirect()->route('homepage');
        }
    
        // If authentication fails, return back with an error
        return back()->with('error', 'Wrong details');
    }
    

public function logout(){
    Auth::logout();
    return redirect('/');
}
    public function showregister(){
        return view('register');
    }
    public function register(Request $request)
{
    // Validate the request
    $this->validate($request, [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8'],
        'phone' => ['required', 'numeric'],
    ]);

    // dd('Validation passed, proceeding to save.');


    // Create a new user with the validated data
    $user =User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password), // Hash the password
        'phone' => $request->phone,
    ]);
// dd($user);
    if ($user) {
        return redirect()->route('login')->with('success', 'User registered successfully');
    } else {
        return redirect()->back()->with('error', 'Failed to register user, please try again.');
    }
}
    
    public function showhomepage(){
        $user = Auth::user();
        // fetch the users purchased gooods
        $purchasedGoods = Order::where('user_id',$user->id)->count();

        $mostPurchasedItem = Order::where('user_id', $user->id)
    ->join('products', 'orders.product_id', '=', 'products.id')  // Join with products table
    ->select('products.productname', \DB::raw('COUNT(orders.product_id) as count'))  // Explicitly use products.product_name
    ->groupBy('products.productname')
    ->orderBy('count', 'desc')
    ->first();

    // dd($mostPurchasedItem);

        return view('home',compact('purchasedGoods','mostPurchasedItem'));
    }

    public function showaccount(){
        return view('account');
    }

    public function showtoppage(){
        $products = Product::all();
        return view('toppage',compact('products'));
    }

    public function purchases(){

        $user = Auth()->user();
        $purchases = $user->orders()->with('product')->get();
        return view('purchases',compact('purchases'));
    }
    public function showDashboard() {
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $mostPurchasedProduct = Order::join('products', 'orders.product_id', '=', 'products.id')
                                     ->select('products.productname', \DB::raw('SUM(orders.quantity) as total_quantity'))
                                     ->groupBy('products.productname')
                                     ->orderBy('total_quantity', 'desc')
                                     ->first();
        
        // fetch the admin
        $admins = User::where('role','admin')->get();
    
        $salesData = [65, 59, 80, 81, 56, 55]; // Example data, replace with actual data from your database.
    
        return view('dashboard', compact('totalUsers', 'totalProducts', 'mostPurchasedProduct', 'salesData' ,'admins'));
    }
    

    public function update(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'password' => 'nullable|string|min:8|confirmed',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Validate image
    ]);

    $user = auth()->user();

    if ($request->hasFile('profile_picture')) {
        // Delete old profile picture if exists
        if ($user->profile_picture) {
            Storage::delete('public/' . $user->profile_picture);
        }

        // Store the new image
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');
        $user->profile_picture = $path;  // Save the path in the database
    }

    // Update other user info
    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->password) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return redirect()->back()->with('success', 'Account updated successfully');
}
public function updateProfilePicture(Request $request, $id)
    {
        $admin = User::find($id);

        if ($request->hasFile('profile_picture')) {
            // Delete the old profile picture if it exists
            if ($admin->profile_picture) {
                Storage::delete('public/' . $admin->profile_picture);
            }

            // Store the new profile picture
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $admin->profile_picture = $path;
        }

        $admin->save();

        return redirect()->back()->with('success', 'Profile picture updated successfully!');
    }

}



    


