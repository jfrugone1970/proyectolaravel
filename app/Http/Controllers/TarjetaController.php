<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tarjeta;
use App\Banco;
use App\Cliente;
use App\ClienteTarjeta;

class TarjetaController extends Controller
{
    public function index(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if($buscar==''){

            $tarjetas= Tarjeta::join('bancos','tarjeta.idbancos','=','bancos.id')
            ->select('tarjeta.id','tarjeta.nombre','tarjeta.descripcion','tarjeta.externa','tarjeta.idbancos','tarjeta.condicion','bancos.nombre as nombre_banco')
            ->orderBy('tarjeta.nombre', 'desc')->paginate(3);

        } else{

            $tarjetas = Tarjeta::join('bancos','tarjeta.idbancos','=','bancos.id')
            ->select('tarjeta.id','tarjeta.nombre','tarjeta.descripcion','tarjeta.externa','tarjeta.idbancos','tarjeta.condicion','bancos.nombre as nombre_banco')
            ->where('tarjeta.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tarjeta.nombre', 'desc')->paginate(3);
        }

         
        return[

            'pagination' => [
            'total'            => $tarjetas->total(),
            'current_page'     => $tarjetas->currentPage(),
            'per_page'         => $tarjetas->perPage(),
            'last_page'        => $tarjetas->lastPage(),
            'from'             => $tarjetas->firstItem(),
            'to'               => $tarjetas->lastItem(),
           
            ],

            'tarjetas' =>$tarjetas

        ];
       
    }

