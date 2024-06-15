<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tag\ProductIdRequest;
use App\Http\Requests\Tag\ProductTagIdRequest;
use App\Http\Requests\Tag\TagIdRequest;
use App\Http\Resources\Tags\ProductTagResource;
use App\Http\Resources\Tags\TagResource;
use App\Models\ProductTag;
use App\Repositories\PublicRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProductTagController extends Controller
{
    public function __construct(public PublicRepository $publicRepository)
    {
    }
    /**
     * show all products with has the same tag
     */
    public function showWithTagId(TagIdRequest $request)
    {
        $perPage = \returnPerPage();
        $arr = Arr::only($request->validated(), ['tagId']);
        $where = ['tag_id' => $arr['tagId']];
        $products = $this->publicRepository->ShowAll(ProductTag::class, $where)->paginate($perPage);
        $products = TagResource::collection($products);
        return \Pagination($products);
    }

    /**
     * show all products with has the same tag
     */
    public function showWithProductId(ProductIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['productId']);
        $where = ['product_id' => $arr['productId']];
        $tag = $this->publicRepository->ShowAll(ProductTag::class, $where)->get();
        return \SuccessData(__('public.Show'), ProductTagResource::collection($tag));
    }


    public function destroy(ProductTagIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['productTagId']);
        $this->publicRepository->DeleteById(ProductTag::class, $arr['productTagId']);
        return \Success(__('public.Delete'));
    }
}
