<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Auth::user()->cartItems()->with('product')->get();
        
        $items = $cartItems->map(function ($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'product_image' => $item->product->image_url,
                'quantity' => $item->quantity,
                'price' => $item->price_at_added,
                'subtotal' => $item->subtotal,
            ];
        });

        $total = $cartItems->sum('subtotal');

        return response()->json([
            'success' => true,
            'message' => 'Keranjang belanja',
            'data' => [
                'items' => $items,
                'total' => $total,
            ]
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::find($request->product_id);

        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi',
                'errors' => ['quantity' => ['Stok hanya tersedia ' . $product->stock . ' unit']]
            ], 422);
        }

        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price_at_added' => $product->price,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk ditambahkan ke keranjang',
            'data' => null
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $cartItem = CartItem::find($id);

        if (!$cartItem || $cartItem->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan'
            ], 404);
        }

        $validator = \Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1|max:' . $cartItem->product->stock,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json([
            'success' => true,
            'message' => 'Keranjang diperbarui',
            'data' => null
        ], 200);
    }

    public function destroy($id)
    {
        $cartItem = CartItem::find($id);

        if (!$cartItem || $cartItem->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan'
            ], 404);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item dihapus dari keranjang',
            'data' => null
        ], 200);
    }
}