<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['guest']], function () {
     
    Route::get('/','Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
});

Route::group(['middleware' => ['auth']], function () {

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/dashboard', 'DashboardController');
      
    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');

    Route::group(['middleware' => ['Comprador']], function () {
         
        Route::get('/categoria', 'CategoriaController@index');
        Route::post('/categoria/registrar', 'CategoriaController@store');
        Route::put('/categoria/actualizar', 'CategoriaController@update');
        Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
        Route::put('/categoria/activar', 'CategoriaController@activar');
        Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');
        Route::get('/categoria/listarPDF', 'CategoriaController@listarPDF');
        
        Route::get('/producto', 'ProductoController@index');
        Route::post('/producto/registrar', 'ProductoController@store');
        Route::put('/producto/actualizar', 'ProductoController@update');
        Route::put('/producto/desactivar', 'ProductoController@desactivar');
        Route::put('/producto/activar', 'ProductoController@activar');
        Route::get('/producto/buscarProducto', 'ProductoController@buscarProducto');
        Route::get('/producto/listarProductos', 'ProductoController@listarProductos'); 
        Route::get('/producto/listarPDF', 'ProductoController@listarPDF')->name('productos_pdf');
        
        Route::get('/proveedor', 'ProveedorController@index');
        Route::post('/proveedor/registrar', 'ProveedorController@store');
        Route::put('/proveedor/actualizar', 'ProveedorController@update');
        Route::get('/proveedor/selectProveedor', 'ProveedorController@selectProveedor');
        Route::get('/proveedor/listarPDF', 'ProveedorController@listarPDF')->name('proveedores_pdf');
        
        Route::get('/compra', 'CompraController@index');
        Route::post('/compra/registrar', 'CompraController@store');
        Route::put('/compra/desactivar', 'CompraController@desactivar');
        Route::get('/compra/buscarc', 'CompraController@buscarCompra');
        Route::get('/compra/obtenerCabecera', 'CompraController@obtenerCabecera');
        Route::get('/compra/obtenerDetalles', 'CompraController@obtenerDetalles');
        Route::get('/compra/pdf{id}', 'CompraController@pdf')->name('compra_pdf');
        
    });

    Route::group(['middleware' => ['Vendedor']], function () {

        Route::get('/categoria', 'CategoriaController@index');
        Route::post('/categoria/registrar', 'CategoriaController@store');
        Route::put('/categoria/actualizar', 'CategoriaController@update');
        Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
        Route::put('/categoria/activar', 'CategoriaController@activar');
        Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');
        Route::get('/categoria/listarPDF', 'CategoriaController@listarPDF');
        
        Route::get('/producto', 'ProductoController@index');
        Route::post('/producto/registrar', 'ProductoController@store');
        Route::put('/producto/actualizar', 'ProductoController@update');
        Route::put('/producto/desactivar', 'ProductoController@desactivar');
        Route::put('/producto/activar', 'ProductoController@activar');
        Route::get('/producto/buscarProducto', 'ProductoController@buscarProducto');
        Route::get('/producto/listarProductos', 'ProductoController@listarProductos');
        Route::get('/producto/buscarProductoVenta', 'ProductoController@buscarProductoVenta');
        Route::get('/producto/listarProductoVenta', 'ProductoController@listarProductoVenta');
        Route::get('/producto/listarPDF', 'ProductoController@listarPDF')->name('productos_pdf');
        
        Route::get('/cliente', 'ClienteController@index');
        Route::post('/cliente/registrar', 'ClienteController@store');
        Route::put('/cliente/actualizar', 'ClienteController@update');
        Route::get('/cliente/selectCliente', 'ClienteController@selectCliente');
        Route::get('/cliente/buscaCliente', 'ClienteController@buscaCliente');
        Route::get('/cliente/listarCliente', 'ClienteController@listarClientesTotal');
        Route::get('/cliente/listarPDF', 'ClienteController@listarPDF');
    
        Route::get('/venta', 'VentaController@index');
        Route::post('/venta/registrar', 'VentaController@store');
        Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
        Route::get('/venta/obtenerDetalle', 'VentaController@obtenerDetalle');
        Route::get('/venta/selectFormaPago', 'VentaController@selectFormaPago');
        Route::get('/venta/buscarv', 'VentaController@buscarVenta');
        Route::put('/venta/desactivar', 'VentaController@desactivar');
        Route::get('/venta/pdf{id}', 'VentaController@pdf')->name('venta_pdf');

        Route::get('/detalle', 'DashboardDetalleController');

        Route::get('/bancos', 'BancoController@index');
        Route::get('/bancos/selectBancos', 'BancoController@selectBancos');
        Route::get('/bancos/busquedaClientesBanco', 'BancoController@selectClientesBanco');
        Route::get('/bancos/listarBcosCli', 'BancoController@listarBcoCliente');
        Route::get('/bancos/indexClientesBanco', 'BancoController@indexClientesBanco');
        Route::get('/bancos/listarPDF', 'BancoController@listarPDF');
        Route::get('/bancos/listarBancos', 'BancoController@listarBancosTotal');
        Route::post('/bancos/registrar', 'BancoController@store');
        Route::get('/bancos/buscaBanco', 'BancoController@buscaBanco');
        Route::post('/bancos/registrarclibanco', 'BancoController@storeclientebanco');
        Route::put('/bancos/actualizar', 'BancoController@update');
        Route::put('/bancos/actualizarcliebancos', 'BancoController@updateclientesbanco');
        Route::put('/bancos/desactivar', 'BancoController@desactivar');
        Route::put('/bancos/activar', 'BancoController@activar');

        Route::get('/tarjetas', 'TarjetaController@index');
        Route::get('/tarjetas/listarTarjetas', 'TarjetaController@listarTarjetas');
        Route::get('/tarjetas/listaclitarjeta', 'TarjetaController@listarClienteTarjeta');
        Route::get('/tarjetas/listarPDF', 'TarjetaController@listarPDF');
        Route::get('/tarjetas/selectTarjetas', 'TarjetaController@selectTarjetas');
        Route::get('/tarjetas/listarTarCliente', 'TarjetaController@listarTarjetasTotal');
        Route::post('/tarjetas/registrar', 'TarjetaController@store');
        Route::post('/tarjetas/registrarclitarjeta', 'TarjetaController@storeClienteTarjeta');
        Route::put('/tarjetas/actualizar', 'TarjetaController@update');
        Route::put('/tarjetas/updatetarcliente', 'TarjetaController@updatetarcliente');
        Route::put('/tarjetas/desactivar', 'TarjetaController@desactivar');
        Route::put('/tarjetas/activar', 'TarjetaController@activar');

        Route::get('/pago/listar', 'PagoController@index');
        Route::post('/pago/pagar', 'PagoController@store');
            
    });

    Route::group(['middleware' => ['Administrador']], function () {

        Route::get('/categoria', 'CategoriaController@index');
        Route::post('/categoria/registrar', 'CategoriaController@store');
        Route::put('/categoria/actualizar', 'CategoriaController@update');
        Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
        Route::put('/categoria/activar', 'CategoriaController@activar');
        Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');
        Route::get('/categoria/listarPDF', 'CategoriaController@listarPDF');
        
        Route::get('/producto', 'ProductoController@index');
        Route::post('/producto/registrar', 'ProductoController@store');
        Route::put('/producto/actualizar', 'ProductoController@update');
        Route::put('/producto/desactivar', 'ProductoController@desactivar');
        Route::put('/producto/activar', 'ProductoController@activar');
        Route::get('/producto/buscarProducto', 'ProductoController@buscarProducto');
        Route::get('/producto/listarProductos', 'ProductoController@listarProductos');
        Route::get('/producto/buscarProductoVenta', 'ProductoController@buscarProductoVenta');
        Route::get('/producto/listarProductoVenta', 'ProductoController@listarProductoVenta');
        Route::get('/producto/listarPDF', 'ProductoController@listarPDF')->name('productos_pdf');
        
        Route::get('/proveedor', 'ProveedorController@index');
        Route::post('/proveedor/registrar', 'ProveedorController@store');
        Route::put('/proveedor/actualizar', 'ProveedorController@update');
        Route::get('/proveedor/selectProveedor', 'ProveedorController@selectProveedor');
        Route::get('/proveedor/listarPDF', 'ProveedorController@listarPDF')->name('proveedores_pdf');
        

        Route::get('/compra', 'CompraController@index');
        Route::post('/compra/registrar', 'CompraController@store');
        Route::put('/compra/desactivar', 'CompraController@desactivar');
        Route::get('/compra/buscarc', 'CompraController@buscarCompra');
        Route::get('/compra/obtenerCabecera', 'CompraController@obtenerCabecera');
        Route::get('/compra/obtenerDetalles', 'CompraController@obtenerDetalles');
        Route::get('/compra/pdf{id}', 'CompraController@pdf')->name('compra_pdf');
              
        Route::get('/cliente', 'ClienteController@index');
        Route::post('/cliente/registrar', 'ClienteController@store');
        Route::put('/cliente/actualizar', 'ClienteController@update');
        Route::get('/cliente/selectCliente', 'ClienteController@selectCliente');
        Route::get('/cliente/buscaCliente', 'ClienteController@buscaCliente');
        Route::get('/cliente/listarCliente', 'ClienteController@listarClientesTotal');
        Route::get('/cliente/listarPDF', 'ClienteController@listarPDF');

        Route::get('/venta', 'VentaController@index');
        Route::post('/venta/registrar', 'VentaController@store');
        Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
        Route::get('/venta/obtenerDetalle', 'VentaController@obtenerDetalle');
        Route::get('/venta/buscarv', 'VentaController@buscarVenta');
        Route::get('/venta/selectFormaPago', 'VentaController@selectFormaPago');
        Route::put('/venta/desactivar', 'VentaController@desactivar');
        Route::get('/venta/pdf{id}', 'VentaController@pdf')->name('venta_pdf');
               
        Route::get('/rol', 'RolController@index');
        Route::get('/rol/selectRol', 'RolController@selectRol');
        
        Route::get('/user', 'UserController@index');
        Route::post('/user/registrar', 'UserController@store');
        Route::put('/user/actualizar', 'UserController@update');
        Route::put('/user/desactivar', 'UserController@desactivar');
        Route::put('/user/activar', 'UserController@activar');

        Route::get('/detalle', 'DashboardDetalleController');

        Route::get('/bancos', 'BancoController@index');
        Route::get('/bancos/selectBancos', 'BancoController@selectBancos');
        Route::get('/bancos/busquedaClientesBanco', 'BancoController@selectClientesBanco');
        Route::get('/bancos/indexClientesBanco', 'BancoController@indexClientesBanco');
        Route::get('/bancos/listarPDF', 'BancoController@listarPDF');
        Route::get('/bancos/buscaBanco', 'BancoController@buscaBanco');
        Route::get('/bancos/listarBancos', 'BancoController@listarBancosTotal');
        Route::get('/bancos/listarBcosCli', 'BancoController@listarBcoCliente');
        Route::post('/bancos/registrar', 'BancoController@store');
        Route::post('/bancos/registrarclibanco', 'BancoController@storeclientebanco');
        Route::put('/bancos/actualizar', 'BancoController@update');
        Route::put('/bancos/actualizarcliebancos', 'BancoController@updateclientesbanco');
        Route::put('/bancos/desactivar', 'BancoController@desactivar');
        Route::put('/bancos/activar', 'BancoController@activar');

        Route::get('/tarjetas', 'TarjetaController@index');
        Route::get('/tarjetas/listarTarjetas', 'TarjetaController@listarTarjetas');
        Route::get('/tarjetas/listaclitarjeta', 'TarjetaController@listarClienteTarjeta');
        Route::get('/tarjetas/selectTarjetas', 'TarjetaController@selectTarjetas');
        Route::get('/tarjetas/listarPDF', 'TarjetaController@listarPDF');
        Route::get('/tarjetas/listarTarCliente', 'TarjetaController@listarTarjetasTotal');
        Route::post('/tarjetas/registrar', 'TarjetaController@store');
        Route::post('/tarjetas/registrarclitarjeta', 'TarjetaController@storeClienteTarjeta');
        Route::put('/tarjetas/actualizar', 'TarjetaController@update');
        Route::put('/tarjetas/updatetarcliente', 'TarjetaController@updatetarcliente');
        Route::put('/tarjetas/desactivar', 'TarjetaController@desactivar');
        Route::put('/tarjetas/activar', 'TarjetaController@activar');

        Route::get('/pago/listar', 'PagoController@index');
        Route::post('/pago/pagar', 'PagoController@store');
        
    });
    
      
});




//Route::get('/home', 'HomeController@index')->name('home');
