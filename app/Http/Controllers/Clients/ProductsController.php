<?php
namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Sản phẩm';
        $categories = ProductCategory::all();
        $mostViewedProducts = Product::where('status', 1)->orderBy('is_most_viewed', 'desc')->take(5)->get();

        $search = $request->input('search');
        if ($search) {
            $products = Product::where('name', 'like', '%' . $search . '%')
                ->orWhereHas('category', function ($query) use ($search) {
                    $query->where('category_name', 'like', '%' . $search . '%');
                })
                ->paginate(9);
        } else {
            $products = Product::paginate(9);
        }

        $this->processProductData($mostViewedProducts);
        $this->processProductData($products);

        return view('pages.client.products', compact('categories', 'products', 'mostViewedProducts', 'title'));
    }

    public function productByCategory($slug = null)
    {
        $title = 'Sản phẩm | KhanhUD Mobile';
        $categories = ProductCategory::all();
        $mostViewedProducts = Product::where('status', 1)->orderBy('is_most_viewed', 'desc')->take(5)->get();

        if ($slug) {
            $category = ProductCategory::where('slug', $slug)->firstOrFail();
            $products = Product::where('category_id', $category->id)->paginate(9);
        } else {
            $products = Product::paginate(9);
        }

        $this->processProductData($mostViewedProducts);
        $this->processProductData($products);

        return view('pages.client.products', compact('categories', 'products', 'mostViewedProducts', 'title'));
    }

    private function processProductData($products)
    {
        foreach ($products as $product) {
            $this->processProductPricingAndStock($product);
        }
    }

    public function show($id)
    {
        $postnews = Posts::with('author', 'category')
            ->latest()
            ->take(5)
            ->get();
        $product = Product::with(['variants.attributes.attribute', 'category'])->findOrFail($id);
        $subImagePaths = json_decode($product->sub_images_urls, true);

        // Tăng giá trị is_most_viewed
        $product->increment('is_most_viewed');

        $this->processProductPricingAndStock($product);

        // Lấy danh sách sản phẩm liên quan
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->take(8)
            ->get();

        return view('pages.client.productDetail', [
            'title' => 'Chi tiết sản phẩm',
            'product' => $product,
            'postnews' => $postnews,
            'variations' => $product->variants,
            'subImagePaths' => $subImagePaths,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    private function processProductPricingAndStock($product)
    {
        $discount = $product->discounts()
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
    
        if ($product->has_variants) {
            $prices = $product->variants->map(function ($variant) use ($discount) {
                $original_price = $variant->price;
                if ($discount) {
                    if ($discount->discount_percentage) {
                        $discounted_price = $original_price * (1 - $discount->discount_percentage / 100);
                    } elseif ($discount->discount_amount) {
                        $discounted_price = $original_price - $discount->discount_amount;
                    }
                } else {
                    $discounted_price = $original_price;
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
            if ($discount) {
                if ($discount->discount_percentage) {
                    $discounted_price = $original_price * (1 - $discount->discount_percentage / 100);
                } elseif ($discount->discount_amount) {
                    $discounted_price = $original_price - $discount->discount_amount;
                }
                $product->old_price = $original_price;
                $product->price_range = number_format($discounted_price, 0, ',', '.') . '₫';
            } else {
                $product->price_range = number_format($original_price, 0, ',', '.') . '₫';
            }
            $product->total_stock = $product->store_quantity;
        }
    }
}