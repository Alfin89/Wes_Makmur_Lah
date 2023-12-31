<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $list_products = Product::where('trending', '1')->take(15)->get();
        $trending_category = Category::where('populer', '1')->take(15)->get();
        return view('frontend.index', compact('list_products', 'trending_category'));
    }

    public function category()
    {
        $category = Category::where('status', '0')->get();
        return view('frontend.category', compact('category'));
    }

    public function category_view($slug)
    {
        if (Category::where('slug', $slug)->exists()) {
            $category = Category::where('slug', $slug)->first();
            $product = Product::where('cate_id', $category->id)->where('status', '0')->get();

            return view('frontend.product.index', compact('category', 'product'));
        }
        else 
        {
            return redirect('/')->with('status', 'Kategoi tidak ditemukan');
        }
        
    }

    public function product_view($cate_slug, $product_slug)
    {
        if (Category::where('slug', $cate_slug)->exists()) {
            
            if (Product::where('slug', $product_slug)->exists()) 
            {
                $product = Product::where('slug', $product_slug)->first();
                return view("frontend.product.view", compact('product'));
            }
            else {
                return redirect('/')->with('status', 'Tautan ini rusak');
            }
        }
        return redirect('/')->with('status', 'Tidak ada kategori seperti itu');
    }
}
