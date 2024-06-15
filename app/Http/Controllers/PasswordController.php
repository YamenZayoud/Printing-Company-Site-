<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\PasswordResetMail;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Jobs\Password\DeleteTokenJob;
use App\Repositories\PublicRepository;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Password\ChangePasswordRequest;
use App\Http\Requests\Password\ChangeAdminPasswordRequest;
use App\Http\Requests\Password\PasswordEmailCallbackrequest;
use App\Http\Requests\Password\ResetPasswordRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PasswordController extends Controller
{

    public function __construct(public PublicRepository $repository)

    {
        $this->middleware('permission:Admin Management',
            ['only' => ['ChangeِAdminPassword']]);
    }

    public function SelfChangePassword(ChangePasswordRequest $request)
    {
        $arr = Arr::only($request->validated(), ['old_password', 'new_password']);
        $person = \auth()->user();
        $model = get_class($person);
        if (!Hash::check($arr['old_password'], $person->password)) {
            throw ValidationException::withMessages([__('auth.failed')]);
        }
        $this->repository->update($model, $person->id, ['password' => $arr['new_password']]);
        return \Success(__('auth.password_update'));
    }


    public function ChangeِAdminPassword(ChangeAdminPasswordRequest $request)
    {

        $arr = Arr::only($request->validated(), ['adminId', 'new_password']);
        $admin = $this->repository->ShowById(Admin::class, $arr['adminId']);
        $this->repository->update(Admin::class, $admin->id, ['password' => $arr['new_password']]);
        return \Success(__('auth.password_update'));

    } 

    public function SendEmail(ResetPasswordRequest $request){

        $email = Arr::only($request->validated(),['email']);

        $where = [
            ['email', '=', $email['email']] 
        ];

        $user = $this->repository->ShowAll(User::class, $where)->first();
        
        if($user){
        
            $token = Str::random(60);

            PasswordResetToken::create([
                'email' => $user->email,
                'token' => $token, //Couldn't add Hash::make, i can't find a way to search for the hashed token in DB
                'created_at' => Carbon::now(),
                'user_id' => $user->id
            ]);

            Mail::to($user->email)->send(new PasswordResetMail($token,$user->email));

            return \Success(__('passwords.ResetLinkSent'));
        }

       
    }

    public function EmailCallback(PasswordEmailCallbackrequest $request){

        $arr = Arr::only($request->validated(), ['token', 'email']);
        $where = [
            ['email', '=', $arr['email']] 
        ];

        $attr = $this->repository->ShowAll(PasswordResetToken::class,$where)
                                    ->where('created_at', '>', now()->subMinutes(15))
                                    ->latest()->first();
        
        if (!$attr || $arr['token'] != $attr->token) {
            throw ValidationException::withMessages([__('passwords.Link_Expired')]);
        }

        $this->repository->ShowAll(PasswordResetToken::class,$where)->delete();
     
        $attr->user->update([
            'email_verified_at' =>Carbon::now()
        ]);
        return \Success(__('passwords.verification_completed')); 
    }


}




       


    
