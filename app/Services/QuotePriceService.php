<?php

namespace App\Services;

use App\Enums\AttributeTypeEnum;
use App\Enums\PriceTypeEnum;
use App\Models\BinderyAttributeOption;
use App\Models\NormalAttributeOption;
use App\Models\ProductQuantity;
use App\Models\Quote;
use App\Models\QuoteBinderyOption;
use App\Models\QuoteNormalOption;
use App\Models\Setting;
use App\Repositories\PublicRepository;

class QuotePriceService
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
        $arr['quote_price'] = $quantity * $quantityRow->price_per_unit;
        $quote = $this->repository->Create(Quote::class, $arr);
        // Add Options And Calculate Price
        $arr['quote_price'] = $this->AddQuoteBinderyOptions($quote->id, $arr['bindery_att'], $quantity, $arr['quote_price']);
        // Add Options And Calculate Price
        $arr['quote_price'] = $this->AddQuoteNormalOptions($quote->id, $arr['normal_att'], $quantity, $arr['quote_price']);
        // Add Work Days And Calculate Price
        $work = $this->repository->ShowById(Setting::class, $arr['work_days_id']);
        $arr['quote_price'] += ($arr['quote_price'] * (double)$work->value);
        $this->repository->Update(Quote::class, $quote->id, ['quote_price' => $arr['quote_price']]);
        return $arr['quote_price'];
    }

    private function AddQuoteBinderyOptions($quote_id, $bindery_atts, $quantity, $quote_price)
    {
        foreach ($bindery_atts as $bindery_att) {

            $quote_option = QuoteBinderyOption::create([
                'quote_id' => $quote_id,
                'bindery_option_id' => $bindery_att['att_option'],
                'value' => $bindery_att['value'] ?? null,
            ]);

            $binderOption = $this->repository->ShowById(BinderyAttributeOption::class, $bindery_att['att_option']);
            $binderyAttribute = $binderOption->BinderyAttribute;
            // check if Attribute Is Text Box
            if ($binderyAttribute->attribute_type == AttributeTypeEnum::TextInput) {
                $quote_price += $binderOption->price_per_unit * $quantity * $quote_option->value;
            } else {
                $quote_price += $binderOption->setup_price + (($binderOption->price_per_unit + ($binderOption->markup * $binderOption->price_per_unit)) * $quantity);
            }
        }

        return $quote_price;
    }

    private function AddQuoteNormalOptions($quote_id, $normal_atts, $quantity, $quote_price)
    {
        foreach ($normal_atts as $normal_att) {

            $quote_option = QuoteNormalOption::create([
                'quote_id' => $quote_id,
                'normal_option_id' => $normal_att['att_option'],
                'value' => $normal_att['value'] ?? null,
            ]);

            $normalOption = $this->repository->ShowById(NormalAttributeOption::class, $normal_att['att_option']);
            $normalAttribute = $normalOption->NormalAttribute;
            // check if Attribute Is Text Box And Check If Flat Price Or Formula
            if ($normalAttribute->attribute_type == AttributeTypeEnum::TextInput) {
                if ($normalOption->price_type == PriceTypeEnum::FlatPrice) {
                    $quote_price += $normalOption->flat_price * $quantity * $quote_option->value;
                }
            } else {
                if ($normalOption->price_type == PriceTypeEnum::FlatPrice) {
                    $quote_price += $normalOption->flat_price * $quantity;
                }

            }
        }
        return $quote_price;
    }


}
