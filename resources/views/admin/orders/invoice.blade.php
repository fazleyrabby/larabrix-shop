@extends('admin.layouts.app')
@section('title', 'Order Invoice')

@section('content')
<div class="page-header d-print-none" aria-label="Page header">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">Invoice</h2>
              </div>
              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
                <a href="{{ route('admin.invoice.download', $order->id) }}" class="btn btn-primary">
                  <!-- Download SVG icon from http://tabler.io/icons/icon/printer -->
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                    <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"></path>
                    <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path>
                    <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"></path>
                  </svg>
                  Print Invoice
                </a>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-danger">Back</a>
              </div>
            </div>
          </div>
        </div>
<div class="page-body">
    <div class="container-xl">
        <div class="card card-lg">
            <div class="card-body">
                <div class="row">
                    <!-- Company -->
                    <div class="col-6">
                        <h1 class="h3">Larabrix Admin</h1>
                        <address>
                            123 Market Street<br>
                            City, Country<br>
                            support@larabrix.test<br>
                            +1 (555) 123-4567
                        </address>
                    </div>

                    <!-- Invoice meta -->
                    <div class="col-6 text-end">
                        <p class="h3">INVOICE</p>
                        <p><strong>Invoice #:</strong> {{ $order->transaction->transaction_id }}</p>
                        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->isoFormat('LLL') }}</p>
                        <p><strong>Payment:</strong> {{ strtoupper($order->transaction->gateway) }}</p>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Parties -->
                <div class="row mb-4">
                    <div class="col-6">
                        <h4>Bill To:</h4>
                        @php $shipping = $order->shipping_address; @endphp
                        <p>
                            {{ $shipping->name ?? '' }}<br>
                            {{ $shipping->address ?? '' }}<br>
                            {{ $shipping->city ?? '' }}<br>
                            {{ $shipping->phone ?? '' }}
                        </p>
                    </div>
                    <div class="col-6 text-end">
                        <h4>From:</h4>
                        <p>
                            Larabrix Admin<br>
                            123 Market Street, City<br>
                            VAT: ADMIN-123456
                        </p>
                    </div>
                </div>

                <!-- Items -->
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-striped">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Variant</th>
                                <th class="text-end">Qty</th>
                                <th class="text-end">Price</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order['items'] as $item)
                                <tr>
                                    <td>{{ $item['name'] ?? 'Unknown Product' }}</td>
                                    <td>
                                        @if (!empty($item['variant']['attributeValues']))
                                            {{ collect($item['variant']['attributeValues'])->map(fn($av) => ($av['attribute']['title'] ?? 'Attribute '.$av['attribute_id']).': '.$av['title'])->implode(', ') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="text-end">{{ $item['quantity'] ?? 0 }}</td>
                                    <td class="text-end">{{ $order->currency }} {{ number_format($item['price'] ?? 0, 2) }}</td>
                                    <td class="text-end">{{ $order->currency }} {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0), 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Totals -->
                <div class="row mt-4">
                    <div class="col-6">
                        <p class="text-muted">Thank you for your business.</p>
                    </div>
                    <div class="col-6 text-end">
                        <table class="table table-transparent">
                            <tr>
                                <td class="text-end"><strong>Subtotal:</strong></td>
                                <td class="text-end">{{ $order->currency }} {{ number_format($order->subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-end"><strong>Tax:</strong></td>
                                <td class="text-end">{{ $order->currency }} {{ number_format($order->tax, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-end"><strong>Total:</strong></td>
                                <td class="text-end"><strong>{{ $order->currency }} {{ number_format($order->total, 2) }}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-5">
                    <p class="text-muted">Invoice generated on {{ now()->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection