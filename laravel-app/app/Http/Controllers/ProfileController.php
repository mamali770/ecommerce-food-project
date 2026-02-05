<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Order;
use App\Models\Province;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index() 
    {
        $user = auth()->user();
        return view('profile.index', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            "name" => "required|string",
            "email" => "required|unique:users,email," . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return redirect()->route('profile.index')->with('success', 'اطلاعات کاربری با موفقیت ثبت شد.');
    }

    public function address() {
        $addresses = auth()->user()->addresses;
        return view('profile.address.index', compact('addresses'));
    }

    public function addressCreate() {
        $provinces = Province::all();
        $cities = City::all();
        return view('profile.address.create', compact('provinces', 'cities'));
    }

    public function addressStore(Request $request) {
        $request->validate([
            "title" => "required|string",
            "phone" => ['required', 'regex:/^09[1|2|3][0-9]{8}$/'],
            "postal_code" => "required|digits:10",
            "province_id" => "required|integer",
            "city_id" => "required|integer",
            "address" => "required|string",
        ]);

        UserAddress::create([
            "user_id" => auth()->id(),
            "title" => $request->title,
            "phone" => $request->phone,
            "postal_code" => $request->postal_code,
            "province_id" => $request->province_id,
            "city_id" => $request->city_id,
            "address" => $request->address,
        ]);

        return redirect()->route('profile.address')->with('success', 'آدرس شما با موفقیت ایجاد شد.');
    }

    public function addressEdit(UserAddress $address) {
        $provinces = Province::all();
        $cities = City::all();
        return view('profile.address.edit', compact('provinces', 'cities', 'address'));
    }

    public function addressUpdate(Request $request, UserAddress $address) {
        $request->validate([
            "title" => "required|string",
            "phone" => ['required', 'regex:/^09[1|2|3][0-9]{8}$/'],
            "postal_code" => "required|digits:10",
            "province_id" => "required|integer",
            "city_id" => "required|integer",
            "address" => "required|string",
        ]);

        $address->update([
            "title" => $request->title,
            "phone" => $request->phone,
            "postal_code" => $request->postal_code,
            "province_id" => $request->province_id,
            "city_id" => $request->city_id,
            "address" => $request->address,
        ]);

        return redirect()->route('profile.address')->with('success', 'آدرس شما با موفقیت ویرایش شد.');
    }

    public function addWishlist(Request $request) {
        $request->validate([
            "product" => "required|integer|exists:products,id"
        ]);

        if (!auth()->check()) {
            return redirect()->back()->with('warning', 'برای استفاده از علاقه مندی ها ابتدا باید وارد شوید.');
        }

        Wishlist::create([
            "user_id" => auth()->id(),
            "product_id" => $request->product
        ]);

        return redirect()->back()->with('success', 'محصول با موفقیت به لیست علاقه مندی ها اضافه شد.');
    }

    public function Wishlist() {
        $wishlist = auth()->user()->wishlist;
        return view('profile.wishlist', compact('wishlist'));
    }

    public function removeWishlist(Request $request) {
        $request->validate([
            "wishlist" => "required|integer|exists:wishlist,id"
        ]);

        $wishlist = Wishlist::findOrFail($request->wishlist);
        $wishlist->delete();

        return redirect()->back()->with('warning', 'محصول مورد نظر با موفقیت از لیست علاقه مندی حذف شد.');
    }

    public function order()
    {
        $orders = auth()->user()->orders()->orderByDesc('created_at')->with(['address', 'products'])->paginate(5);

        return view('profile.orders', compact('orders'));
    }

    public function transaction()
    {
        $transactions = auth()->user()->transactions()->orderByDesc('created_at')->paginate(5);

        return view('profile.transactions', compact('transactions'));
    }

    public function logout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home.index')->with('warning', 'خروج از پنل کاربری با موفقیت انجام شد.');
    }
}
