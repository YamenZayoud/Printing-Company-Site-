<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserImage;
use App\Models\UserAddress;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Enum\AccountTypeEnum;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Repositories\PublicRepository;
use App\Http\Requests\User\UserIdRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\Auth\LoginResource;
use App\Http\Requests\User\UserLoginRequest;
use App\Http\Requests\User\UserSignUpRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\User\ShowUsersResource;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Requests\User\SignUpWithGoogleRequest;


class UserController extends Controller
{
    public function __construct(public PublicRepository $publicRepository, public UserRepository $userRepository)
    {
    }


    public function login(UserLoginRequest $request)
    {
        $arr = Arr::only($request->validated(), ['email', 'password']);
        $where = ['email' => $arr['email']];
        $person = $this->publicRepository->ShowAll(User::class, $where)->first();
        if (!Hash::check($arr['password'], $person->password)) {
            throw ValidationException::withMessages([__('auth.password_wrong')]);
        }
        $person['token'] = $person->createToken('authToken', ['User'])->accessToken;
        return \SuccessData(__('auth.Login'), new LoginResource($person));
    }

    public function SignUp(UserSignUpRequest $request)
    {
        $arr = Arr::only($request->validated(),
            ['f_name','l_name','company_name','display_name','email', 'password','state_id','address','zip_code','phone','image']);
        $user = $this->publicRepository->Create(User::class, $arr);
        $arr['user_id'] = $user->id;
        $this->publicRepository->Create(UserImage::class, $arr);
        $this->publicRepository->Create(UserAddress::class, $arr);
        $user['token'] = $user->createToken('authToken', ['User'])->accessToken;
        return \SuccessData(__('auth.register'), new LoginResource($user));
    }

    public function SignUpWithGoogle(SignUpWithGoogleRequest $request)
    {
        $arr = Arr::only($request->validated(),
            ['google_id','display_name','email','password']);
        $user = User::updateOrCreate(['email' => $arr['email']],
                                    ['google_id' => $arr['google_id'],
                                     'display_name' => $arr['display_name'],
                                     'f_name' => $arr['display_name'],
                                     'l_name' => $arr['display_name'],
                                     'email' => $arr['email'],
                                     'password' => $arr['password'],
                                     'email_verified_at' => Carbon::now(),
                                     ]);
        $user['token'] = $user->createToken('authToken', ['User'])->accessToken;
        return \SuccessData(__('auth.register'), new LoginResource($user));
    }



    public function logout()
    {
        $user = \auth('User')->user();
        $user->tokens()->where('scopes', '["User"]')->delete();
        return \Success(__('auth.Logout'));
    }

    public function ActiveOrNotUser(UserIdRequest $request)
    {
        $arr = Arr::only($request->validated(),['userId']);
        $this->publicRepository->ActiveOrNot(User::class, $arr['userId']);
        return \Success(__('public.active_or_not_User'));
    }


    public function show_user(UserIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['userId']);
        $user = $this->publicRepository->ShowById(User::class, $arr['userId']);
        return \SuccessData(__('public.user_found'), new UserResource($user));
    }

    public function show_paginate_users()
    {
        $perPage = \returnPerPage();
        $user = $this->publicRepository->ShowAll(User::class, [])->paginate($perPage);
        ShowUsersResource::collection($user);
        return \Pagination($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request)
    {
        $arr = Arr::only($request->validated(),
            ['userId', 'f_name', 'l_name', 'company_name', 'email', 'phone', 'display_name', 'state_id', 'address', 'zip_code', 'image']);

        $user = $this->publicRepository->ShowById(User::class, $arr['userId']);
        $user->update($arr);
        $user->UserAddress->update($arr);
        if (\array_key_exists('image', $arr)) {
            $path = 'Images/Profiles/';
            $arr['image'] = uploadImage($arr['image'], $path);
            $user->UserImage->update($arr);
        }

        return \Success(__('public.user_update'));

    }



    /**
     * Remove the specified resource from storage.
     */
    public function Delete(UserIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['userId']);
        $user = $this->publicRepository->ShowById(User::class, $arr['userId']);
        $user->UserAddress->delete();
        $user->UserImage->delete();
        $user->delete();
        return \Success(__('public.delete_user'));
    }
}
