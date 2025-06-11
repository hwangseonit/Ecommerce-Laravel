<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Product;
use App\Models\ProductCategory;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy tất cả các danh mục sản phẩm có status = 1
        $categories = ProductCategory::where('status', 1)->get();

        // Lấy sản phẩm theo danh mục và xử lý giá và tồn kho
        $categoryProducts = [];
        foreach ($categories as $category) {
            $products = Product::where('category_id', $category->id)->where('status', 1)->get();
            foreach ($products as $product) {
                $this->processProductPricingAndStock($product);
            }
            $categoryProducts[$category->category_name] = $products;
        }

        // Lấy tất cả sản phẩm có trạng thái 1
        $allProducts = Product::where('status', 1)->get();

        // Lấy sản phẩm mới nhất, hot nhất, giảm giá, và được xem nhiều nhất
        $newProducts = Product::where('status', 1)->latest()->take(8)->get();
        $hotProducts = Product::where('is_hot', true)->where('status', 1)->take(8)->get();
        $discountedProducts = Product::where('status', 1)->whereHas('discounts', function ($query) {
            $query->where('start_date', '<=', now())->where('end_date', '>=', now());
        })->take(8)->get();
        $mostViewedProducts = Product::where('status', 1)->orderBy('is_most_viewed', 'desc')->take(8)->get();

        // Xử lý giá và tồn kho cho các danh mục sản phẩm đặc biệt
        foreach ([$newProducts, $hotProducts, $discountedProducts, $mostViewedProducts, $allProducts] as $products) {
            foreach ($products as $product) {
                $this->processProductPricingAndStock($product);
            }
        }

        // Lấy banner và breadcrumbs
        $breadcrumbs = Breadcrumbs::generate('home.index');
        $banners = Banner::where('status', 1)->get();

        return view('pages.client.home', [
            'title' => 'FPT Shop Điện Thoại Chính hãng',
            'banners' => $banners,
            'breadcrumbs' => $breadcrumbs,
            'newProducts' => $newProducts,
            'hotProducts' => $hotProducts,
            'discountedProducts' => $discountedProducts,
            'mostViewedProducts' => $mostViewedProducts,
            'categories' => $categories,
            'categoryProducts' => $categoryProducts,
            'allProducts' => $allProducts,
        ]);
    }

    private function processProductPricingAndStock($product)
    {
        $discount = $product->discounts()
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
    
        $product->discount_percentage = '';
    
        if ($product->has_variants) {
            $prices = $product->variants->map(function ($variant) use ($discount, &$product) {
                $original_price = $variant->price;
                $discounted_price = $original_price;
    
                if ($discount) {
                    if ($discount->discount_percentage) {
                        $discounted_price = $original_price * (1 - $discount->discount_percentage / 100);
                        $product->discount_percentage = $discount->discount_percentage;
                    } 
                }
    
                $variant->discounted_price = $discounted_price;
                return $discounted_price;
            })->toArray();
    
            if (count($prices) == 1) {
                $product->price_range = number_format($prices[0], 0, ',', '.') . '₫';
            } elseif (count($prices) > 1) {
                $product->price_range = number_format(min($prices), 0, ',', '.') . ' - ' . number_format(max($prices), 0, ',', '.') . '₫';
            }
            $product->total_stock = $product->variants->sum('stock');
        } else {
            $original_price = $product->base_price;
            $discounted_price = $original_price;
    
            if ($discount) {
                if ($discount->discount_percentage) {
                    $discounted_price = $original_price * (1 - $discount->discount_percentage / 100);
                    $product->discount_percentage = $discount->discount_percentage;
                }
                $product->old_price = $original_price;
            }
    
            $product->price_range = number_format($discounted_price, 0, ',', '.') . '₫';
            $product->total_stock = $product->store_quantity;
        }
    }
    
}
