<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Helpers\ApiResponse as Controller;
use App\Http\Resources\UsersResource;
use App\Models\Users;
use Illuminate\Support\Facades\Validator;


class UsersController extends Controller
{
    public function index(Request $request)
    {
        $users = Users::query();
        if ($request -> username) {
            $users->where('username', 'LIKE', '%' .$request->username. '%');
        }
        $perPage = 10;
        $page = $request->input('page', 1);
        $totalPage = $users->count();
        $pagination = $users->offset(($page - 1) * $perPage)->limit($perPage);
        $result = $pagination->get();
        $finalResult = [
            'documents' => $result,
            'current_page' => $page,
            'total' => $totalPage,
            'last_page' => ceil($totalPage / $perPage)
        ];
        if ($finalResult) {
            return $this->sendResponse($finalResult, 'Users Loaded Successfully');
        }
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'username' => 'required',
            'address' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $users = Users::create($input);
   
        return $this->sendResponse($users, 'User created successfully.');
    }

    public function show($id)
    {
        $users = Users::find($id);
  
        if (is_null($users)) {
            return $this->sendError('User not found.');
        }
   
        return $this->sendResponse(new UsersResource($users), 'User retrieved successfully.');
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'username' => 'required',
            'address' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $users = Users::findOrFail($id);

        $users->update([
            'username' => $request->username,
            'address' => $request->address
        ]);

        return $this->sendResponse(new UsersResource($users), 'User updated successfully.');
    }

    public function destroy(Users $users)
    {
        $users->delete();
        return $this->sendResponse([], 'User deleted successfully.');
    }
}
