<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use App\Models\SocialLinkes;
use Illuminate\Http\Request;
use App\Repositories\PublicRepository;
use App\Http\Requests\SocialPlatforms\SocialLinkRequest;
use App\Http\Requests\SocialPlatforms\AddSocialLinkRequest;
use App\Http\Requests\SocialPlatforms\EditSocialLinkRequest;

class SocialLinkesController extends Controller
{
    public function __construct(public PublicRepository $repository)
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function AddSocialLink(AddSocialLinkRequest $request)
    {
        $arr = Arr::only($request->validated(), ['link','social_id']);
        $this->repository->create(SocialLinkes::class,$arr);
        return \Success(__('public.SocialLink_added'));

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function EditSocialLink(EditSocialLinkRequest $request)
    {
        $arr = Arr::only($request->validated(), ['link','SocialLinkId']);
        $this->repository->Update(SocialLinkes::class,$arr['SocialLinkId'],$arr);
        return \Success(__('public.SocialLink_updated'));
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocialLinkRequest $request)
    {
        $arr = Arr::only($request->validated(), ['SocialLinkId']);
        $this->repository->DeleteById(SocialLinkes::class, $arr['SocialLinkId']);
        return \Success(__('public.SocialLink_deleted'));
    }
}
