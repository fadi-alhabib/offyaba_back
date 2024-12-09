<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminUpdateRequest;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function update(AdminUpdateRequest $request)
    {
        $request->validated();
        auth('admin-api')->user()->update($request->all());
        return $this->success(null,"Information Updated successfully");
    }

    public function delete()
    {
        auth('admin-api')->user()->token()->delete();
        auth('admin-api')->user()->delete();
        return $this->success(null,"Account has been deleted successfully");
    }
}
