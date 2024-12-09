<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\VerifyLoginRequest;
use App\Http\Requests\User\UploadImageRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserShowResource;
use App\Services\User\UserUpdateService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Random\RandomException;

class UserController extends Controller
{
    public function show()
    {
        return $this->success(UserShowResource::make(auth('user-api')->user()));
    }

    public function update(UserUpdateRequest $request)
    {
        $data = $request->validated();
        if ($request->has('phone_number')) {
            try {
                $verifyPhoneNumber = new UserUpdateService($data, auth('user-api')->user());
                $verifyPhoneNumber->sendCode();
                return $this->success(null);
            } catch (RandomException $e) {
                return $this->failed("There is a problem, please try again");
            }
        }
        auth('user-api')->user()->update($data);
        return $this->success(null);
    }

    public function verifyUpdate(VerifyLoginRequest $request)
    {
        $data = $request->validated();
        $verifyPhoneNumber = new UserUpdateService($data, auth('user-api')->user());
        try {
            $verifyPhoneNumber->updateIfCorrect();
            return $this->success(null, 'Phone number has been updated successfully');
        } catch (Exception $ex) {
            return $this->failed($ex->getMessage());
        }
    }

    public function addFirebaseToken(Request $request)
    {
        $user = Auth::guard('user-api')->user();
        $user->firebase_token = $request->get('token');
        $user->save();
        return $this->success($user);
    }

    public function delete()
    {
        auth('user-api')->user()->token()?->delete();
        auth('user-api')->user()->delete();
        return $this->success(null, 'The account has been deleted successfully');
    }

    public function uploadImage(UploadImageRequest $request): JsonResponse
    {
        $path = auth()->user()->upload($request['image']);

        return $this->success($path);
    }

    public function deleteImage(): JsonResponse
    {
        try {
            auth()->user()->deleteImage();
        } catch (Exception $exception) {
            return $this->failed($exception->getMessage());
        }
        return $this->noContent();
    }
}
