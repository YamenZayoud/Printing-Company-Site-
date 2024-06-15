<?php

namespace App\Http\Controllers;

use App\Http\Requests\Rating\RatingRequest;
use App\Models\Rating;
use App\Repositories\PublicRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class RatingController extends Controller
{
    public function __construct(public PublicRepository $publicRepository)
    {
    }

    public function create(RatingRequest $request)
    {
        $arr = Arr::only($request->validated(), ['product_id', 'rating']);
        $arr['user_id'] = \auth('User')->user()->id;
        $this->publicRepository->Create(Rating::class, $arr);
        return \Success(__('public.Add'));
    }

}
