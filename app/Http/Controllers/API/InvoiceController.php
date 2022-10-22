<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Helpers\ApiResponse as Controller;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use Illuminate\Support\Facades\Validator;


class InvoiceController extends Controller
{
    public function index()
    {
        $data = Invoice::with('users')->get();
        if ($data) {
            return $this->sendResponse($data, 'Invoice Loaded Successfully');
        }
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'invoice_id' => 'required',
            'user_id' => 'required|numeric|exists:App\Models\Users,id',
            'date' => 'required|date',
            'status' => 'required|boolean',

        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $invoice = Invoice::create($input);

        return $this->sendResponse($invoice, 'Invoice created successfully.');
    }

    public function show($id)
    {
        $invoice = Invoice::find($id);
  
        if (is_null($invoice)) {
            return $this->sendError('Invoice not found.');
        }
   
        return $this->sendResponse(new InvoiceResource($invoice), 'Invoice retrieved successfully.');
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'invoice_id' => 'required',
            'user_id' => 'required|numeric|exists:App\Models\Users,id',
            'date' => 'required|date',
            'status' => 'required|boolean',

        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $invoice = Invoice::findOrFail($id);

        $invoice->update([
            'invoice_id' => $request->invoice_id,
            'user_id' => $request->user_id,
            'date' => $request->date,
            'status' => $request->status,
        ]);

        return $this->sendResponse(new InvoiceResource($invoice), 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return $this->sendResponse([], 'Invoice deleted successfully.');
    }
}
