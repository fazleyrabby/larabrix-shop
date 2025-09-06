<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show($id){
        $order = $this->order($id);

        $attributeIds = $order->items->flatMap(function ($item) {
            return $item->variant && $item->variant->attributeValues
                ? $item->variant->attributeValues->pluck('attribute_id')
                : [];
        })->unique()->values()->toArray();
        return view('frontend.dashboard.orders.show', compact('order'));
    }

    public function invoice($id)
    {
        $order = $this->order($id);
        return view('frontend.dashboard.orders.invoice',compact('order'));
    }

    public function invoiceDownload($id){
        $order = $this->order($id);
        $data['order'] = collect($order)->toArray();

        $pdf = Pdf::loadView('frontend.dashboard.orders.invoice-pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('invoice.pdf');
    }

    private function order($id){
        $order = Order::with('items','items.variant','items.variant.attributeValues','transaction')->find($id);
        $order->shipping_address = json_decode($order->shipping_address);
        $order->meta = json_decode($order->meta);
        return $order;
    }
}
