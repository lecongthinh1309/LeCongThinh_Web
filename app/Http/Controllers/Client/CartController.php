<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('client.cart.index', compact('cart'));
    }

    // Thêm sản phẩm vào giỏ hàng
    public function add(Request $request)
    {
        $productId = $request->product_id;
        $quantity  = $request->quantity ?? 1;

        $product = Product::findOrFail($productId);

        $cart = session()->get('cart', []);

        $price = $product->pricediscount > 0 ? $product->pricediscount : $product->price;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'product_id' => $product->id,
                'name'       => $product->productname,
                'image'      => $product->image,
                'price'      => $price,
                'quantity'   => $quantity,
                'slug'       => $product->slug,
            ];
        }

        session()->put('cart', $cart);

        $cartCount = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'success'    => true,
            'message'    => 'Đã thêm vào giỏ hàng!',
            'cart_count' => $cartCount,
        ]);
    }

    // Cập nhật số lượng
    public function update(Request $request)
    {
        $productId = $request->product_id;
        $quantity  = (int) $request->quantity;

        $cart = session()->get('cart', []);

        if ($quantity <= 0) {
            unset($cart[$productId]);
        } elseif (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
        }

        session()->put('cart', $cart);

        $total = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart));
        $cartCount = array_sum(array_column($cart, 'quantity'));

        return response()->json(['success' => true, 'total' => $total, 'cart_count' => $cartCount]);
    }

    // Xóa một sản phẩm khỏi giỏ
    public function remove(Request $request)
    {
        $productId = $request->product_id;
        $cart = session()->get('cart', []);
        unset($cart[$productId]);
        session()->put('cart', $cart);

        $cartCount = array_sum(array_column($cart, 'quantity'));

        return response()->json(['success' => true, 'cart_count' => $cartCount]);
    }

    // Trang thanh toán
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }
        return view('client.cart.checkout', compact('cart'));
    }

    // Xử lý đặt hàng
    public function placeOrder(Request $request)
    {
        $request->validate([
            'fullname' => 'required|max:100',
            'email'    => 'required|email|max:100',
            'phone'    => 'required|max:20',
            'address'  => 'required|max:255',
        ], [
            'required' => ':attribute không được để trống',
            'email'    => ':attribute không đúng định dạng',
        ], [
            'fullname' => 'Họ tên',
            'email'    => 'Email',
            'phone'    => 'Số điện thoại',
            'address'  => 'Địa chỉ',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        // Lưu khách hàng
        $customer = Customer::create([
            'fullname' => $request->fullname,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'address'  => $request->address,
        ]);

        // Tính tổng tiền
        $total = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart));

        // Lưu đơn hàng
        $order = Order::create([
            'customer_id' => $customer->id,
            'total_price' => $total,
            'status'      => 0,
            'note'        => $request->note,
        ]);

        // Lưu chi tiết đơn hàng
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
            ]);
        }

        // Xóa giỏ hàng
        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Đặt hàng thành công! Cảm ơn bạn đã mua hàng.');
    }
}
