<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Comprobante Ingreso</title>
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
      @foreach($income as $inc)
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">Proveedor:</div>
          <h2 class="name">{{ $inc->customer_name }}</h2>
          <div class="address">{{ $inc->address }}</div>
          <div class="">N° Teléfono: {{ $inc->num_phone }}</div>
          <div class="email">Email: <a href="mailto:john@example.com"> {{ $inc->email }}</a></div>
        </div>
        <div id="invoice">
          <h1>{{ $inc->type_voucher }} | <span class="date" style="font-size: 14px;">#{{ $inc->num_voucher }}</span></h1>
          <div class="date">Comprobante: #{{ $inc->num_bill }}</div>
          <div class="date">Fecha: {{ date_format($inc->created_at,'d-m-Y') }}</div>
          {{-- <div class="date">Due Date: 30/06/2014</div> --}}
        </div>
      </div>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th>#</th>
            <th>Producto</th>
            <th>Precio (UNI)</th>
            <th>Cantidad</th>
            <th>TOTAL</th>
          </tr>
        </thead>
        <tbody>
          @foreach($detail_incomes as $key => $detail)
          <tr>
            <td class="no">{{ $key + 1  }}</td>         
            <td class="desc"><h3>{{ $detail->name }}</h3></td>
            <td class="unit">{{ number_format($detail->price, 2, ',','.') }}</td>
            <td class="qty">{{ $detail->quantity }}</td>
            <td class="total">{{ number_format($detail->price*$detail->quantity,2,',','.') }}</td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2"></td>
            <td colspan="2">SUBTOTAL</td>
            <td>{{ number_format($inc->total-($inc->total*$inc->tax/100),2,',','.') }}</td>
          </tr>
          <tr>
            <td colspan="2"></td>
            <td colspan="2">IVA {{ $inc->tax/100 }}%</td>
            <td>{{ number_format($inc->total*$inc->tax,2,',','.') }}</td>
          </tr>
          <tr>
            <td colspan="2"></td>
            <td class="totalfoot" colspan="2">TOTAL</td>
            <td class="totalfoot">{{ number_format($inc->total,2,',','.') }}</td>
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
      Factura creada por el sistema | SaleSystem |  {{ date_format($inc->created_at,'d-m-Y') }}.
    </footer>
  </body>
</html>
