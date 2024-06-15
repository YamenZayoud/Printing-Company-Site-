<?php

namespace App\Http\Controllers;

use App\Enums\CartStatusEnum;
use App\Http\Requests\Cart\CartProductIdRequest;
use App\Http\Requests\Quote\AddQuoteRequest;
use App\Http\Requests\Quote\ChangeQuoteStatusRequest;
use App\Http\Requests\Quote\ShowQuoteIdRequest;
use App\Http\Requests\Quote\ShowQuotesRequest;
use App\Http\Resources\Quote\ShowOneQuoteResource;
use App\Http\Resources\Quote\ShowQuotesResource;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\CartProductBinderyOption;
use App\Models\CartProductNormalOption;
use App\Models\Quote;
use App\Repositories\PublicRepository;
use App\Services\QuotePriceService;
use Illuminate\Cache\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class QuoteController extends Controller
{

    public function __construct(public PublicRepository $repository, public QuotePriceService $cartPriceService)
    {
    }

    public function Create(AddQuoteRequest $request)
    {

        $arr = Arr::only($request->validated(), ['product_id', 'quantity_id', 'custom_quantity', 'bindery_att', 'normal_att', 'work_days_id']);
        $arr['user_id'] = \auth('User')->user()->id;
        $this->cartPriceService->CalculatePrice($arr);
        return \Success(__('public.quote_create'));
    }

    public function ShowAll(ShowQuotesRequest $request)
    {
        $arr = Arr::only($request->validated(), ['userId', 'status']);
        $where = [];
        $perPage = \returnPerPage();
        if (\array_key_exists('userId', $arr)) {
            $where['user_id'] = $arr['userId'];
        }
        if (\array_key_exists('status', $arr)) {
            $where['status'] = $arr['status'];
        }

        $quotes = $this->repository->ShowAll(Quote::class, $where)->paginate($perPage);
        ShowQuotesResource::collection($quotes);
        return \Pagination($quotes);

    }

    public function ShowById(ShowQuoteIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['quoteId']);
        $quote = $this->repository->ShowById(Quote::class, $arr['quoteId']);
        return \SuccessData(__('public.quote_found'), new ShowOneQuoteResource($quote));
    }

    public function ChangeQuoteStatus(ChangeQuoteStatusRequest $request)
    {
        $arr = Arr::only($request->validated(), ['quoteId', 'status']);
        $this->repository->Update(Quote::class, $arr['quoteId'], $arr);
        return \Success(__('public.quote_update'));


    }
}
