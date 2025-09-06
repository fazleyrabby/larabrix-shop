<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title></title>

		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
		</style>
	</head>

	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="4">
						<table>
							<tr>
								<td class="title" colspan="3">
									{{-- <img
										src="https://sparksuite.github.io/simple-html-invoice-template/images/logo.png"
										style="width: 100%; max-width: 300px"
									/> --}}
									Larabrix Shop
								</td>

								<td>
									Invoice #: {{ $order['order_number'] }}<br />
									Created: {{ \Carbon\Carbon::parse($order['created_at'])->format('M d, Y H:i') }}<br />
									Payment Type: {{ strtoupper($order['transaction']['gateway']) }}<br />
									{{-- Due: February 1, 2023 --}}
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="4">
						<table>
							<tr>
								<td>
									Sparksuite, Inc.<br />
									{{ $order['shipping_address']->address ?? '' }} {{ $order['shipping_address']->city ?? '' }}<br />
									{{ $order['shipping_address']->phone ?? '' }}
								</td>

								<td>
									Larabrix Shop<br />
									{{-- John Doe<br /> --}}
									support@larabrixshop.com
								</td>
							</tr>
						</table>
					</td>
				</tr>

				{{-- <tr class="heading">
					<td colspan="3">Payment Method</td>
					<td>Check #</td>
				</tr>

				<tr class="details">
					<td colspan="3">Check</td>

					<td>1000</td>
				</tr> --}}

				<tr class="heading">
					<td>Item</td>
					<td>Variant</td>
					<td>Qty</td>
					<td>Price</td>
				</tr>

				@if ($order['items'])
					@foreach ($order['items'] as $item)
					<tr class="item">
						<td>{{ $item['name'] ?? 'Unknown Product' }}</td>
						<td>
								@if (!empty($item['variant']) && !empty($item['variant']['attributeValues']))
									{{ collect($item['variant']['attributeValues'])->map(fn($av) => 
										($av['attribute']['title'] ?? 'Attribute ' . $av['attribute_id']) . ': ' . $av['title']
									)->implode(', ') }}
								@else
									N/A
								@endif
							</td>
						<td>{{ $item['quantity'] ?? 0 }}</td>
							<td>{{ $order['currency'] ?? '' }}
								{{ number_format($item['price'] ?? 0, 2) }}
							</td>
					</tr>
					@endforeach
				@else
					<tr>
						<td colspan="4" class="text-error">No items found in this order.</td>
					</tr>
				@endif
				
				

				<tr class="total">
					<td colspan="3"></td>

					<td>Total: {{ $order['currency'] }} {{ $order['total'] }}</td>
				</tr>
			</table>
		</div>
	</body>
</html>