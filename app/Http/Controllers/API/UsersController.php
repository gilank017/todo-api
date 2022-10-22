<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Helpers\ApiResponse as Controller;
use App\Http\Resources\UsersResource;
use App\Models\Users;
use Illuminate\Support\Facades\Validator;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = Users::query();
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
        // $data = Users::all();
        // if ($data) {
        //     return $this->sendResponse($data, 'Users Loaded Successfully');
        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = Users::find($id);
  
        if (is_null($users)) {
            return $this->sendError('User not found.');
        }
   
        return $this->sendResponse(new UsersResource($users), 'User retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Users $users)
    {
        $users->delete();
        return $this->sendResponse([], 'User deleted successfully.');
    }
}
