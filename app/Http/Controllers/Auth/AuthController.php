<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\AdminLoginResource;
use App\Interfaces\Auth\AuthenticationInterface;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {
        $data=$request->validated();
        $admin= Admin::query()->firstWhere('username',$data['username']);
        if(!$admin || (!Hash::check($data['password'],$admin['password']))){
            return $this->failed('You can\'t login with these information');
        }
        return $this->success(AdminLoginResource::make($admin));
    }

    public function logout()
    {
        auth('admin-api')->user()?->token()->delete();
        return $this->success(null,'Logout successfully',204);
    }
}
