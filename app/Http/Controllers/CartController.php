<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class CartController extends Controller
{
    /**
     * Get cart contents and count
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'];
        }
        
        return view('frontend.cart.index', compact('cart', 'total'));
    }

    /**
     * Show checkout page
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (count($cart) == 0) {
            return redirect()->route('lab-test')->with('error', 'Your cart is empty');
        }

        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'];
        }

        $branches = \App\Models\Branch::all();
        
        return view('frontend.cart.checkout', compact('cart', 'total', 'branches'));
    }

    /**
     * Add item to cart via AJAX
     */
    public function add(Request $request)
    {
        $serviceId = $request->service_id;
        $service = Service::with('components')->find($serviceId);

        if (!$service) {
            return response()->json(['error' => 'Service not found'], 404);
        }

        $cart = session()->get('cart', []);

        // If item already in cart, don't add again
        if (isset($cart[$serviceId])) {
            return response()->json([
                'message' => 'Test already in cart',
                'cart_count' => count($cart)
            ]);
        }

        $components = $service->components->pluck('name')->toArray();

        $cart[$serviceId] = [
            "name" => $service->name,
            "price" => $service->price,
            "category" => $service->category,
            "id" => $service->id,
            "components" => $components
        ];

        session()->put('cart', $cart);

        return response()->json([
            'message' => 'Test added to cart successfully',
            'cart_count' => count($cart)
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request)
    {
        if($request->service_id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->service_id])) {
                unset($cart[$request->service_id]);
                session()->put('cart', $cart);
            }
            return response()->json([
                'message' => 'Item removed',
                'cart_count' => count($cart)
            ]);
        }
    }

    /**
     * Get cart count for header
     */
    public function getCount()
    {
        $cart = session()->get('cart', []);
        return response()->json(['count' => count($cart)]);
    }
}
