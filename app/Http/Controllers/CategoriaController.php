<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if($buscar==''){

            $categorias= Categoria::orderBy('id','desc')->paginate(3);

        } else{

            $categorias= Categoria::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(3);
        }

         
        return[

            'pagination' => [
            'total'            => $categorias->total(),
            'current_page'     => $categorias->currentPage(),
            'per_page'         => $categorias->perPage(),
            'last_page'        => $categorias->lastPage(),
            'from'             => $categorias->firstItem(),
            'to'               => $categorias->lastItem(),
           
            ],

            'categorias' =>$categorias

        ];
       
    }

    public function listarPDF(){

        $categorias= Categoria::orderBy('id','desc')->get();

        $cont=Categoria::count();

        $pdf= \PDF::loadView('pdf.categoriaspdf',['categorias'=>$categorias,'cont'=>$cont]);
        return $pdf->download('categorias.pdf');
    }

    public function selectCategoria(Request $request){

        if(!$request->ajax()) return redirect('/');
        $categorias = Categoria::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre','asc')->get(); 
        
        return ['categorias' => $categorias];
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $categoria= new Categoria();
        $categoria->nombre= $request->nombre;
        $categoria->descripcion= $request->descripcion;
        $categoria->condicion= '1';

        //inicio registrar imagen
        $exploded = explode(',',$request->imagen);
        $decoded = base64_decode($exploded[1]);

        if(str_contains($exploded[0],'jpeg')){

            $extension = 'jpg';

        } else {
            $extension = 'png';

        }

        $fileName = str_random().'.'.$extension;


        $path = public_path().'/img/categoria/'.$fileName;

        file_put_contents($path,$decoded);

        $categoria->imagen = $fileName;

        //fin registro imagen
        $categoria->save();
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
        $categoria= Categoria::findOrFail($request->id);
        $categoria->nombre= $request->nombre;
        $categoria->descripcion= $request->descripcion;
        $categoria->condicion= '1';

         //Editar imagen

         $currentPhoto = $categoria->imagen;

         if($request->imagen != $currentPhoto){

          $exploded = explode(',',$request->imagen);
             $decoded = base64_decode($exploded[1]);

             if(str_contains($exploded[0],'jpeg')){

                $extension = 'jpg';

             } else{

                $extension = 'png';

             }

             $fileName = str_random().'.'.$extension;

             $path = public_path().'/img/categoria/'.$fileName;

             file_put_contents($path,$decoded);

             /*Inicio eliminar del servidor*/
             $categoriaImagen = public_path('/img/categoria/').$currentPhoto;
             if(file_exists($categoriaImagen)){
                 @unlink($categoriaImagen);

             }

             $categoria->imagen = $fileName;
      
             /*fin eliminal del servidor*/


         }

        $categoria->save();
    }

    public function desactivar(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $categoria= Categoria::findOrFail($request->id);
        $categoria->condicion= '0';
        $categoria->save();
    }

    public function activar(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $categoria= Categoria::findOrFail($request->id);
        $categoria->condicion= '1';
        $categoria->save();
    }

    
}
