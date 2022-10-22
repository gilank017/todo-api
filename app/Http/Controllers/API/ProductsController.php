<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Helpers\ApiResponse as Controller;
use App\Http\Resources\ProductsResource;
use App\Models\Products;
use Illuminate\Support\Facades\Validator;


class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $data = Products::query();
        if ($request -> name) {
            $data->where('name', 'LIKE', '%' .$request->name. '%');
        }
        if ($sort = $request->input(key:'sort')) {
            $data->orderBy('price', $sort);
        };
        $perPage = 5;
        $page = $request->input('page', 1);
        $totalpage = $data->count();
        $pagination = $data->offset(($page - 1) * $perPage)->limit($perPage);
        $result = $pagination->get();
        $finalResult = [
            'documents' => $result,
            'current_page' => $page,
            'total' => $totalpage,
            'last_page' => ceil($totalpage / $perPage)
        ];
        if ($finalResult) {
            return $this->sendResponse($finalResult, 'Products Loaded Successfully');
        }
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'price' => 'required|numeric',

        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $product = Products::create($input);
   
        return $this->sendResponse($product, 'Product created successfully.');
    }

    public function show($id)
    {
        $product = Products::find($id);

        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }

        return $this->sendResponse(new ProductsResource($product), 'Product retrieved successfully.');
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'price' => 'required|numeric'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $product = Products::findOrFail($id);

        $product->update([
            'name' => $request->name,
            'price' => $request->price
        ]);

        return $this->sendResponse(new ProductsResource($product), 'Product updated successfully.');
    }


    public function destroy(Products $product)
    {
        $product->delete();
        return $this->sendResponse([], 'Product deleted successfully.');
    }
}
