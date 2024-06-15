<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\AddCategoryRequest;
use App\Http\Requests\Category\CategoryIdRequest;
use App\Http\Requests\Category\EditCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryAttributesRequest;
use App\Http\Resources\Category\EditCategoryResource;
use App\Http\Resources\Category\ShowCategoriesResource;
use App\Http\Resources\Category\ShowCategoryResource;
use App\Http\Resources\CategoryAttributes\BinderyAttributesResource;
use App\Http\Resources\CategoryAttributes\BinderyOptionsResource;
use App\Http\Resources\CategoryAttributes\NormalAttributesResource;
use App\Models\BinderyAttribute;
use App\Models\Category;
use App\Models\CategoryBinderyAttribute;
use App\Models\CategoryBinderyOption;
use App\Models\CategoryNormalAttribute;
use App\Models\CategoryNormalOption;
use App\Repositories\PublicRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use ParagonIE\ConstantTime\RFC4648;

class CategoryController extends Controller
{
    public function __construct(public PublicRepository $repository)
    {
    }

    public function Create(AddCategoryRequest $request)
    {
        $arr = Arr::only($request->validated(), ['name', 'image', 'bindery_att', 'normal_att']);
        $path = 'Images/Category/';
        $arr['image'] = \uploadImage($arr['image'], $path);
        $category = $this->repository->Create(Category::class, $arr);
        $this->AddBinderyAttributes($category->id, $arr['bindery_att']);
        $this->AddNormalAttributes($category->id, $arr['normal_att']);
        return \Success(__('public.add_category'));
    }

    private function AddBinderyAttributes($categoryId, $binderyAttributes)
    {
        foreach ($binderyAttributes as $binderyAttribute) {
            $CBA = $this->repository->Create(CategoryBinderyAttribute::class, [
                'category_id' => $categoryId,
                'bindery_att_id' => $binderyAttribute['att_id'],
            ]);
            foreach ($binderyAttribute['att_options'] as $att_option) {
                $this->repository->Create(CategoryBinderyOption::class, [
                    'category_id' => $categoryId,
                    'bindery_option_id' => $att_option,
                    'category_bindery_att_id' => $CBA->id,
                ]);
            }
        }
    }

    private function AddNormalAttributes($categoryId, $normalAttributes)
    {
        foreach ($normalAttributes as $normalAttribute) {
            $CNA = $this->repository->Create(CategoryNormalAttribute::class, [
                'category_id' => $categoryId,
                'normal_att_id' => $normalAttribute['att_id'],
            ]);
            foreach ($normalAttribute['att_options'] as $att_option) {
                $this->repository->Create(CategoryNormalOption::class, [
                    'category_id' => $categoryId,
                    'normal_option_id' => $att_option,
                    'category_normal_att_id' => $CNA->id,
                ]);
            }
        }
    }


    public function ActiveOrNot(CategoryIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['categoryId']);
        $this->repository->ActiveOrNot(Category::class, $arr['categoryId']);
        return \Success(__('public.active_or_not_category'));
    }

    public function Delete(CategoryIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['categoryId']);
        $this->repository->DeleteById(Category::class, $arr['categoryId']);
        return \Success(__('public.delete_category'));
    }

    public function ShowById(CategoryIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['categoryId']);
        $category = $this->repository->ShowById(Category::class, $arr['categoryId']);
        $category['bindery_att'] = BinderyAttributesResource::collection($category->CategoryBinderyAttributes);
        $category['normal_att'] = NormalAttributesResource::collection($category->CategoryNormalAttributes);
        unset($category->CategoryBinderyAttributes);
        unset($category->CategoryNormalAttributes);
        return \SuccessData(__('public.category_found'), new ShowCategoryResource($category));
    }

    public function ShowAll()
    {
        $perPage = \returnPerPage();
        $categories = $this->repository->ShowAll(Category::class, [])->paginate($perPage);
        ShowCategoriesResource::collection($categories);
        return \Pagination($categories);

    }

    public function Update(EditCategoryRequest $request)
    {
        $arr = Arr::only($request->validated(), ['categoryId', 'name', 'image']);
        if (\array_key_exists('image', $arr)) {
            $path = 'Images/Category/';
            $arr['image'] = \uploadImage($arr['image'], $path);
        }
        $this->repository->Update(Category::class, $arr['categoryId'], $arr);
        return \Success(__('public.category_update'));
    }

    public function UpdateCategoryAttributes(UpdateCategoryAttributesRequest $request)
    {
        $arr = Arr::only($request->validated(), ['categoryId', 'bindery_att', 'normal_att']);
        $category = $this->repository->ShowById(Category::class, $arr['categoryId']);
        $category->CategoryBinderyAttributes()->delete();
        $category->CategoryNormalAttributes()->delete();
        $category->CategoryBinderyOptions()->delete();
        $category->CategoryNormalOptions()->delete();
        $this->AddBinderyAttributes($arr['categoryId'], $arr['bindery_att']);
        $this->AddNormalAttributes($arr['categoryId'], $arr['normal_att']);
        return \Success(__('public.category_update_attributes'));
    }
}
