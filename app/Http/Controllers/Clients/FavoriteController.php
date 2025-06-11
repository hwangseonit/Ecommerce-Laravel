<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;
use Illuminate\Support\Facades\Log;

class FavoriteController extends Controller
{
    public function add($productId)
    {
        try {
            // Kiểm tra xem sản phẩm đã có trong danh sách yêu thích chưa
            $favorite = Favorite::where('user_id', auth()->id())
                ->where('product_id', $productId)
                ->first();

            if ($favorite) {
                return redirect()->back()->with('message', 'Sản phẩm đã có trong danh sách yêu thích');
            }

            // Thêm sản phẩm vào danh sách yêu thích
            Favorite::create([
                'user_id' => auth()->id(),
                'product_id' => $productId
            ]);

            return redirect()->back()->with('message', 'Đã thêm vào danh sách yêu thích');
        } catch (\Exception $e) {
            Log::error('Error adding to favorites: ' . $e->getMessage(), [
                'product_id' => $productId,
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Đã xảy ra lỗi, vui lòng thử lại sau.');
        }
    }

    public function index()
    {
        try {
            $title = "Danh sách yêu thích";
            $favorites = Favorite::with('product')
                ->where('user_id', auth()->id())
                ->get();

            return view('pages.client.favorites', compact('favorites','title'));
        } catch (\Exception $e) {
            Log::error('Error fetching favorites: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Đã xảy ra lỗi, vui lòng thử lại sau.');
        }
    }

    public function remove($id)
    {
        try {
            $favorite = Favorite::where('user_id', auth()->id())
                ->where('product_id', $id)
                ->first();

            if ($favorite) {
                $favorite->delete();
                return response()->json(['success' => 'Sản phẩm đã được xóa khỏi yêu thích.']);
            }
            return response()->json(['error' => 'Không tìm thấy sản phẩm trong yêu thích.'], 404);
        } catch (\Exception $e) {
            Log::error('Error removing from favorites: ' . $e->getMessage(), [
                'product_id' => $id,
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau.']);
        }
    }
}
