<?php

namespace App\Http\Controllers;

use App\Http\Requests\BinderyAttribute\AddBinderyAttributeRequest;
use App\Http\Requests\BinderyAttribute\BinderyAttributeIdRequest;
use App\Http\Requests\BinderyAttribute\EditBinderyAttributeRequest;
use App\Http\Resources\BinderyAttribute\ShowBinderyAttributeResource;
use App\Models\BinderyAttribute;
use App\Repositories\PublicRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BinderyAttributeController extends Controller
{
    public function __construct(public PublicRepository $repository)
    {
    }

    public function Create(AddBinderyAttributeRequest $request){
    $arr = Arr::only($request->validated(),['name','attribute_type']);
    $this->repository->Create(BinderyAttribute::class,$arr);
    return \Success(__('public.bindery_att_add'));
    }

    public function ShowById(BinderyAttributeIdRequest $request){
    $arr = Arr::only($request->validated(),['binderyAttId']);
    $attribute = $this->repository->ShowById(BinderyAttribute::class,$arr['binderyAttId']);
    return \SuccessData(__('public.bindery_att_found'),new ShowBinderyAttributeResource($attribute));

    }

    public function Update(EditBinderyAttributeRequest $request){
        $arr = Arr::only($request->validated(),['binderyAttId','name','attribute_type']);
        $this->repository->Update(BinderyAttribute::class,$arr['binderyAttId'],$arr);
        return \Success(__('public.bindery_att_update'));
    }

    public function ShowAll(){
        $perPage = \returnPerPage();
        $attributes = $this->repository->ShowAll(BinderyAttribute::class,[])->paginate($perPage);
        ShowBinderyAttributeResource::collection($attributes);
        return \Pagination($attributes);
    }

    public function Delete(BinderyAttributeIdRequest $request){
        $arr = Arr::only($request->validated(),['binderyAttId']);
        $this->repository->DeleteById(BinderyAttribute::class,$arr['binderyAttId']);
        return \Success(__('public.delete_bindery_att'));
    }

}
