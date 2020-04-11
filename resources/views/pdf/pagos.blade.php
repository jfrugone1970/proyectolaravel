<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Pagos</title>
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 0.875rem;
            font-weight: normal;
            line-height: 1.5;
            color: #151b1e;           
        }
        .table {
            display: table;
            width: 100%;
            max-width: 100%;
            text-align: left;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
        }

        .cliente {

            display: table;
            width: 100%;
            max-width: 100%;
            text-align: left;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;

        }
        .table-bordered {
            border: 1px solid #c2cfd6;
        }
        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table th, .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #c2cfd6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #c2cfd6;
        }
        .table-bordered thead th, .table-bordered thead td {
            border-bottom-width: 2px;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #c2cfd6;
        }
        th, td {
            display: table-cell;
            vertical-align: inherit;
        }
        th {
            font-weight: bold;
            text-align: -internal-center;
            text-align: left;
        }
        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .izquierda{
            float:left;
        }
        .derecha{
            float:right;
        }
    </style>
</head>
<body>
        <header>
            <div id="logo">
                <img src="img/logo-empresa.png" alt="" id="imagen">
            </div>
            <div id="encabezado">
               <h2>Reporte de Pagos</h2>
            </div>
         
            
        </header>
        <br>
        
        <br>
  
    <div>
        <table class="table table-bordered table-striped table-sm">
           <colgroup>
              <col style="background-color: gray">
              <col span="s" style="background-color:yellow;">
           </colgroup>
            <thead>
                <tr style="background-color: black; color:white"> 
                    <th>Factura</th>
                    <th>Tipo_Pago</th>
                    <th>ClienteId</th>
                    <th>Cliente</th>
                    <th>BancoID</th>
                    <th>Banco</th>
                    <th>TarjetaID</th>
                    <th>Tarjeta</th>
                    <th>Valor ($.)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pagos as $pagocli)
                <tr>
                    <td>{{$pagocli->factura}}</td>
                    <td>{{$pagocli->tipo_pago}}</td>
                    <td>{{$pagocli->idcliente}}</td>
                    <td>{{$pagocli->nombre}}</td>
                    <td>{{$pagocli->idbanco}}</td>
                    <td>{{$pagocli->nombre_banco}}</td>
                    <td>{{$pagocli->idtarjeta}}</td>
                    <td>{{$pagocli->nombre_tarjeta}}</td>
                    <td>{{$pagocli->valor}}</td>
                </tr>
                @endforeach                               
            </tbody>
        </table>
    </div>
    <div class="izquierda">
        <p><strong>Total de registros: </strong>{{$cont}}</p>
    </div>    
</body>
</html>