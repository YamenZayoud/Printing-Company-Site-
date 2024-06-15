<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutUsRequest;
use App\Http\Requests\HomePromo\HomePromoRequest;
use App\Http\Resources\Setting\ShowAboutUsResource;
use App\Http\Resources\Setting\ShowHomePromoResource;
use App\Models\Setting;
use App\Repositories\PublicRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SettingController extends Controller
{

    public function __construct(public PublicRepository $repository)
    {
    }

    public function ShowHomePromo()
    {
        $where = ['key' => 'Home Promo'];
        $HomePromo = $this->repository->ShowAll(Setting::class, $where)->first();
        if ($HomePromo->value) {
            $HomePromo['is_video'] = \CheckVideoOrImage($HomePromo->value);
        }
        return \SuccessData(__('public.promo_found'), new ShowHomePromoResource($HomePromo));
    }

    public function UpdateHomePromo(HomePromoRequest $request)
    {
        $arr = Arr::only($request->validated(), ['value', 'description']);
        $where = ['key' => 'Home Promo'];
        $HomePromo = $this->repository->ShowAll(Setting::class, $where)->first();
        if(\array_key_exists('value',$arr)){
            $path = 'Images/HomePromo/';
            $arr['value'] = \uploadImage($arr['value'],$path);
        }
        $this->repository->Update(Setting::class,$HomePromo->id,$arr);
        return \Success(__('public.Promo_update'));
    }

    public function ShowAboutUs()
    {
        $where = ['key' => 'About Us'];
        $AboutUs = $this->repository->ShowAll(Setting::class, $where)->first();
        return \SuccessData(__('public.about_us_found'), new ShowAboutUsResource($AboutUs));
    }

    public function UpdateAboutUs(AboutUsRequest $request)
    {
        $arr = Arr::only($request->validated(), ['value']);
        $where = ['key' => 'About Us'];
        $AboutUs = $this->repository->ShowAll(Setting::class, $where)->first();
        $this->repository->Update(Setting::class,$AboutUs->id,$arr);
        return \Success(__('public.about_us_update'));
    }
}
