<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Factura Venta</title>
    <link rel="stylesheet" href="{{public_path('css/style.css') }}" type="text/css"/>
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="images/img/sale_logo.png">
      </div>
      <div id="company">
        <h2 class="name">SaleSystem</h2>
        <div>Dirección | Fiscal</div>
        <div>N° telefóno | (212) 123-4567</div>
        <div><a href="mailto:company@example.com">salesystem@example.com</a></div>
      </div>
      </div>
    </header>
    <main>
      @foreach($sale as $sal)
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">Proveedor:</div>
          <h2 class="name">{{ $sal->customer_name }}</h2>
          <div class="address">{{ $sal->address }}</div>
          <div class="">N° Teléfono: {{ $sal->num_phone }}</div>
          <div class="email">Email: <a href="mailto:john@example.com"> {{ $sal->email }}</a></div>
        </div>
        <div id="invoice">
          <h1>{{ $sal->type_voucher }} | <span class="date" style="font-size: 14px;">#{{ $sal->num_voucher }}</span></h1>
          <div class="date">Comprobante: #{{ $sal->num_bill }}</div>
          <div class="date">Fecha: {{ date_format($sal->created_at,'d-m-Y') }}</div>
          {{-- <div class="date">Due Date: 30/06/2014</div> --}}
        </div>
      </div>
      <table border="0" cellspacing="0" cellpadding="0" style="font-size: 10px;">
        <thead>
          <tr>
            <th>#</th>
            <th>Producto</th>
            <th>Tipo Venta</th>
            <th>Cant.</th>
            <th>Pack</th>
            <th>Precio</th>
            <th>Desc.(%)</th>
            <th>TOTAL</th>
          </tr>
        </thead>
        <tbody>
          @foreach($detail_sales as $key => $detail)
          <tr>
            <td class="no">{{ $key + 1  }}</td>         
            <td class="des" width="130"><h3>{{ $detail->name }}</h3></td>
            <td class="type"><h3>{{ $detail->type_sale }}</h3></td>
            <td class="qty">{{ $detail->quantity }}</td>
            @if($detail->type_sale=='Venta Mayor')
            <td class="qty">{{ $detail->quantity/$detail->wholesale_quantity }}</td>
            @else 
            <td class="qty">{{ 0 }}</td>
            @endif
            <td class="unit">{{ number_format($detail->price_sale, 2, ',','.') }}</td>
            <td class="qty">{{ $detail->discount*100/100 }}</td>
            @if($detail->type_sale=='Venta Mayor')
            <td class="total">{{ number_format(($detail->price_sale*($detail->quantity/$detail->wholesale_quantity)-(($detail->price_sale*($detail->quantity/$detail->wholesale_quantity))*($detail->discount/100))),2,',','.') }}</td>
            @else
            <td class="total">{{ number_format(($detail->price_sale*$detail->quantity-($detail->price_sale*$detail->quantity*($detail->discount/100))),2,',','.') }}</td>
            @endif
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="5"></td>
            <td colspan="2">SUBTOTAL</td>
            <td>{{ number_format($sal->total-($sal->total*$sal->tax/100),2,',','.') }}</td>
          </tr>
          <tr>
            <td colspan="5"></td>
            <td colspan="2">IVA {{ $sal->tax*100/100 }}%</td>
            <td>{{ number_format($sal->total*$sal->tax/100,2,',','.') }}</td>
          </tr>
          <tr>
            <td colspan="5"></td>
            <td class="totalfoot" colspan="2">TOTAL</td>
            <td class="totalfoot"><span>Bs.</span>{{ number_format($sal->total,2,',','.') }}</td>
          </tr>
        </tfoot>
      </table>
      {{-- <div id="thanks">Thank you!</div>
      <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div> --}}
      @endforeach
    </main>
    <footer>
      Factura creada por el sistema | SaleSystem |  {{ date_format($sal->created_at,'d-m-Y') }}.
    </footer>
  </body>
</html>
