<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\AddExtraProductImagesRequest;
use App\Http\Requests\Product\AddProductRequest;
use App\Http\Requests\Product\DeleteProductImageRequest;
use App\Http\Requests\Product\EditProductQuantityRequest;
use App\Http\Requests\Product\EditProductRequest;
use App\Http\Requests\Product\ProductIdRequest;
use App\Http\Resources\Product\ShowOneProductResource;
use App\Http\Resources\Product\ShowProductsResource;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductQuantity;
use App\Repositories\PublicRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProductController extends Controller
{
    public function __construct(public PublicRepository $repository)
    {
    }

    public function Create(AddProductRequest $request)
    {
        $arr = Arr::only($request->validated(), ['category_id', 'name', 'description', 'images', 'quantities']);
        $product = $this->repository->Create(Product::class, $arr);
        $this->AddProductImages($product->id, $arr['images']);
        $this->AddProductQuantities($product->id, $arr['quantities']);
        return \Success(__('public.add_product'));
    }

    private function AddProductImages($id, $images)
    {
        foreach ($images as $image) {
            $path = 'Images/Products/';
            $image = \uploadImage($image, $path);
            ProductImage::create([
                'product_id' => $id,
                'image' => $image,
            ]);
        }
    }

    private function AddProductQuantities($id, $quantities)
    {
        foreach ($quantities as $quantity) {
            ProductQuantity::create([
                'product_id' => $id,
                'range_from' => $quantity['range_from'],
                'range_to' => $quantity['range_to'],
                'price_per_unit' => $quantity['price_per_unit'],
            ]);
        }
    }


    public function ActiveOrNot(ProductIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['productId']);
        $this->repository->ActiveOrNot(Product::class, $arr['productId']);
        return \Success(__('public.active_or_not_product'));
    }

    public function Delete(ProductIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['productId']);
        $this->repository->DeleteById(Product::class, $arr['productId']);
        return \Success(__('public.delete_product'));
    }

    public function Update(EditProductRequest $request)
    {
        $arr = Arr::only($request->validated(), ['productId', 'name', 'description']);
        $this->repository->Update(Product::class, $arr['productId'], $arr);
        return \Success(__('public.product_update'));
    }

    public function UpdateQuantityPrice(EditProductQuantityRequest $request)
    {
        $arr = Arr::only($request->validated(), ['quantityId', 'price_per_unit']);
        $this->repository->Update(ProductQuantity::class, $arr['quantityId'], $arr);
        return \Success(__('public.edit_quantity_price'));
    }

    public function AddExtraImages(AddExtraProductImagesRequest $request)
    {
        $arr = Arr::only($request->validated(), ['productId', 'images']);
        $this->AddProductImages($arr['productId'], $arr['images']);
        return \Success(__('public.add_product_images'));

    }

    public function DeleteProductImage(DeleteProductImageRequest $request)
    {
        $arr = Arr::only($request->validated(), ['imageId']);
        $this->repository->DeleteById(ProductImage::class, $arr['imageId']);
        return \Success(__('public.delete_product_image'));

    }

    public function ShowAll()
    {
        $perPage = \returnPerPage();
        $products = $this->repository->ShowAll(Product::class, [])->paginate($perPage);
        ShowProductsResource::collection($products);
        return \Pagination($products);

    }

    public function ShowById(ProductIdRequest $request){
        $arr = Arr::only($request->validated(),['productId']);
        $product = $this->repository->ShowById(Product::class,$arr['productId']);
        return \SuccessData(__('public.product_found'),new ShowOneProductResource($product));
    }
}
