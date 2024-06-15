<?php

namespace App\Http\Controllers;

use App\Enums\CartStatusEnum;
use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Requests\Cart\CartIdRequest;
use App\Http\Requests\Cart\CartProductIdRequest;
use App\Http\Resources\Cart\ShowCartResource;
use App\Http\Resources\Cart\ShowOneCartProductResource;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Repositories\PublicRepository;
use App\Services\CartPriceService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CartController extends Controller
{
    public function __construct(public PublicRepository $repository, public CartPriceService $cartPriceService)
    {
    }

    public function AddToCart(AddToCartRequest $request)
    {
        $arr = Arr::only($request->validated(),
            ['product_id', 'quantity_id', 'custom_quantity', 'bindery_att', 'normal_att', 'work_days_id']);
        $arr['user_id'] = \auth('User')->user()->id;
        $price = $this->cartPriceService->CalculatePrice($arr);
        return \Success(__('public.add_to_cart'));

    }

    public function DeleteFromCart(CartProductIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['cartProductId']);
        $CartProduct = $this->repository->ShowById(CartProduct::class, $arr['cartProductId']);
        $cart = $CartProduct->Cart;
        $cart->decrement('cart_price', $CartProduct->final_price);
        $CartProduct->delete();
        return \Success(__('public.delete_form_cart'));
    }

    public function DeleteAllFromCart(CartIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['cartId']);
        $this->repository->ShowAll(CartProduct::class, ['cart_id' => $arr['cartId']])->delete();
        $this->repository->Update(Cart::class, $arr['cartId'], ['cart_price' => 0]);
        return \Success(__('public.delete_form_cart'));
    }

    public function ShowCart(){
        $userId = \auth('User')->user()->id;
        $cart = $this->repository->ShowAll(Cart::class,[
            'user_id' => $userId,
            'status'=>CartStatusEnum::Initial])->first();
        if(!$cart){
        $cart = new Cart();
        $cart->id = 'undefined';
        $cart->cart_price = 0;
         }
       return \SuccessData(__('public.cart_found'),new ShowCartResource($cart));

    }

    public function ShowCartProduct(CartProductIdRequest $request){
        $arr = Arr::only($request->validated(), ['cartProductId']);
        $CartProduct = $this->repository->ShowById(CartProduct::class, $arr['cartProductId']);
        return \SuccessData(__('public.cart_found'),new ShowOneCartProductResource($CartProduct));



    }
}
