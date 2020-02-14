<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banco;
use App\Cliente;
use App\Pagos;

class PagoController extends Controller
{
    public function index(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if($buscar==''){

            $pago= Pagos::orderBy('id','desc')->paginate(3);

        } else{

            $pago= Pagos::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(3);
        }

         
        return[

            'pagination' => [
            'total'            => $pago->total(),
            'current_page'     => $pago->currentPage(),
            'per_page'         => $pago->perPage(),
            'last_page'        => $pago->lastPage(),
            'from'             => $pago->firstItem(),
            'to'               => $pago->lastItem(),
           
            ],

            'pago' =>$pago

        ];
       
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $pago= new Pagos();
        $pago->tipo_pago = $request->tipo_pago;
        $pago->idcliente = $request->idcliente;
        $pago->idbanco = $request->idbanco;
        $pago->idtarjeta = $request->idtarjeta;
        $pago->valor = $request->valor;

        $pago->save();
    }

}
