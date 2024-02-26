<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use App\Producto;

class CartController extends Controller
{
    public function __construct(Producto $productos)
    {
        $this->productos = $productos;
    }

    public function cart() {
        $cart = Cart::getContent();
        $carrito['count'] = 0;
        $carrito['total'] = 0;

        foreach($cart as $producto) {
            $carrito['productos'][] = [
                'id' => $producto->id,
                'name' => $producto->name,
                'price' => $producto->price,
                'quantity' => $producto->quantity,
                'image' => $this->productos->where('id', $producto->id)->value('image')
            ];
            $carrito['count']++;
            $carrito['total'] += $producto->price * $producto->quantity;
        }

        return $carrito;
    }

    public function index()
    {
        $carrito = $this->cart();
        $productos = $this->productos->get();
        foreach($productos as $producto) {
            $images[$producto->id] = $producto->image;
        }

        $cart = Cart::getContent();
        return view('templates.carrito')->with([
            'cart' => $cart,
            'carrito' => $carrito,
            'images' => $images
        ]);
    }

    public function add(Request $request) {
        Cart::add([
            [
                'id' => $request->input('id'),
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'quantity' => $request->input('quantity'),
                'attributes' => array()
            ]
        ]);

    }

    public function update(Request $request) {
        Cart::remove($request->input('id'));
        Cart::add([
            [
                'id' => $request->input('id'),
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'quantity' => $request->input('quantity'),
                'attributes' => array()
            ]
        ]);
    }

    public function remove(Request $request) {
        Cart::remove($request->input('id'));
    }
}