    public function selectTarjetas(Request $request){

        if(!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $tarjetas = Tarjeta::where('id','=', $filtro)
        ->select('id','nombre')->orderBy('nombre', 'asc')->take(1)->get();

        return ['tarjetas' => $tarjetas];
    }

    public function listarTarjetas(Request $request){

        //
        if(!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if($buscar==''){

            $tarjetas= Tarjeta::join('bancos','tarjeta.idbancos','=','bancos.id')
            ->select('tarjeta.id','tarjeta.nombre','tarjeta.descripcion','tarjeta.externa','tarjeta.idbancos','tarjeta.condicion','bancos.nombre as nombre_banco')
            ->orderBy('tarjeta.id', 'desc')->paginate(3);

        } else{

            $productos = Tarjeta::join('bancos','tarjetas.idbancos','=','bancos.id')
            ->select('tarjeta.id','tarjeta.nombre','tarjeta.descripcion','tarjeta.externa','tarjeta.idbancos','tarjeta.condicion','bancos.nombre as nombre_banco')
            ->where('tarjetas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tarjeta.id', 'desc')->paginate(3);
        }

         
        return['tarjetas' =>$tarjetas];


    }

    Public function listarTarjetasTotal(Request $request){

        if(!$request->ajax()) return redirect('/');

        $buscar= $request->buscarR;
        $criterio= $request->criterioR;

        if($buscar==''){

            $tarjetas= Tarjeta::join('bancos','tarjeta.idbancos','=','bancos.id')
            ->select('tarjeta.id','tarjeta.nombre','tarjeta.descripcion','tarjeta.externa','tarjeta.idbancos','tarjeta.condicion','bancos.nombre as nombre_banco')
            ->orderBy('tarjeta.id', 'desc')->paginate(3);

        } else{

            $productos = Tarjeta::join('bancos','tarjetas.idbancos','=','bancos.id')
            ->select('tarjeta.id','tarjeta.nombre','tarjeta.descripcion','tarjeta.externa','tarjeta.idbancos','tarjeta.condicion','bancos.nombre as nombre_banco')
            ->where('tarjetas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tarjeta.id', 'desc')->paginate(3);
        }

         
        return['tarjetas' =>$tarjetas];

    }

    
    public function listarPDF(){

        $clientetar = ClienteTarjeta::join('clientes','clientes_tarjetas.idcliente','=','clientes.id')
        ->join('bancos','clientes_tarjetas.idbanco','=','bancos.id')
        ->join('tarjeta','clientes_tarjetas.idtarjeta','=','tarjeta.id')
        ->select('clientes_tarjetas.idcliente','clientes_tarjetas.idtarjeta','clientes_tarjetas.idbanco',
        'clientes_tarjetas.ntarjeta','clientes_tarjetas.estado','clientes.nombre as nombre_cliente',
        'bancos.nombre as nombre_banco','tarjeta.nombre as nombre_tarjeta')
        ->orderBy('bancos.nombre', 'desc')->get();

        $cont=ClienteTarjeta::count();

        $pdf= \PDF::loadView('pdf.tarjetaspdf',['clientetar'=>$clientetar,'cont'=>$cont]);
        return $pdf->download('tarjetas.pdf');
        

    }

    public function listarClienteTarjeta(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar= $request->buscarR;
        $criterio= $request->criterioR;

        if($buscar==''){

      
            $tarjetas = ClienteTarjeta::join('clientes','clientes_tarjetas.idcliente','=','clientes.id')
            ->join('tarjeta','clientes_tarjetas.idtarjeta','=','tarjeta.id')
            ->join('bancos','clientes_tarjetas.idbanco','=','bancos.id')
            ->select('clientes_tarjetas.id','clientes_tarjetas.idcliente','clientes_tarjetas.idtarjeta','clientes_tarjetas.idbanco',
            'clientes_tarjetas.ntarjeta','clientes_tarjetas.estado','bancos.nombre as nombre_banco',
            'clientes.nombre as nombre_cliente','clientes_tarjetas.created_at','tarjeta.nombre as nombre_tarjeta')
            ->orderBy('clientes_tarjetas.id', 'desc')->paginate(3);

        } else{

         
            $tarjetas = ClienteTarjeta::join('clientes','clientes_tarjetas.idcliente','=','clientes.id')
            ->join('tarjeta','clientes_tarjetas.idtarjeta','=','tarjeta.id')
            ->join('bancos','clientes_tarjetas.idbanco','=','bancos.id')
            ->select('clientes_tarjetas.id','clientes_tarjetas.idcliente','clientes_tarjetas.idtarjeta','clientes_tarjetas.idbanco',
            'clientes_tarjetas.ntarjeta','clientes_tarjetas.estado','bancos.nombre as nombre_banco',
            'clientes.nombre as nombre_cliente','clientes_tarjetas.created_at','tarjeta.nombre as nombre_tarjeta')
            ->where('clientes_tarjetas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('clientes_tarjetas.id', 'desc')->paginate(3);
        }

      
        return['tarjetas' =>$tarjetas];
    
    }

    public function store(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $tarjetas= new Tarjeta();
        $tarjetas->nombre = $request->nombre;
        $tarjetas->descripcion = $request->descripcion;
        $tarjetas->externa = $request->externa;
        $tarjetas->idbancos = $request->idbancos;
        $tarjetas->condicion = '1';

        $tarjetas->save();
    }

    public function storeClienteTarjeta(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tarjetacli= new ClienteTarjeta();
        $tarjetacli->idcliente = $request->idcliente;
        $tarjetacli->idtarjeta = $request->idtarjeta;
        $tarjetacli->tarjeta = $request->tarjeta;
        $tarjetacli->idbanco = $request->idbanco;
        $tarjetacli->ntarjeta = $request->ntarjeta;
        $tarjetacli->estado = 'Activo';

        $tarjetacli->save();

    }

    public function update(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $tarjetas= Tarjeta::findOrFail($request->id);
        $tarjetas->nombre = $request->nombre;
        $tarjetas->descripcion = $request->descripcion;
        $tarjetas->externa = $request->externa;
        $tarjetas->idbancos = $request->idbancos;
        $tarjetas->condicion = '1';
        $tarjetas->save();
    }

    public function updatetarcliente(Request $requst)
    {
        if(!$request->ajax()) return redirect('/');
        $tarjetacli= ClienteTarjeta::findorFail($request->id);
        $tarjetacli->idcliente = $request->idcliente;
        $tarjetacli->idtarjeta = $request->idtarjeta;
        $tarjetacli->tarjeta = $request->nombre_tarjeta;
        $tarjetacli->idbanco = $request->idbanco;
        $tarjetacli->ntarjeta = $request->ntarjeta;
        $tarjetacli->estado = 'Activo';
        $tarjetacli->save();


    }

    public function desactivar(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $tarjetas= Tarjeta::findOrFail($request->id);
        $tarjetas->condicion= '0';
        $tarjetas->save();
    }

    public function activar(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $tarjetas= Tarjeta::findOrFail($request->id);
        $tarjetas->condicion= '1';
        $tarjetas->save();
    }

}
