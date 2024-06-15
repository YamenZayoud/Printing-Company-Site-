<?php

namespace App\Http\Controllers;


use App\Http\Requests\State\AddStateRequest;
use App\Http\Requests\State\EditStateRequest;
use App\Http\Requests\State\StateIdRequest;
use App\Models\State;
use App\Repositories\PublicRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;

class StateController extends Controller
{
    public function __construct(public PublicRepository $repository)
    {
    }

    public function Create(AddStateRequest $request)
    {
        $arr = Arr::only($request->validated(), ['name']);
        $this->repository->Create(State::class, $arr);
        return \Success(__('public.add_state'));
    }

    public function ActiveOrNot(StateIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['stateId']);
        $this->repository->ActiveOrNot(State::class, $arr['stateId']);
        return \Success(__('public.active_or_not_state'));

    }

    public function Delete(StateIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['stateId']);
        $this->repository->DeleteById(State::class, $arr['stateId']);
        return \Success(__('public.delete_state'));
    }

    public function ShowById(StateIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['stateId']);
        $state = $this->repository->ShowById(State::class, $arr['stateId']);
        return \SuccessData(__('public.state_found'), $state);
    }

    public function ShowAll()
    {
        $states = $this->repository->ShowAll(State::class, [])->get();
        return \SuccessData(__('public.state_found'), $states);
    }

    public function Update(EditStateRequest $request)
    {
        $arr = Arr::only($request->validated(), ['stateId', 'name']);
        $this->repository->Update(State::class, $arr['stateId'], $arr);
        return \Success(__('public.state_update'));

    }

    public function ShowAllPermission()
    {
        $permissions = $this->repository->ShowAll(Permission::class, [])->get(['uuid', 'name']);
        return \SuccessData(__('public.permission_found'), $permissions);
    }
}
