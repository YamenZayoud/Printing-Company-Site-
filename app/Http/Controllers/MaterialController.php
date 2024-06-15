<?php

namespace App\Http\Controllers;

use App\Http\Requests\Material\MaterialRequest;
use App\Http\Requests\Material\MaterialIdRequest;
use App\Http\Requests\Material\UpdateMaterialRequest;
use App\Http\Resources\Material\MaterialRecordResource;
use App\Models\Material;
use App\Models\MaterialRecord;
use App\Repositories\PublicRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class MaterialController extends Controller
{
    public function __construct(public PublicRepository $publicRepository)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = \returnPerPage();
        $materials = $this->publicRepository->ShowAll(Material::class, [])->paginate($perPage);
        return \Pagination($materials);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(MaterialRequest $request)
    {
        $arr = Arr::only($request->validated(), ['name', 'qr_code']);
        $this->publicRepository->Create(Material::class, $arr);
        return \Success(__('public.Add'));
    }

    /**
     * Display the specified resource.
     */
    public function show(MaterialIdRequest $request)
    {
        $perPage = \returnPerPage();
        $arr = Arr::only($request->validated(), ['materialId']);
        $materials = $this->publicRepository->ShowById(Material::class, $arr['materialId'])->first()->id;
        $where = ['material_id' => $materials];
        $records = $this->publicRepository->ShowAll(MaterialRecord::class, $where)->paginate($perPage);
        MaterialRecordResource::collection($records);
        return \Pagination($records);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMaterialRequest $request)
    {
        $arr = Arr::only($request->validated(), ['qr_code', 'name', 'materialId']);
        $this->publicRepository->Update(Material::class, $arr['materialId'], $arr);
        return \Success(__('public.Update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaterialIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['materialId']);
        $this->publicRepository->DeleteById(Material::class, $arr['materialId']);
        return \Success(__('public.Delete'));
    }
}