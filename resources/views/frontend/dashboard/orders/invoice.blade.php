@extends('frontend.app')
@push('styles')
    <style>
        /* Print-friendly page size/margins */
        @page {
            size: A4;
            margin: 16mm;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            .card {
                box-shadow: none !important;
            }

            body {
                background: white !important;
            }
        }
    </style>
@endpush
@section('content')
    <section class="page-container">
        <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
            <main class="max-w-4xl mx-auto p-4">
                <div id="invoiceCard" class="card bg-base-100 shadow-xl print:shadow-none">
                    <div class="card-body">
                        <!-- Header -->
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-6">
                            <div class="flex items-center gap-3">
                                {{-- <div class="avatar placeholder">
                                    <div class="bg-primary text-primary-content w-14 rounded-full">
                                        <span class="text-xl font-bold">AC</span>
                                    </div>
                                </div> --}}
                                <div>
                                    <h1 class="text-2xl font-bold leading-tight">Larabrix Shop</h1>
                                    <p class="text-sm text-base-content/60">123 Market Street, City, Country</p>
                                    <p class="text-sm text-base-content/60">support@larabrixshop.test • +1 (555) 123-4567</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <h2 class="text-3xl font-extrabold">INVOICE</h2>
                                <div class="mt-2 grid grid-cols-2 gap-x-4 gap-y-1 text-sm">
                                    <span class="text-base-content/60">Invoice #</span>
                                    <span class="font-semibold">{{ $order->transaction->transaction_id }}</span>
                                    <span class="text-base-content/60">Date</span>
                                    <span class="font-semibold">{{ \Carbon\Carbon::parse($order->created_at)->isoFormat('LLL') }}</span>
                                     <span class="text-base-content/60">Payment Type</span>
                                    <span class="font-semibold">{{ strtoupper($order->transaction->gateway) }}</span>
                                    {{-- <span class="text-base-content/60">Due</span><span class="font-semibold">Sep 20,
                                        2025</span> --}}
                                </div>
                            </div>
                        </div>

                        <div class="divider my-4"></div>

                        <!-- Parties -->
                        <div class="grid sm:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <div class="badge badge-neutral">Bill To</div>
                                @php $shipping = $order->shipping_address @endphp
                                <div class="font-semibold">{{ $shipping->name ?? '' }}</div>
                                <div class="text-sm text-base-content/70">{{ $shipping->address ?? '' }} {{ $shipping->city ?? '' }}</div>
                                <div class="text-sm text-base-content/70">{{ $shipping->phone ?? '' }}</div>
                                {{-- <div class="text-sm text-base-content/70">hello@example.com</div> --}}
                            </div>
                            <div class="space-y-1 sm:text-right">
                                <div class="badge badge-neutral">From</div>
                                <div class="font-semibold">Larabrix</div>
                                <div class="text-sm text-base-content/70">123 Market Street, City</div>
                                <div class="text-sm text-base-content/70">VAT: LARABRIX-123456</div>
                            </div>
                        </div>

                        <!-- Items -->
                        <div class="mt-6 overflow-x-auto rounded-box border border-base-200">
                            <table class="table">
                                <thead>
                                    <tr class="table-section-header">
                                        <th colspan="4">Order Items</th>
                                    </tr>
                                    @if ($order->items->isNotEmpty())
                                        <tr>
                                            <th>Product</th>
                                            <th>Variant</th>
                                            <th class="numeric">Quantity</th>
                                            <th class="numeric">Price</th>
                                        </tr>
                                    @endif
                                </thead>
                                <tbody>
                                    @if ($order->items->isNotEmpty())
                                        @foreach ($order->items as $item)
                                            <tr>
                                                <td>{{ $item->name ?? 'Unknown Product' }}</td>
                                                <td>
                                                    @if ($item->variant && $item->variant->attributeValues->isNotEmpty())
                                                        {{ $item->variant->attributeValues->map(fn($av) => ($av->attribute->title ?? 'Attribute ' . $av->attribute_id) . ': ' . $av->title)->implode(', ') }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td class="numeric">{{ $item->quantity ?? 0 }}</td>
                                                <td class="numeric">{{ $order->currency }}
                                                    {{ number_format($item->price ?? 0, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-error">No items found in this order.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Totals -->
                        <div class="mt-4 flex flex-col items-end gap-2">
                            <div class="grid grid-cols-2 w-full max-w-sm text-sm">
                                <div class="text-base-content/60">Subtotal</div>
                                <div class="text-right font-medium">${{ $order->subtotal }}</div>
                            </div>
                            <div class="grid grid-cols-2 w-full max-w-sm text-sm">
                                <div class="text-base-content/60">Tax</div>
                                <div class="text-right font-medium">${{ $order->tax }}</div>
                            </div>
                            <div class="grid grid-cols-2 w-full max-w-sm text-base">
                                <div class="font-semibold">Total</div>
                                <div class="text-right font-bold text-lg">${{ $order->total }}</div>
                            </div>
                            <div class="grid grid-cols-2 w-full max-w-sm text-sm">
                                <div class="text-base-content/60">Paid</div>
                                <div class="text-right font-medium">${{ $order->total }}</div>
                            </div>
                            {{-- <div class="grid grid-cols-2 w-full max-w-sm text-base">
                                <div class="font-semibold">Amount Due</div>
                                <div class="text-right font-extrabold text-xl">$1,738.00</div>
                            </div> --}}
                        </div>

                        <!-- Notes & Footer -->
                        <div class="mt-6">
                            {{-- <div class="alert alert-info">
                                <span>Thank you for your business! Payment is due within 14 days via bank transfer or
                                    card.</span>
                            </div> --}}
                            {{-- <div class="mt-4 text-xs text-base-content/60">
                                <p>Payment Details: Bank XYZ • IBAN XX00 0000 0000 0000 • SWIFT ABCDXYZ</p>
                            </div> --}}
                        </div>

                        <div class="card-actions justify-end mt-6 no-print">
                            {{-- <button class="btn" onclick="window.print()">Print</button> --}}
                            {{-- <button class="btn btn-outline" onclick="downloadPDF()">Download PDF</button> --}}
                            <a href="{{ route('frontend.invoice.download', $order->id) }}" class="btn btn-neutral">
                                Print
                            </a>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary">
                                Back
                            </a>
                        </div>
                    </div>
                </div>
            </main>

        </div>
    </section>
@endsection
