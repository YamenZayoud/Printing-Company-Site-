<?php

namespace App\Http\Controllers;

use App\Http\Requests\NormalAttribute\AddNormalAttributeRequest;
use App\Http\Requests\NormalAttribute\EditNormalAttributeRequest;
use App\Http\Requests\NormalAttribute\NormalAttributeIdRequest;
use App\Http\Resources\NormalAttribute\ShowNormalAttributeResource;
use App\Models\NormalAttribute;
use App\Repositories\PublicRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class NormalAttributeController extends Controller
{
    public function __construct(public PublicRepository $repository)
    {
    }

    public function Create(AddNormalAttributeRequest $request){
        $arr = Arr::only($request->validated(),['name','attribute_type']);
        $this->repository->Create(NormalAttribute::class,$arr);
        return \Success(__('public.normal_att_add'));
    }

    public function ShowById(NormalAttributeIdRequest $request){
        $arr = Arr::only($request->validated(),['normalAttId']);
        $attribute = $this->repository->ShowById(NormalAttribute::class,$arr['normalAttId']);
        return \SuccessData(__('public.normal_att_found'),new ShowNormalAttributeResource($attribute));

    }

    public function Update(EditNormalAttributeRequest $request){
        $arr = Arr::only($request->validated(),['normalAttId','name','attribute_type']);
        $this->repository->Update(NormalAttribute::class,$arr['normalAttId'],$arr);
        return \Success(__('public.normal_att_update'));
    }

    public function ShowAll(){
        $perPage = \returnPerPage();
        $attributes = $this->repository->ShowAll(NormalAttribute::class,[])->paginate($perPage);
        ShowNormalAttributeResource::collection($attributes);
        return \Pagination($attributes);
    }

    public function Delete(NormalAttributeIdRequest $request){
        $arr = Arr::only($request->validated(),['normalAttId']);
        $this->repository->DeleteById(NormalAttribute::class,$arr['normalAttId']);
        return \Success(__('public.delete_normal_att'));
    }
}
