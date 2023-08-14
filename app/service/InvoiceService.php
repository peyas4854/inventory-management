<?php

namespace App\service;

use App\Models\Invoice;
use App\Models\invoiceDetail;
use App\Models\Stock;
use Carbon\Carbon;

class InvoiceService
{

    public function store($request)
    {
        $invoice = $this->invoiceStore($request);
        self::invoiceDetails($invoice, $request->itemData);

    }

    public function invoiceStore($request)
    {
        $date = self::dateformate($request);

        $data = [
            'date' => $date,
            'invoice_no' => $request->invoice_no,
            'supplier_id' => $request->supplier_id,
            'note' => $request->note,
            'sub_total' => $request->sub_total,
        ];
        return Invoice::query()->create($data);


    }

    public function dateformate($request)
    {
        if ($request->date != 'null' && !is_null($request->date)) {
            return Carbon::parse($request->date)->format("Y-m-d");
        } else {
            return null;
        }


    }

    public function invoiceDetails($invoice, $items)
    {
        foreach (json_decode($items) as $item) {
            invoiceDetail::query()->create([
                'invoice_id' => $invoice->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total_price' => $item->total_price,
            ]);

            Stock::query()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'type' => 'out',
            ]);


        }

    }
}
