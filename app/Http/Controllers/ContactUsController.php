<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactUs\ContactUsIdRequest;
use App\Http\Requests\ContactUs\ContactUsRequest;
use App\Models\ContactUs;
use App\Repositories\PublicRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ContactUsController extends Controller
{

    public function __construct(public PublicRepository $publicRepository)
    {
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(ContactUsRequest $request)
    {
        $arr = Arr::only($request->validated(), ['name', 'phone', 'email', 'message']);
        $arr['user_id'] = \auth('User')->user()->id ?? null;
        $this->publicRepository->Create(ContactUs::class, $arr);
        return \Success(__('public.contact_create'));
    }


    /**
     * Display the specified resource.
     */
    public function show()
    {
        $perPage = \returnPerPage();
        $contactUs = $this->publicRepository->ShowAll(ContactUs::class, [])->paginate($perPage);
        return \Pagination($contactUs);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactUsIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['contactUsId']);
        $this->publicRepository->DeleteById(ContactUs::class, $arr['contactUsId']);
        return \Success(__('public.contact_delete'));
    }
}
