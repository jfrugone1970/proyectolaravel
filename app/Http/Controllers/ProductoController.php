<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;

class ProductoController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if($buscar==''){

            $productos= Producto::join('categorias','productos.idcategoria','=','categorias.id')
            ->select('productos.id','productos.idcategoria','productos.codigo','productos.nombre','categorias.nombre as nombre_categoria','productos.precio_venta','productos.stock','productos.condicion','productos.imagen')
            ->orderBy('productos.id', 'desc')->paginate(3);

        } else{

            $productos = Producto::join('categorias','productos.idcategoria','=','categorias.id')
            ->select('productos.id','productos.idcategoria','productos.codigo','productos.nombre','categorias.nombre as nombre_categoria','productos.precio_venta','productos.stock','productos.condicion','productos.imagen')
            ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('productos.id', 'desc')->paginate(3);
        }

         
        return[

            'pagination' => [
            'total'            => $productos->total(),
            'current_page'     => $productos->currentPage(),
            'per_page'         => $productos->perPage(),
            'last_page'        => $productos->lastPage(),
            'from'             => $productos->firstItem(),
            'to'               => $productos->lastItem(),
           
            ],

            'productos' =>$productos

        ];
       
    }

    public function listarProductos(Request $request){

        //
        if(!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if($buscar==''){

            $productos= Producto::join('categorias','productos.idcategoria','=','categorias.id')
            ->select('productos.id','productos.idcategoria','productos.codigo','productos.nombre','categorias.nombre as nombre_categoria','productos.precio_venta','productos.stock','productos.condicion','productos.imagen')
            ->orderBy('productos.id', 'desc')->paginate(3);

        } else{

            $productos = Producto::join('categorias','productos.idcategoria','=','categorias.id')
            ->select('productos.id','productos.idcategoria','productos.codigo','productos.nombre','categorias.nombre as nombre_categoria','productos.precio_venta','productos.stock','productos.condicion','productos.imagen')
            ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('productos.id', 'desc')->paginate(3);
        }

         
        return['productos' =>$productos];


    }

    Public function listarProductoVenta(Request $request){

        if(!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if($buscar==''){

            $productos= Producto::join('categorias','productos.idcategoria','=','categorias.id')
            ->select('productos.id','productos.idcategoria','productos.codigo','productos.nombre','categorias.nombre as nombre_categoria','productos.precio_venta','productos.stock','productos.condicion','productos.imagen')
            ->where('productos.stock','>','0')
            ->orderBy('productos.id', 'desc')->paginate(10);

        } else{

            $productos = Producto::join('categorias','productos.idcategoria','=','categorias.id')
            ->select('productos.id','productos.idcategoria','productos.codigo','productos.nombre','categorias.nombre as nombre_categoria','productos.precio_venta','productos.stock','productos.condicion','productos.imagen')
            ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
            ->where('productos.stock','>','0')
            ->orderBy('productos.id', 'desc')->paginate(10);
        }

         
        return['productos' =>$productos];

    }

    public function listarPDF(){

        $productos = Producto::join('categorias','productos.idcategoria','=','categorias.id')
        ->select('productos.id','productos.idcategoria','productos.codigo','productos.nombre','categorias.nombre as nombre_categoria','productos.precio_venta','productos.stock','productos.condicion')
        ->orderBy('productos.nombre', 'desc')->get();

        $cont=Producto::count();

        $pdf= \PDF::loadView('pdf.productospdf',['productos'=>$productos,'cont'=>$cont]);
        return $pdf->download('productos.pdf');
        

    }

    public function buscarProducto(Request $request){
 
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $productos = Producto::where('codigo','=', $filtro)
        ->select('id','nombre')->orderBy('nombre', 'asc')->take(1)->get();

        return ['productos' => $productos];
    
    }

    public function buscarProductoVenta(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $productos = Producto::where('codigo','=', $filtro)
        ->select('id','nombre','stock','precio_venta')
        ->where('stock','>','0')
        ->orderBy('nombre', 'asc')
        ->take(1)->get();

        return ['productos' => $productos];

    }

    public function store(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $producto= new Producto();
        $producto->idcategoria = $request->idcategoria;
        $producto->codigo = $request->codigo;
        $producto->nombre = $request->nombre;
        $producto->precio_venta = $request->precio_venta;
        $producto->stock = $request->stock;
        $producto->condicion = '1';

        //inicio registrar imagen
           $exploded = explode(',',$request->imagen);
           $decoded = base64_decode($exploded[1]);

           if(str_contains($exploded[0],'jpeg')){

               $extension = 'jpg';

           } else {
               $extension = 'png';

           }

           $fileName = str_random().'.'.$extension;


           $path = public_path().'/img/producto/'.$fileName;

           file_put_contents($path,$decoded);

           $producto->imagen = $fileName;

           //fin registro imagen

        $producto->save();
    }

    public function update(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $producto= Producto::findOrFail($request->id);
        $producto->idcategoria = $request->idcategoria;
        $producto->codigo = $request->codigo;
        $producto->nombre = $request->nombre;
        $producto->precio_venta = $request->precio_venta;
        $producto->stock = $request->stock;
        $producto->condicion = '1';

           //Editar imagen

           $currentPhoto = $producto->imagen;

           if($request->imagen != $currentPhoto){

            $exploded = explode(',',$request->imagen);
               $decoded = base64_decode($exploded[1]);

               if(str_contains($exploded[0],'jpeg')){

                  $extension = 'jpg';

               } else{

                  $extension = 'png';

               }

               $fileName = str_random().'.'.$extension;

               $path = public_path().'/img/producto/'.$fileName;

               file_put_contents($path,$decoded);

               /*Inicio eliminar del servidor*/
               $productoImagen = public_path('/img/producto/').$currentPhoto;
               if(file_exists($productoImagen)){
                   @unlink($productoImagen);

               }

               $producto->imagen = $fileName;
        
               /*fin eliminal del servidor*/


           }

           
               
           /*fin editar imagen*/

        $producto->save();
    }

    public function desactivar(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $producto= Producto::findOrFail($request->id);
        $producto->condicion= '0';
        $producto->save();
    }

    public function activar(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $producto= Producto::findOrFail($request->id);
        $producto->condicion= '1';
        $producto->save();
    }


}
