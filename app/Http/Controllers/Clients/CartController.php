<?php
namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $variant_id = $request->input('variant_id');
        $quantity = $request->input('quantity');
        $product_id = $request->input('product_id');

        // Kiểm tra tồn kho
        $variant = ProductVariant::find($variant_id);
        if ($variant && $quantity > $variant->stock) {
            return redirect()->back()->withErrors(['quantity' => 'Số lượng mua vượt quá số lượng tồn kho.']);
        }
        // Tìm hoặc tạo giỏ hàng
        $cart = Cart::firstOrCreate(
            ['user_id' => auth()->id(), 'status' => 'active'],
            ['user_id' => auth()->id(), 'status' => 'active']
        );
        // Tìm sản phẩm trong giỏ hàng
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product_id)
            ->where('variant_id', $variant_id)
            ->first();
        if ($cartItem) {
            // Cập nhật số lượng nếu sản phẩm đã tồn tại
            $newQuantity = $cartItem->quantity + $quantity;
            // Kiểm tra lại tồn kho
            if ($variant && $newQuantity > $variant->stock) {
                return redirect()->back()->withErrors(['quantity' => 'Số lượng mua vượt quá số lượng tồn kho.']);
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Thêm mới sản phẩm vào giỏ hàng nếu chưa tồn tại
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product_id,
                'variant_id' => $variant_id,
                'quantity' => $quantity,
                'price' => $request->input('price'),
            ]);
        }

        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }

    public function index()
    {
        $cart = Cart::with(['items.product', 'items.variant.attributes.attribute'])
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();
    
        return view('pages.client.cart', [
            'title' => 'Giỏ hàng',
            'cart' => $cart,
        ]);
    }
    

    public function remove($id)
    {
        $cartItem = CartItem::find($id);
        if ($cartItem) {
            $cartItem->delete();
            return response()->json(['success' => 'Sản phẩm đã được xóa khỏi giỏ hàng.']);
        }

        return response()->json(['error' => 'Không tìm thấy sản phẩm trong giỏ hàng.'], 404);
    }

    public function update(Request $request)
    {
        $items = $request->input('items');

        foreach ($items as $itemId => $quantity) {
            $cartItem = CartItem::find($itemId);
            if ($cartItem) {
                $variant = ProductVariant::find($cartItem->variant_id);
                if ($variant && $quantity > $variant->stock) {
                    return redirect()->back()->withErrors(['quantity' => 'Số lượng mua vượt quá số lượng tồn kho.']);
                }
                $cartItem->update(['quantity' => $quantity]);
            }
        }

        return redirect()->back()->with('success', 'Giỏ hàng đã được cập nhật.');
    }
}
