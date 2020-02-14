<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    //

    public function index(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if($buscar==''){

            $usuarios = User::join('roles','users.idrol','=','roles.id')
            ->select('users.id','users.nombre','users.tipo_documento',
            'users.num_documento','users.direccion','users.telefono',
            'users.email','users.usuario','users.password',
            'users.condicion','users.idrol','users.imagen','roles.nombre as rol')
            ->orderBy('id', 'desc')->paginate(3);

        } else{

            $usuarios = User::join('roles','users.idrol','=','roles.id')
            ->select('users.id','users.nombre','users.tipo_documento',
            'users.num_documento','users.direccion','users.telefono',
            'users.email','users.usuario','users.password',
            'users.condicion','users.idrol','users.imagen','roles.nombre as rol')
            ->where('users.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('id', 'desc')->paginate(3);
        }

         
        return[

            'pagination' => [
            'total'            => $usuarios->total(),
            'current_page'     => $usuarios->currentPage(),
            'per_page'         => $usuarios->perPage(),
            'last_page'        => $usuarios->lastPage(),
            'from'             => $usuarios->firstItem(),
            'to'               => $usuarios->lastItem(),
           
            ],

            'usuarios' =>$usuarios

        ];
       
    }

    public function store(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $user= new User();
        $user->nombre = $request->nombre;
        $user->tipo_documento = $request->tipo_documento;
        $user->num_documento = $request->num_documento;
        $user->telefono = $request->telefono;
        $user->email = $request->email;
        $user->direccion = $request->direccion;
        $user->usuario = $request->usuario;
        $user->password = bcrypt( $request->password);
        $user->condicion = '1';
        $user->idrol = $request->idrol;

             //inicio registrar imagen
             $exploded = explode(',',$request->imagen);
           
             $decoded = base64_decode($exploded[1]);
             
             if(str_contains($exploded[0],'jpeg')){

                $extension = 'jpg';

             } else {
                
                $extension = 'png';

             }

             $fileName = str_random().'.'.$extension;

             $path = public_path().'/img/usuario/'.$fileName;
        

             file_put_contents($path,$decoded);

             $user->imagen = $fileName;

             //fin registrar imagen

        $user->save();
    }

    public function update(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $user= User::findOrFail($request->id);
        $user->nombre = $request->nombre;
        $user->tipo_documento = $request->tipo_documento;
        $user->num_documento = $request->num_documento;
        $user->telefono = $request->telefono;
        $user->email = $request->email;
        $user->direccion = $request->direccion;
        $user->usuario = $request->usuario;
        $user->password = bcrypt( $request->password);
        $user->condicion = '1';
        $user->idrol = $request->idrol;
        
        //Editar imagen

        $currentPhoto = $user->imagen;

        if($request->imagen != $currentPhoto){

               $exploded = explode(',',$request->imagen);
               $decoded = base64_decode($exploded[1]);

               if(str_contains($exploded[0],'jpeg')){

                  $extension = 'jpg';

               } else{

                  $extension = 'png';

               }

               $fileName = str_random().'.'.$extension;

               $path = public_path().'/img/usuario/'.$fileName;

               file_put_contents($path,$decoded);

               /*Inicio eliminar del servidor*/
               $usuarioImagen = public_path('/img/usuario/').$currentPhoto;
               if(file_exists($usuarioImagen)){
                   @unlink($usuarioImagen);

               }


        //Fin editar imagen

               $user->imagen = $fileName;
      

        }

        $user->save();
    }

    public function desactivar(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $user= User::findOrFail($request->id);
        $user->condicion= '0';
        $user->save();
    }

    public function activar(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $user= User::findOrFail($request->id);
        $user->condicion= '1';
        $user->save();
    }
}
