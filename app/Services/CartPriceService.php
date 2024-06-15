<?php

namespace App\Services;

use App\Enums\AttributeTypeEnum;
use App\Enums\CartStatusEnum;
use App\Enums\PriceTypeEnum;
use App\Models\BinderyAttributeOption;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\CartProductBinderyOption;
use App\Models\CartProductNormalOption;
use App\Models\NormalAttributeOption;
use App\Models\ProductQuantity;
use App\Models\Setting;
use App\Repositories\PublicRepository;

class CartPriceService
{

    public function __construct(public PublicRepository $repository)
    {
    }


    public function CalculatePrice($arr)
    {
        // if Custom Quantity Exists
        if (!\array_key_exists('quantity_id', $arr)) {
            $where = [
                'product_id' => $arr['product_id'],
                ['custom_quantity', '>=', $arr['custom_quantity']],
                ['custom_quantity', '<=', $arr['custom_quantity']],
            ];
            $quantityRow = $this->repository->ShowAll(ProductQuantity::class, $where)->first();
            $arr['quantity_id'] = $quantityRow->id;

        } // if quantity id Exists
        else {
            $quantityRow = $this->repository->ShowById(ProductQuantity::class, $arr['quantity_id']);
            $arr['custom_quantity'] = $quantityRow->range_to;
        }
        $quantity = $arr['custom_quantity'];

        // Start Price
        $arr['cart_price'] = 0;
        $cart = Cart::where(['user_id' => $arr['user_id'],
            'status' => CartStatusEnum::Initial,
        ])->first();
        if(!$cart){
            $cart = $this->repository->Create(Cart::class,$arr);
        }
        $arr['cart_id'] = $cart->id;
        $arr['final_price'] = $quantity * $quantityRow->price_per_unit;
        $cartProduct = $this->repository->Create(CartProduct::class, $arr);
        // Add Options And Calculate Price

        $arr['final_price'] = $this->AddQuoteBinderyOptions($cartProduct->id, $arr['bindery_att'], $quantity, $arr['final_price']);
        // Add Options And Calculate Price
        $arr['final_price'] = $this->AddQuoteNormalOptions($cartProduct->id, $arr['normal_att'], $quantity, $arr['final_price']);
        // Add Work Days And Calculate Price
        $work = $this->repository->ShowById(Setting::class, $arr['work_days_id']);
        $arr['final_price'] += ($arr['final_price'] * (double)$work->value);
        $this->repository->Update(CartProduct::class, $cartProduct->id, ['final_price' => $arr['final_price']]);
        $cart->increment('cart_price',$arr['final_price']);
        return $arr['final_price'];
    }

    private function AddQuoteBinderyOptions($CartProductId, $bindery_atts, $quantity, $final_price)
    {
        foreach ($bindery_atts as $bindery_att) {

            $cart_option = CartProductBinderyOption::create([
                'cart_product_id' => $CartProductId,
                'bindery_option_id' => $bindery_att['att_option'],
                'value' => $bindery_att['value'] ?? null,
            ]);

            $binderOption = $this->repository->ShowById(BinderyAttributeOption::class, $bindery_att['att_option']);
            $binderyAttribute = $binderOption->BinderyAttribute;
            // check if Attribute Is Text Box
            if ($binderyAttribute->attribute_type == AttributeTypeEnum::TextInput) {
                $final_price += $binderOption->price_per_unit * $quantity * $cart_option->value;
            } else {
                $final_price += $binderOption->setup_price + (($binderOption->price_per_unit + ($binderOption->markup * $binderOption->price_per_unit)) * $quantity);
            }
        }

        return $final_price;
    }

    private function AddQuoteNormalOptions($CartProductId, $normal_atts, $quantity, $final_price)
    {
        foreach ($normal_atts as $normal_att) {

            $cart_option = CartProductNormalOption::create([
                'cart_product_id' => $CartProductId,
                'normal_option_id' => $normal_att['att_option'],
                'value' => $normal_att['value'] ?? null,
            ]);

            $normalOption = $this->repository->ShowById(NormalAttributeOption::class, $normal_att['att_option']);
            $normalAttribute = $normalOption->NormalAttribute;
            // check if Attribute Is Text Box And Check If Flat Price Or Formula
            if ($normalAttribute->attribute_type == AttributeTypeEnum::TextInput) {
                if ($normalOption->price_type == PriceTypeEnum::FlatPrice) {
                    $final_price += $normalOption->flat_price * $quantity * $cart_option->value;
                }
            } else {
                if ($normalOption->price_type == PriceTypeEnum::FlatPrice) {
                    $final_price += $normalOption->flat_price * $quantity;
                }

            }
        }
        return $final_price;
    }

}
