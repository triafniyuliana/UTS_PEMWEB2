<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Categories;

class HomepageController extends Controller
{
    public function index()
    {
        $categories = Categories::all();
        
        return view('web.homepage',[
            'categories' => $categories,
            'title'=>'Homepage'
        ]);
    }

    public function products()
    {
        $products = Product::paginate(10); 
        $title = "Products";

        return view('web.products', [
            'title' => $title,
            'products' => $products
        ]);
    }

    public function product($slug){
        return view('web.product', [
            'slug' => $slug
        ]);
    }

    public function categories()
    {
        return view('web.categories',[
            'title'=>'Categories'
        ]);
    }

    public function category($slug)
    {
        $category = Categories::find($slug);

        return view('web.category_by_slug', [
            'slug' => $slug, 
            'category' => $category
        ]);
    }

    public function cart()
    {
        return view('web.cart',[
            'title'=>'Cart'
        ]);
    }

    public function checkout()
    {
        return view('web.checkout',[
            'title'=>'Checkout'
        ]);
    }
}



// <!-- <?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// use App\Models\Categories;

// use App\Models\Product;

// class HomepageController extends Controller
// {
//     public function index()
//     {
//         $categories = Categories::all();
        
//         return view('web.homepage',[
//             'categories' => $categories,
//             'title'=>'Homepage'
//         ]);
//     }

//     public function products()
//     {
//         $products = Product::paginate(10); // Menggunakan paginate untuk membatasi produk per halaman
//         $title = "Products";

//         return view('web.products', [
//             'title' => $title,
//             'products' => $products // Kirim data produk yang sudah dipaginasi ke view
//         ]);
//     }

//     public function product($slug){
//         return view('web.product', [
//             'slug' => $slug
//         ]);
//     }

//     public function categories()
//     {
//         return view('web.categories',[
//             'title'=>'Categories'
//         ]);
//     }

//     public function category($slug)
//     {
//         $category = Categories::find($slug);

//         return view('web.category_by_slug', [
//             'slug' => $slug, 
//             'category' => $category
//         ]);
//     }

//     public function cart()
//     {
//         return view('web.cart',[
//             'title'=>'Cart'
//         ]);
//     }

//     public function checkout()
//     {
//         return view('web.checkout',[
//             'title'=>'Checkout'
//         ]);
//     }
// } -->
