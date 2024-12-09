<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\CreateEmployeeRequest;
use App\Models\Employee;
use App\Traits\HasPagination;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    use HasPagination;

    public function index(): JsonResponse
    {
        $searchWord = request('search-word');
        $storeId = request('store-id');
        $employees = Employee::query()
            ->when($searchWord, function (Builder $q) use ($searchWord) {
                $searchWord = '%' . $searchWord . '%';
                return $q
                    ->where('name', 'LIKE', $searchWord)
                    ->orWhere('phone_number', 'LIKE', $searchWord);
            })
            ->when($storeId, function (Builder $q) use ($storeId) {
                return $q
                    ->where('store_id', '=', $storeId);
            })
            ->paginate();

        $page['employees'] = $employees;

        return $this->success($this->pagination($employees, $page));
    }

    public function addFirebaseToken(Request $request)
    {
        $employee = Auth::guard('employee-api')->user();
        $employee->firebase_token = $request->get('token');
        $employee->save();
        return $this->success($employee);
    }

    public function create(CreateEmployeeRequest $request): JsonResponse
    {
        $employee = Employee::query()->create($request->validated());
        return $this->success($employee);
    }

    public function delete($id): JsonResponse
    {
        Employee::query()->findOrFail($id)->delete();

        return $this->success(null, 'The account has been deleted successfully');
    }
}
