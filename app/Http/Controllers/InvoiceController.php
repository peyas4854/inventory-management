<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\service\InvoiceService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    protected InvoiceService $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;


    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $invoice = $this->invoiceService->index($request);
        return InvoiceResource::collection($invoice);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $items = json_decode($request->itemData);
        foreach ($items as $val) {
            if ($val->quantity == '') {
                return response()->json(['message' => 'Please select an item'], 400);
            }
        }
        DB::beginTransaction();
        try {
            $this->invoiceService->store($request);
            DB::commit();
            return response()->json(['message' => 'invoice create successfully'], 201);
        } catch (Exception $ex) {
            DB::rollback();
            $e = $ex->getMessage();
            $message = "Something went wrong" . $e;
            return response()->json(['message' => $message], 400);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
