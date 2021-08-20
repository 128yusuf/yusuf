<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use App\Traits\CustomTraits;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ProductController extends Controller
{
    use CustomTraits;
    const SUCCESS_CODE = 200;
    const ERROR_CODE = 400;

    public function index() {
        $products = Product::active()->paginate(10);
        return view('user.product.index', ['data' => $products]);
    }

    public function detail($id) {
        $product = Product::findOrFail($id);
        return view('user.product.detail', ['data' => $product]);
    }

    public function fromCartPage() {
        $cart = session()->get('cart');
        $cart[request()->id] = Product::getSingleCartArray(request()->id,request()->price,request()->quantity);
        session()->put('cart', $cart);
        return $this->cartResponse();
    }
    public function addToCart(Request $request) {

        if($request->fromCartPage)
            return  $this->fromCartPage();

        if(session()->exists('cart')) {
            $cart = session()->get('cart');

            if(isset($cart[$request->id])) {
                $currentCartProduct = $cart[$request->id];
                $quantity = $currentCartProduct['quantity'] + $request->quantity;
                $cart[$request->id] = Product::getSingleCartArray($request->id,$request->price,$quantity);

            }else {
                $cart[$request->id] = Product::getSingleCartArray($request->id,$request->price,$request->quantity);
            }
            session()->put('cart', $cart);
        }else {
            $productData = [
                $request->id => Product::getSingleCartArray($request->id,$request->price,$request->quantity)
            ];
            session()->put('cart', $productData);
        }

        return $this->cartResponse();
    }

    protected function cartResponse() {
        return response()->json(
            [ 'code' => self::SUCCESS_CODE, 'msg' => 'Add To Cart Successfully', 'data' => ['totalItems' => count(session()->get('cart'))] ]
        );
    }

    public function cart() {
        if(request()->ajax()) {
            $ids = [];
            if(session()->has('cart'))
                $ids = array_keys(session()->get('cart'));

            $products = Product::whereIn('id',$ids)->get();
            $view =  view('user.product.cart_items', ['data' => $products])->render();

            return response()->json( [ 'code' => self::SUCCESS_CODE, 'data' => $view] );
        }

        return view('user.product.cart');
    }

    public function removeFromCart(Request $request) {
        try {
            $cart = session()->get('cart');
            unset($cart[$request->id]);
            session()->put('cart',$cart);

            $totalItems = count(session()->get('cart'));
            return response()->json(
                [ 'code' => self::SUCCESS_CODE, 'data' => ['totalItems' => $totalItems] ]
            );

        } catch(\Exception $e) {
            return response()->json(
                [ 'code' => self::ERROR_CODE, 'data' => ['totalItems' => $totalItems] ]
            );
        }

    }

    public function checkOut(Request $request) {

        if(!session()->has('cart'))
            return response()->json([ 'code' => self::ERROR_CODE, 'data' => '', 'msg' => trans('messages.something_went_wrong')]);

        $cart = session()->get('cart');

        $userId = Auth::user()->id;
        $orderArray = [];
        $totalPrice = 0;
        foreach ($cart as $key => $value) {
            $orderArray[] = [
                'user_id' => $userId,
                'product_id' => $value['id'],
                'quantity' => $value['quantity'],
                'price' => $value['total']
            ];
            $totalPrice += $value['total'];
        }

        Order::insert($orderArray);
        $data['orderNumber'] = Order::getOrderNumber();
        $data['datePurchased'] = Carbon::now()->format('F d Y');
        $data['totalPrice'] = CustomTraits::getPriceWithCurrency($totalPrice);

        $view =  view('user.product.checkout', ['data' => $data])->render();
        session()->forget('cart');
        return response()->json( [ 'code' => self::SUCCESS_CODE, 'data' => $view] );
    }
}
