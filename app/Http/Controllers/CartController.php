<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Auth::user()->cartItems()->with('product')->get();
        $total = $cartItems->sum('subtotal');
        
        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock,
        ]);

        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price_at_added' => $product->price,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $this->authorize('update', $cartItem);

        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $cartItem->product->stock,
        ]);

        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')->with('success', 'Keranjang diperbarui!');
    }

    public function destroy(CartItem $cartItem)
    {
        $this->authorize('delete', $cartItem);
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item dihapus dari keranjang!');
    }

    public function checkoutForm()
    {
        $cartItems = Auth::user()->cartItems()->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }

        $total = $cartItems->sum('subtotal');
        
        return view('cart.checkout', compact('cartItems', 'total'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:va,qris',
            'shipping_address' => 'required|string',
        ]);

        $cartItems = Auth::user()->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }

        // Cek stok
        foreach ($cartItems as $cartItem) {
            if ($cartItem->quantity > $cartItem->product->stock) {
                return redirect()->route('cart.index')
                    ->with('error', 'Stok ' . $cartItem->product->name . ' tidak mencukupi!');
            }
        }

        // Hitung total
        $total = $cartItems->sum('subtotal');

        // Buat order
        $orderData = [
            'user_id' => Auth::id(),
            'total_amount' => $total,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'shipping_address' => $request->shipping_address,
        ];

        if ($request->payment_method === 'va') {
            $orderData['va_number'] = 'VA' . Str::random(8);
        } elseif ($request->payment_method === 'qris') {
            $qrisPath = Setting::getValue('qris_image_path');
            if ($qrisPath) {
                $orderData['qris_image'] = $qrisPath;
            }
        }

        $order = \App\Models\Order::create($orderData);

        // Buat order items dan kurangi stok
        foreach ($cartItems as $cartItem) {
            $order->items()->create([
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price_at_added,
            ]);

            // Kurangi stok
            $cartItem->product->decrement('stock', $cartItem->quantity);
        }

        // Kosongkan cart
        Auth::user()->cartItems()->delete();

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order berhasil dibuat! Silakan lakukan pembayaran.');
    }
}