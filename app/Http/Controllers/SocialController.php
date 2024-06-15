<?php

namespace App\Http\Controllers;

use App\Models\Social;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Repositories\PublicRepository;
use App\Http\Resources\SocialPlatformsResource;
use App\Http\Requests\SocialPlatforms\SocialPlatformIdRequest;
use App\Http\Requests\SocialPlatforms\AddSocialPlatformRequest;
use App\Http\Requests\SocialPlatforms\EditSocialPlatformRequest;

class SocialController extends Controller
{


    public function __construct(public PublicRepository $repository)
    {
    }



    public function ShowPlatforms()
    {
        $platforms = $this->repository->ShowAll(Social::class, [])->get();
        return  \SuccessData(__('public.ShowSocial'), SocialPlatformsResource::collection($platforms)) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function AddPlatform(AddSocialPlatformRequest $request)
    {
        $arr = Arr::only($request->validated(), ['name','icon']);
        $path = 'Images/Social/';
        $arr['icon'] = \uploadImage($arr['icon'], $path);
        $this->repository->create(Social::class,$arr);
        return \Success(__('public.AddSocial'));

    }

    public function ShowById(SocialPlatformIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['SocialPlatformId']);
        $arr = $this->repository->ShowById(Social::class, $arr['SocialPlatformId']);
        return \SuccessData(__('public.SocialPlatform_found'), new SocialPlatformsResource($arr));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocialPlatformIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['SocialPlatformId']);
        $this->repository->DeleteById(Social::class, $arr['SocialPlatformId']);
        return \Success(__('public.SocialPlatform_deleted'));
    }


    public function UpdateSocialPlatform(EditSocialPlatformRequest $request){

        $arr = Arr::only($request->validated(),['SocialPlatformId','name','icon']);

        if(\array_key_exists('icon',$arr)){
            $path  = 'Images/Social/';
            $arr['icon'] = \uploadImage($arr['icon'],$path);
        }
        $this->repository->Update(Social::class,$arr['SocialPlatformId'],$arr);

        return \Success(__('public.SocialPlatform_updated'));
    }
}
