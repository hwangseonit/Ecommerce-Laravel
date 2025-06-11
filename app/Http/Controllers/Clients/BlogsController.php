<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use App\Models\Posts;
use App\Models\Product;
use Illuminate\Http\Request;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use function Termwind\render;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $newProducts = Product::where('status', 1)->latest()->take(5)->get();
        foreach ($newProducts as $newProduct) {
            if ($newProduct->has_variants) {
                $prices = $newProduct->variants->pluck('price')->toArray();
                if (count($prices) == 1) {
                    $newProduct->price_range = number_format($prices[0],  0, ',', '.') . '₫';
                } elseif (count($prices) > 1) {
                    $newProduct->price_range = number_format(min($prices), 0, ',', '.') . ' - ' . number_format(max($prices),  0, ',', '.') . '₫';
                }
                $newProduct->total_stock = $newProduct->variants->sum('stock');
            } else {
                $newProduct->price_range = number_format($newProduct->base_price,  0, ',', '.') . '₫';
                $newProduct->total_stock = $newProduct->store_quantity;
            }
        }
        $breadcrumbs = Breadcrumbs::generate('blog.index');
        $postnews = Posts::with('author', 'category')
            ->latest()
            ->take(3)
            ->get();
        $postOsutstandings = Posts::with('author', 'category')
            ->latest()
            ->take(5)
            ->get();
        $productsnews = Product::latest('created_at')
            ->take(5)
            ->get();
        $categories = PostCategory::all();
        $posts = Posts::with('author', 'category')->get();
        return view('pages.client.blog', [
            'title' => 'Bài viết',
            'posts' => $posts,
            'postnews' => $postnews,
            'postsOutstandings' => $postOsutstandings,
            'productsnews' => $productsnews,
            'categories' => $categories,
            'newProducts' => $newProducts,
            'breadcrumbs' => $breadcrumbs
        ]);
    }
    public function show($id)
    {
        $post = Posts::with('author', 'category')->find($id);
        return view('pages.client.blogDetail', [
            'title' => 'Chi tiết bài viết',
            'post' => $post,
        ]);
    }



    public function showByCategory($slug)
    {
        $newProducts = Product::where('status', 1)->latest()->take(8)->get();
        foreach ($newProducts as $newProduct) {
            if ($newProduct->has_variants) {
                $prices = $newProduct->variants->pluck('price')->toArray();
                if (count($prices) == 1) {
                    $newProduct->price_range = number_format($prices[0],  0, ',', '.') . '₫';
                } elseif (count($prices) > 1) {
                    $newProduct->price_range = number_format(min($prices), 0, ',', '.') . ' - ' . number_format(max($prices),  0, ',', '.') . '₫';
                }
                $newProduct->total_stock = $newProduct->variants->sum('stock');
            } else {
                $newProduct->price_range = number_format($newProduct->base_price,  0, ',', '.') . '₫';
                $newProduct->total_stock = $newProduct->store_quantity;
            }
        }
        $breadcrumbs = Breadcrumbs::generate('blog.index');

        $productsnews = Product::latest('created_at')
            ->take(5)
            ->get();
        $category = PostCategory::where('slug', $slug)->first();
        if ($category) {
            $postnews = Posts::where('post_category_id', $category->id)->with('author', 'category')
                ->latest()
                ->take(3)
                ->get();
            $categories = PostCategory::all();
            $posts = Posts::where('post_category_id', $category->id)->with('author', 'category')->get();
            return view('pages.client.blog', [
                'title' => 'Bài viết',
                'posts' => $posts,
                'postnews' => $postnews,
                'productsnews' => $productsnews,
                'categories' => $categories,
                'newProducts' => $newProducts,
                'breadcrumbs' => $breadcrumbs
            ]);
        } else {
            // Xử lý trường hợp không tìm thấy category
        }
    }
}
