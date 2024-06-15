<?php

namespace App\Http\Controllers;

use App\Http\Requests\BinderyAttributeOption\AddBinderyOptionRequest;
use App\Http\Requests\BinderyAttributeOption\BinderyOptionIdRequest;
use App\Http\Requests\BinderyAttributeOption\EditBinderyOptionRequest;
use App\Http\Requests\BinderyAttributeOption\ShowBinderyOptionsRequest;
use App\Models\BinderyAttributeOption;
use App\Repositories\PublicRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BinderyAttributeOptionController extends Controller
{

    public function __construct(public PublicRepository $repository)
    {
    }

    public function Create(AddBinderyOptionRequest $request)
    {
        $arr = Arr::only($request->validated(), ['bindery_att_id', 'name', 'setup_price', 'price_per_unit', 'markup']);
        $this->repository->Create(BinderyAttributeOption::class, $arr);
        return \Success(__('public.bindery_option_create'));

    }

    public function Update(EditBinderyOptionRequest $request)
    {
        $arr = Arr::only($request->validated(), ['binderyOptionId', 'name', 'setup_price', 'price_per_unit', 'markup']);
        $this->repository->Update(BinderyAttributeOption::class, $arr['binderyOptionId'], $arr);
        return \Success(__('public.bindery_option_update'));
    }

    public function Delete(BinderyOptionIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['binderyOptionId']);
        $this->repository->DeleteById(BinderyAttributeOption::class, $arr['binderyOptionId']);
        return \Success(__('public.bindery_option_delete'));
    }

    public function ShowAll(ShowBinderyOptionsRequest $request)
    {
        $arr = Arr::only($request->validated(), ['binderyAttId']);
        $perPage = \returnPerPage();
        $where = ['bindery_att_id' => $arr['binderyAttId']];
        $options = $this->repository->ShowAll(BinderyAttributeOption::class, $where)->paginate($perPage);
        return \Pagination($options);

    }
}
