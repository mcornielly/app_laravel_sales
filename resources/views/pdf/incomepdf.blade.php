<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Font Awesome Icons -->
    {{-- <link rel="stylesheet" href="adminlte/plugins/fontawesome-free/css/all.min.css"> --}}
    <!-- CSS Adminlte -->
    <link rel="stylesheet" href="{{public_path('/adminlte/css/adminlte.min.css') }}" type="text/css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        @foreach($income as $inc)
        <div ref="content" class="invoice p-3 mb-3 mt-4">
            <!-- title row -->
            <div class="row">
                <div class="col-12">
                <h4>
                    <i class="fas fa-globe"></i> AdminLTE, Inc.
                    <small class="float-right">Fecha: <span>{{ $inc->created_at }}</span></small>
                </h4>
                </div>
                <!-- /.col -->
            </div>
            <hr>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <b class="text-mute">Proveedor:</b>   
                {{ $inc->customer_name }}<br>
                    <address>
                        {{ $inc->address }} <br>
                        <b>Phone: </b><span>{{ $inc->num_phone }}</span><br>
                        <b>Email: </b><span>{{ $inc->email }}</span>
                    </address>
                </div>
                <div class="col-sm-4 invoice-col">
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                <b>N° <span>{{ $inc->type_voucher }}</span> <span>#{{ $inc->num_voucher }}</span> </b><br>
                <br>
                <b>N° Comprobante :</b> <span>{{ $inc->num_bill }}</span><br>
                <b>Fecha de Pago :</b> <span>{{ $inc->created_at }}</span><br>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
    
            <!-- Table row -->
            <div class="row">
                <div class="col-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                    <th>#</th>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Cantidad </th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                    @foreach($detail_incomes as $key => $detail)
                        <td>{{ $key + 1  }}</td>
                        <td>{{ $detail->code }}</td>
                        <td>{{ $detail->name }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ $detail->price }}</td>
                        <td>{{ $detail->price }}</td>
                    @endforeach
                    </tr>
                    </tbody>
                </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
    
            <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
    
                </div>
                <!-- /.col -->
                <div class="col-6">
                <p class="lead">Balance </p>
    
                <div class="table-responsive">
                    <table class="table">
                    <tbody><tr>
                        <th style="width:50%">Subtotal:</th>
                        <td class="text-right">Bs.12.236.362,00</td>
                    </tr>
                    <tr>
                        <th>IVA <span>16%</span></th>
                        <td class="text-right">Bs. 12.222.362,00</td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <td class="text-right">Bs. 12.365.251,12</td>
                    </tr>
                    </tbody></table>
                </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        @endforeach
    </div>
</body>
</html>