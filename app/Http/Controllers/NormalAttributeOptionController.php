<?php

namespace App\Http\Controllers;

use App\Http\Requests\NormalAttributeOption\AddNormalOptionRequest;
use App\Http\Requests\NormalAttributeOption\EditNormalOptionRequest;
use App\Http\Requests\NormalAttributeOption\NormalOptionIdRequest;
use App\Http\Requests\NormalAttributeOption\ShowNormalOptionsRequest;
use App\Models\NormalAttributeOption;
use App\Repositories\PublicRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class NormalAttributeOptionController extends Controller
{
    public function __construct(public PublicRepository $repository)
    {
    }

    public function Create(AddNormalOptionRequest $request)
    {

        $arr = Arr::only($request->validated(), ['normal_att_id', 'name', 'price_type', 'flat_price', 'formula_price']);
        $this->repository->Create(NormalAttributeOption::class, $arr);
        return \Success(__('public.normal_option_create'));

    }

    public function Update(EditNormalOptionRequest $request)
    {
        $arr = Arr::only($request->validated(), ['normalOptionId', 'name', 'price_type', 'flat_price', 'formula_price']);
        if(!\array_key_exists('flat_price',$arr)){
            $arr['flat_price'] = null;
        }else{
            $arr['formula_price'] = null;
        }
        $this->repository->Update(NormalAttributeOption::class, $arr['normalOptionId'], $arr);
        return \Success(__('public.normal_option_update'));
    }

    public function Delete(NormalOptionIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['normalOptionId']);
        $this->repository->DeleteById(NormalAttributeOption::class, $arr['normalOptionId']);
        return \Success(__('public.normal_option_delete'));
    }

    public function ShowAll(ShowNormalOptionsRequest $request)
    {
        $arr = Arr::only($request->validated(), ['normalAttId']);
        $perPage = \returnPerPage();
        $where = ['normal_att_id' => $arr['normalAttId']];
        $options = $this->repository->ShowAll(NormalAttributeOption::class, $where)->paginate($perPage);
        return \Pagination($options);

    }
}
