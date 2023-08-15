<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceStoreRequest;
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
    public function store(InvoiceStoreRequest $request)
    {
        $items = json_decode($request->itemData);
        if (count($items) == 0) {
            return response()->json(['message' => 'Please select an item'], 422);
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
}
