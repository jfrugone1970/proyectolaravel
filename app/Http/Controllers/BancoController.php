<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Banco;
use App\Cliente;
use App\ClienteBanco;
use App\ClienteTarjeta;

class BancoController extends Controller
{
    public function index(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if($buscar==''){

            $bancos= Banco::orderBy('id','desc')->paginate(3);

        } else{

            $bancos= Banco::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(3);
        }

         
        return[

            'pagination' => [
            'total'            => $bancos->total(),
            'current_page'     => $bancos->currentPage(),
            'per_page'         => $bancos->perPage(),
            'last_page'        => $bancos->lastPage(),
            'from'             => $bancos->firstItem(),
            'to'               => $bancos->lastItem(),
           
            ],

            'bancos' =>$bancos

        ];
       
    }

    Public function listarBancosTotal(Request $request){

        if(!$request->ajax()) return redirect('/');

        $buscar= $request->buscarQ;
        $criterio= $request->criterioQ;

        if($buscar==''){

            $bancos= Banco::orderBy('id','desc')->paginate(3);

        } else{

            $bancos= Banco::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(3);
        }

        return ['bancos'=>$bancos];

    }

    public function listarPDF(){

        $clienteban = ClienteBanco::join('clientes','clientes_banco.idcliente','=','clientes.id')
        ->join('bancos','clientes_banco.idbanco','=','bancos.id')
        ->select('clientes_banco.idcliente','clientes_banco.idbanco','clientes.nombre as nombre_cliente',
        'bancos.nombre as nombre_banco','clientes_banco.tipo_cta','clientes_banco.cuenta',
        'clientes_banco.estado')
        ->orderBy('bancos.nombre', 'desc')->get();

        $cont=ClienteBanco::count();

        
        $hoy = Carbon::now()->format('d/m/Y');
        $pdf= \PDF::loadView('pdf.bancospdf',['clienteban'=>$clienteban,'cont'=>$cont]);
        return $pdf->download('bancos-'.$hoy.'.pdf');

        //return $pdf->download('bancos.pdf');
        

    }

    public function selectBancos(Request $request){

        if(!$request->ajax()) return redirect('/');
        $bancos = Banco::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre','asc')->get(); 
        
        return ['bancos' => $bancos];
    }

    public function selectClientesBanco(Request $request){

        if(!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;

        $clienteban = DB::table('clientes_banco')
        ->join('clientes','clientes_banco.idcliente','=','clientes.id')
        ->join('bancos','clientes_banco.idbanco','=','bancos.id')
        ->select('clientes_banco.idcliente','clientes_banco.idbanco','clientes_banco.tipo_cta',
        'clientes_banco.cuenta','clientes_banco.estado','bancos.nombre as nombre_banco',
        'clientes.nombre as nombre_cliente','clientes,tipo_documento','clientes.num_documento')
        ->where('clientes_banco.idcliente','=',$filtro)
        ->orderBy('clientes_banco.idcliente', 'desc')->get();
    
    }

    
    public function listarBcoCliente(Request $request){

        if(!$request->ajax()) return redirect('/');

        $buscar= $request->buscarQ;
        $criterio= $request->criterioQ;

        if($buscar==''){

      
            $bancoc = ClienteBanco::join('clientes','clientes_banco.idcliente','=','clientes.id')
            ->join('bancos','clientes_banco.idbanco','=','bancos.id')
            ->select('clientes_banco.id','clientes_banco.idcliente','clientes_banco.idbanco','clientes_banco.banco','clientes_banco.tipo_cta',
            'clientes_banco.cuenta as numero_cuenta','clientes_banco.estado','clientes_banco.banco',
            'clientes.nombre as nombre_cliente')
            ->orderBy('clientes_banco.id', 'desc')->paginate(3);

        } else{

         
            $bancoc = ClienteBanco::join('clientes','clientes_banco.idcliente','=','clientes.id')
            ->join('bancos','clientes_banco.idbanco','=','bancos.id')
            ->select('clientes_banco.id','clientes_banco.idcliente','clientes_banco.idbanco',
            'clientes_banco.banco','clientes_banco.tipo_cta','clientes_banco.cuenta as numero_cuenta',
            'clientes_banco.estado','clientes_banco.banco','clientes.nombre as nombre_cliente')
            ->where('clientes_banco.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('clientes_banco.id', 'desc')->paginate(3);
        }

      
        return['bancoc' =>$bancoc];


    }

    public function indexClientesBanco(Request $request){

        if(!$request->ajax()) return redirect('/');

        $clienteban = ClienteBanco::join('clientes','clientes_banco.idcliente','=','clientes.id')
        ->join('bancos','clientes_banco.idbanco','=','bancos.id')
        ->select('clientes_banco.id','clientes_banco.idcliente','cliente_banco.idbanco','clientes_banco.tipo_cta',
        'clientes_banco.cuenta','clientes_banco.estado','bancos.nombre as nombre_banco',
        'clientes.nombre as nombre_cliente','clientes.tipo_documento','clientes.num_documento')
        ->where('clientes_banco.id','=',$id)
        ->orderBy('clientes_banco.id', 'desc')->get();

        return [
            'pagination' => [
                'total'        => $clienteban->total(),
                'current_page' => $clienteban->currentPage(),
                'per_page'     => $clienteban->perPage(),
                'last_page'    => $clienteban->lastPage(),
                'from'         => $clienteban->firstItem(),
                'to'           => $clienteban->lastItem(),
            ],
            'clienteban' => $clienteban
        ];

    }




    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $mytime= Carbon::now('America/Guayaquil');
 
            $bancos= new Banco();
            $bancos->nombre= $request->nombre;
            $bancos->descripcion= $request->descripcion;
            $bancos->condicion= '1';

            $bancos->save();
            
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }


    public function storeclientebanco(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        try{

            DB::beginTransaction();

            $mytime= Carbon::now('America/Guayaquil');

            $bancoscli= new ClienteBanco();
            $bancoscli->idcliente= $request->idcliente;
            $bancoscli->idbanco= $request->idbanco;
            $bancoscli->banco= $request->banco;
            $bancoscli->tipo_cta= $request->tipo_cta;
            $bancoscli->cuenta= $request->cuenta;
            $bancoscli->estado= 'Registrada';

            $bancoscli->save();

            DB::commit();
      

        } catch (Exception $e){
            DB::rollback();
        }
    }

    public function buscaBanco(Request $request){

        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $bancos = Banco::where('id','=', $filtro)
        ->select('id','nombre')->orderBy('nombre', 'asc')->take(1)->get();

        return ['bancos' => $bancos];
    
        

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $bancos= Banco::findOrFail($request->id);
        $bancos->nombre= $request->nombre;
        $bancos->descripcion= $request->descripcion;
        $bancos->condicion= '1';
        $bancos->save();
    }

    public function updateclientesbanco(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $bancoscli= ClienteBanco::findOrFail($request->id);
        $bancoscli->banco= $request->nombre->banco;
        $bancoscli->tipo_cta= $request->tipo_cta;
        $bancoscli->cuenta= $request->cuenta;
        $bancoscli->estado= 'Actualizada';

        $bancoscli->save();
    }

    public function desactivar(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $bancos= Banco::findOrFail($request->id);
        $bancos->condicion= '0';
        $bancos->save();
    }

    public function activar(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $bancos= Banco::findOrFail($request->id);
        $bancos->condicion= '1';
        $bancos->save();
    }

}
