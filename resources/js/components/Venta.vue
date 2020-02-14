<template>
   <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="/">BACKEND - SISTEMA DE COMPRAS - VENTAS</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">

                    <template v-if="listado==1">
                    <div class="card-header">

                       <h2>Listado de Ventas</h2><br/>
                      
                        <button class="btn btn-primary btn-lg" type="button" @click="mostrarDetalle()">
                            <i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Nueva Venta
                        </button>
                    </div>
                    <!--listado-->
                   
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="tipo_identificacion">Tipo identificación</option>
                                      <option value="num_venta">Número Venta</option>
                                      <option value="fecha_venta">Fecha Venta</option>
                                    </select>
                                    <input type="text"  @keyup.enter="listarVenta(1,buscar,criterio);" v-model="buscar" class="form-control" placeholder="Buscar texto">
                                    <button type="submit"  @click="listarVenta(1,buscar,criterio);" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr class="bg-primary">
                                   
                                        <th>Ver Detalle</th>
                                        <th>Fecha Venta</th>
                                        <th>Número Venta</th>
                                        <th>Cliente</th>
                                        <th>Tipo de identificación</th>
                                        <th>Vendedor</th>  
                                        <th>Total (USD$)</th>
                                        <th>Impuesto</th>
                                        <th>Estado</th>
                                        <th>Cambiar estado</th>
                                        <th>Descargar Reporte</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                <tr v-for="venta in arrayVenta" :key="venta.id">
                                    
                                        <td>
                                             <!--compra.id-->
                                            <button type="button" @click="verVenta(venta.id)" class="btn btn-warning btn-sm">
                                            <i class="fa fa-eye fa-2x"></i> Ver detalle
                                            </button> &nbsp;

                                         </td>
                                        <td v-text="venta.fecha_venta"></td>
                                        <td v-text="venta.num_venta"></td>
                                        <td v-text="venta.nombre"></td>
                                        <td v-text="venta.tipo_identificacion"></td> 
                                        <td v-text="venta.usuario"></td> 
                                        <td v-text="venta.total"></td>
                                        <td v-text="venta.impuesto"></td>
                                        <td>

                                             <button type="button" v-if="venta.estado=='Registrado'" class="btn btn-success btn-sm">
                                                <i class="fa fa-check fa-2x"></i> Registrado
                                            </button>
                                        
                                            <button type="button" v-else class="btn btn-danger btn-sm">
                                                 <i class="fa fa-times fa-2x"></i> Anulado
                                            </button>

                                        </td>

                                         <td>
                                            <template v-if="venta.estado=='Registrado'">
                                                <button type="button" class="btn btn-danger btn-sm" @click="desactivarVenta(venta.id)">
                                                    <i class="fa fa-times fa-2x"></i> Anular Venta
                                                </button>
                                            </template>

                                            <template v-else>
                                                <button type="button" class="btn btn-danger btn-sm">
                                                     <i class="fa fa-check fa-2x"></i> Cambiado
                                                </button>
                                            </template>
                                        </td>

                                        <td>
                                            
                                             <button type="button" @click="pdfVenta(venta.id,venta.estado)" class="btn btn-info btn-sm">
                                            <i class="fa fa-file fa-2x"></i> Descargar PDF
                                            </button> &nbsp;
                                        </td>

                                    
                                </tr>
                               
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-f="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Anterior</a>
                                </li>

                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                               
                               
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Siguiente</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    </template>
                    <!--fin listado-->

                    <!-- Detalle-->

                    <template v-else-if="listado==0">
                  
                    <span><strong>(*) Campo obligatorio</strong></span><br/>

                    <h3 class="text-center">LLenar el formulario</h3>
                    
                    <div class="card-body">

                        <div class="form-group row border">

                             <div class="col-md-8">
                                <div class="form-group">
                                    <label class="text-uppercase"><strong>Número Venta(*)</strong></label>
                                    <input type="text" class="form-control" @keyup.enter="buscarNumVenta();" v-model="num_venta" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="text-uppercase"><strong>Cliente(*)</strong></label>
                                    <v-select
                                        :on-search="selectCliente"
                                        label="nombre"
                                        :options="arrayCliente"
                                        placeholder="Buscar Clientes..."
                                        :onChange="getDatosCliente"                                        
                                    >

                                    </v-select>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="text-uppercase"><strong>Tipo Identificación(*)</strong></label>
                                    <select class="form-control" v-model="tipo_identificacion">
                                        <option value="0">Seleccione</option>
                                        <option value="FACTURA">Factura</option>
                                        <option value="TICKET">Ticket</option>
                                        <option value="N/V">Nota_vta</option>
                                        <option value="PROFORMA">Proforma</option>
                                      
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <label class="text-uppercase"><strong>Impuesto(*)</strong></label>
                                <input type="text" class="form-control" v-model="impuesto">
                            </div>
                            
                                 
                        </div>


                        <div class="form-group row">

                            <div class="col-md-12">
                                    <div v-show="errorVenta" class="form-group row div-error">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMostrarMsjVenta" :key="error" v-text="error">

                                            </div>
                                        </div>
                                    </div>
                                </div>

                        </div>


                        <div class="form-group row border">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Producto <span class="text-error" v-show="idproducto==0">(*Ingrese código del producto)</span></label>
                                    <div class="form-inline">
                                        <input type="text" class="form-control" v-model="codigo" @keyup.enter="buscarProducto()" placeholder="Ingrese código">
                                        <button @click="abrirModal()" class="btn btn-primary">
                                           
                                           <i class="fa fa-plus"></i>&nbsp;Agregar Productos

                                        </button>
                                        <input type="text" readonly class="form-control" v-model="producto">
                                    </div>                                    
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Precio <span class="text-error" v-show="precio==0">(*Ingrese un valor)</span></label>
                                    <input type="number" value="0" step="any" class="form-control" v-model="precio">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Cantidad <span class="text-error" v-show="cantidad==0">(*Ingrese un valor)</span></label>
                                    <input type="number" value="0" class="form-control" v-model="cantidad">
                                </div>
                            </div>

                             <div class="col-md-2">
                                <div class="form-group">
                                    <label>Descuento </label>
                                    <input type="number" value="0" class="form-control" v-model="descuento">
                                </div>
                            </div>

                            

                            <div class="col-md-2">
                                <div class="form-group">
                                    <button @click="agregarDetalle()" class="btn btn-primary form-control btnagregar"><i class="fa fa-plus fa-2x"></i> Agregar detalle</button>
                                </div>
                            </div>

                            <div class="col-md-2">
                                    <label class="text-uppercase"><strong>Forma Pago(*)</strong></label>
                                    <v-select
                                        :on-search="selectFormaPago"
                                        label="nombre"
                                        :options="arrayFormaPago"
                                        placeholder="Buscar Forma..."
                                        :onChange="getDatosForma"                                        
                                    >

                                    </v-select>
                                    
                                  
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <button @click="verificaforma()" class="btn btn-primary form-control btnagregar"><i class="fa fa-plus fa-2x"></i> Verifica Ctas</button>                   
                                </div>

                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <button v-if="idforma==2" @click="registraPagoCheque()" class="btn btn-primary form-control btnagregar"><i class="fa fa-plus fa-2x"></i> Reg Pago Cheque</button>
                                    <button v-if="idforma==3" @click="registraPagoTarjeta()" class="btn btn-primary form-control btnagregar"><i class="fa fa-plus fa-2x"></i> Reg Pago Tarjeta</button>
                                </div>

                            </div>
                        
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button @click="abrirModal1()" class="btn btn-primary form-control btnagregar"><i class="fa fa-plus fa-2x"></i> Agregar cta ctle</button>
                                </div>
                            </div>
                             
                        </div>

                        <br/><br/>

                        <div class="form-group row border">

                            <h3>Lista de Ventas a Clientes</h3>

                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr class="bg-success">
                                            <th>Eliminar</th>
                                            <th>Producto</th>
                                            <th>Precio (USD$)</th>
                                            <th>Cantidad</th>
                                            <th>Descuento</th>
                                            <th>Total (USD$)</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                            <td>
                                                <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-times fa-2x"></i>
                                                </button>
                                            </td>
                                            <td v-text="detalle.producto">
                                            </td>
                                            <td>
                                                <input v-model="detalle.precio" type="number" class="form-control">
                                            </td>
                                            <td>
                                                 <span style="color:red;" v-show="detalle.cantidad>detalle.stock">Stock: {{detalle.stock}}</span>
                                                <input v-model="detalle.cantidad" type="number" class="form-control">
                                            </td>
                                            <td>
                                                 <span style="color:red;" v-show="detalle.descuento>(detalle.precio*detalle.cantidad)">Descuento superior al total</span>
                                                <input v-model="detalle.descuento" type="number" class="form-control">
                                            </td>
                                            <td>
                                                {{detalle.precio*detalle.cantidad - detalle.descuento}}
                                            </td>
                                        </tr>
                                        <tr style="background-color: grey;">
                                            <td colspan="5" align="right"><strong>Sub-Total:</strong></td>
                                            <td><strong> USD$ {{subTotal=(total-subTotalImpuesto).toFixed(2)}}</strong></td>
                                        </tr>
                                        <tr style="background-color: grey;">
                                            <td colspan="5" align="right"><strong>Impuesto:</strong></td>
                                            <td><strong>USD$ {{subTotalImpuesto=((total*impuesto)/(1+impuesto)).toFixed(2)}}</strong></td>
                                        </tr>
                                        <tr style="background-color: grey;">
                                            <td colspan="5" align="right"><strong>Total:</strong></td>
                                            <td><strong>USD$ {{total=calcularTotal}}</strong></td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="6">
                                                No se han agregado productos
                                            </td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-danger" @click="ocultarDetalle()"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                                <button type="button" class="btn btn-success" @click="registrarVenta()"><i class="fa fa-save fa-2x"></i> Registrar Venta</button>
                            </div>
                        </div>
                    </div>
                    </template>
                  
                    <!-- Fin Detalle--> 

                    <!-- Ver Compra -->
                
                    <template v-else-if="listado==2">

                    <h2 class="text-center">Detalle de Ventas</h2><br/>
             
                       <div class="card-body">
                            <div class="form-group row border">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="text-uppercase"><strong>Cliente</strong></label>
                                        <p v-text="cliente"></p>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="text-uppercase"><strong>Tipo de identificación</strong></label>
                                        <p v-text="tipo_identificacion"></p>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="text-uppercase"><strong>Número Venta</strong></label>
                                        <p v-text="num_venta"></p>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                     <div class="form-group">
                                        <label class="text-uppercase"><strong>Impuesto</strong></label>
                                        <p v-text="impuesto"></p>
                                    </div>
                                </div>

                        </div>


                    <div class="form-group row border">
                        <div class="table-responsive col-md-12">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-success">
                                        <th>Producto</th>
                                        <th>Precio (USD$)</th>
                                        <th>Cantidad</th>
                                        <th>Descuento</th>
                                        <th>Total (USD$)</th>
                                    </tr>
                                </thead>
                                <tbody v-if="arrayDetalle.length">
                                    <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                        <td v-text="detalle.producto">
                                        </td>
                                        <td v-text="detalle.precio">
                                        </td>
                                        <td v-text="detalle.cantidad">
                                        </td>
                                        <td v-text="detalle.descuento">
                                        </td>
                                        <td>
                                            {{detalle.precio*detalle.cantidad - detalle.descuento}}
                                        </td>
                                    </tr>
                                    <tr style="background-color: grey;">
                                        <td colspan="3" align="right"><strong>Sub-Total:</strong></td>
                                        <td><strong>USD$ {{subTotal=(total-subTotalImpuesto).toFixed(2)}}</strong></td>
                                    </tr>
                                    <tr style="background-color: grey;">
                                        <td colspan="3" align="right"><strong>Impuesto:</strong></td>
                                        <td><strong>USD$ {{subTotalImpuesto=((total*impuesto)).toFixed(2)}}</strong></td>
                                    </tr>
                                    <tr style="background-color: grey;">
                                        <td colspan="3" align="right"><strong>Total:</strong></td>
                                        <td><strong>USD$ {{total}}</strong></td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="4">
                                            No se han agregado productos
                                        </td>
                                    </tr>
                                </tbody>                                    
                            </table>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <button type="button" @click="ocultarDetalle()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                            
                        </div>
                    </div>
                 </div>
                

                   </template>
                    
                  <!-- fin ver compra-->


                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" :class="{'mostrar':modal}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" @click="cerrarModal()" class="close" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">

                         <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterioP">
                                      <option value="nombre">Producto</option>
                                      <option value="codigo">Código</option>
                                    </select>
                                    <input type="text"  @keyup.enter="listarProducto(buscarP,criterioP);" v-model="buscarP" class="form-control" placeholder="Buscar texto">
                                    <button type="submit"  @click="listarProducto(buscarP,criterioP);" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                          
                         <div class="table-responsive">

                           <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-primary">
                                    
                                        <th>Categoria</th>
                                        <th>Producto</th>
                                        <th>Codigo</th>
                                        <th>Precio Venta (USD$)</th>
                                        <th>Stock</th>
                                        <th>Imagen</th>
                                        <th>Estado</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                    <tr v-for="producto in arrayProducto" :key="producto.id">
                                        
                                        <td v-text="producto.nombre_categoria"></td>
                                        <td v-text="producto.nombre"></td>
                                        <td v-text="producto.codigo"></td>
                                        <td v-text="producto.precio_venta"></td>
                                        <td v-text="producto.stock"></td>

                                        <td>
                                         <!--no es necesario declarar la variable imagen ya que viene
                                         del campo de la tabla -->
                                             <img :src="'img/producto/' + producto.imagen" class="img-responsive" width="100px" height="100px">
                                        </td>

                                        <td>
                                                <button type="button" class="btn btn-success btn-sm" v-if="producto.condicion">
                                                    <i class="fa fa-unlock"></i>&nbsp;Activo
                                                </button>

                                                <button type="button" class="btn btn-danger btn-sm" v-else>
                                                    <i class="fa fa-lock"></i>&nbsp;Desactivado
                                                </button>
                                                
                                        </td>
                                        
                                        <td>
                                                <button type="button" @click="agregarDetalleModal(producto)" class="btn btn-primary btn-sm">
                                                <i class="fa fa-plus fa-2x"></i> Agregar 
                                                </button>
                                        </td>
                                    </tr>
                                
                                </tbody>
                        </table>


                         </div>

                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                            
                           
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->

            <!-- Inicial modal para cta banco de clientes-->
             <div class="modal fade" :class="{'mostrar':modal1}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="titulo_modal"></h4>
                            <button type="button" @click="cerrarModal1()" class="close" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">

                         <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterioQ">
                                      <option value="numero_cuenta">numero_cuenta</option>
                                      <option value="nombre_cliente">nombre_cliente</option>
                                    </select>
                                    <input type="text" @keyup.enter="listarClienteBco(buscarQ,criterioQ);" v-model="buscarQ" class="form-control" placeholder="Buscar Texto">
                                    <button type="submit"  @click="listarClienteBco(buscarQ,criterioQ);" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div> 
                        </div>
                          
                         <div class="table-responsive">

                           <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-primary">
                                    
                                        <th>Idbanco</th>
                                        <th>Banco</th>
                                        <th>Tipo_cta</th>
                                        <th>Cuenta</th>
                                        <th>Estado</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                    <tr v-for="bancoc in arrayCtaBcoCliente" :key="bancoc.idcliente">
                                        
                                        <td v-text="bancoc.idbanco"></td>
                                        <td v-text="bancoc.banco"></td>
                                        <td v-text="bancoc.tipo_cta"></td>
                                        <td v-text="bancoc.numero_cuenta"></td>

                                        <td>
                                                <button type="button" class="btn btn-success btn-sm" v-if="bancoc.estado">
                                                    <i class="fa fa-unlock"></i>&nbsp;Activo
                                                </button>

                                                <button type="button" class="btn btn-danger btn-sm" v-else>
                                                    <i class="fa fa-lock"></i>&nbsp;Desactivado
                                                </button>
                                                
                                        </td>
                                   
                                   
                                        <td>
                                                <button type="button" @click="asignardatosbcocliente(bancoc)" class="btn btn-primary btn-sm">
                                                <i class="fa fa-plus fa-2x"></i> Agregar 
                                                </button>
                                        </td>
                                    </tr>
                                
                                </tbody>
                        </table>


                         </div>

                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal1()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                            
                           
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            <!--Fin del modal-->

            <!-- Ventana Modal para los clientes tarjeta-->
            <div class="modal fade" :class="{'mostrar':modal2}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="titulo_modal"></h4>
                            <button type="button" @click="cerrarModal2()" class="close" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">

                         <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterioR">
                                      <option value="numero_tarjeta">numero_tarjeta</option>
                                      <option value="nombre_cliente">nombre_cliente</option>
                                    </select>
                                    <input type="text" @keyup.enter="listarClienteTarjeta(buscarR,criterioR);" v-model="buscarR" class="form-control" placeholder="Buscar Texto">
                                    <button type="submit"  @click="listarClienteTarjeta(buscarR,criterioR);" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                          
                         <div class="table-responsive">

                           <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-primary">
                                    
                                        <th>Idtarjeta</th>
                                        <th>Tarjeta</th>
                                        <th>Idbanco</th>
                                        <th>Numero_tar</th>
                                        <th>Estado</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                    <tr v-for="clientetarbanco in arrayCtaTarCliente" :key="clientetarbanco.idcliente">
                                        
                                        <td v-text="clientetarbanco.idtarjeta"></td>
                                        <td v-text="clientetarbanco.nombre_tarjeta"></td>
                                        <td v-text="clientetarbanco.idbanco"></td>
                                        <td v-text="clientetarbanco.ntarjeta"></td>
                                        <td v-text="clientetarbanco.estado"></td>
                                   
                                   
                                        <td>
                                                <button type="button" @click="asignadatostarcliente(clientetarbanco)" class="btn btn-primary btn-sm">
                                                <i class="fa fa-plus fa-2x"></i> Agregar 
                                                </button>
                                        </td>
                                    </tr>
                                
                                </tbody>
                        </table>


                         </div>

                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal2()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                            
                           
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>


            <!--Fin del modal-->

           
        
        </main>
</template>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>

   import vSelect from 'vue-select';
   
    export default {
    
        data(){

            return {
               
                venta_id: 0,
                idcliente: 0,
                idforma: 0,
                idbanco: 0,
                idbanco1: 0,
                idtarjeta: 0,
                idtarjeta1: 0,
                cliente:'',
                tipo_identificacion : 'FACTURA',
                num_venta : '',
                impuesto: 0.12,
                total:0.0,
                subTotalImpuesto: 0.0,
                subTotal: 0.0,
                forma_pago:'',
                titulo_modal:'',
                arrayVenta : [],
                arrayVenta1 : [],
                arrayCliente: [],
                arrayDetalle : [],
                arrayCtaBcoCliente : [],
                arrayCtaTarCliente : [],
                arrayFormaPago : [],
                listado:1,
                modal : 0,
                modal1 : 0,
                modal2 : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorVenta : 0,
                errorMostrarMsjVenta : [],
                pagination:{
                   
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
           
                },

                offset:3,
                criterio:'num_venta',
                buscar:'',
                criterioP:'nombre',
                buscarP: '',
                buscarQ: '',
                criterioQ:'nombre_cliente',
                buscarR: '',
                criterioR: 'nombre_cliente',
                arrayProducto: [],
                idproducto: 0,
                codigo: '',
                anulado: 1,
                producto: '',
                precio: 0,
                cantidad:0,
                descuento:0,
                stock:0
            }

        },

        components: {
            vSelect
        },

        computed:{

            isActived: function(){
              
              return this.pagination.current_page;
              
            },

             //calcula los elementos de la paginacion
            pagesNumber: function(){

                if(!this.pagination.to){
                    
                    return[];
                }

                var from = this.pagination.current_page - this.offset;
                if(from < 1){
                   
                   from = 1;
                }

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    
                   to = this.pagination.last_page; 
                }

                var pagesArray = [];
                while(from <= to){
                   
                   pagesArray.push(from);
                   from++;
                }
                return pagesArray;

               
            },

            

            calcularTotal: function(){
                var resultado=0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado=resultado+(this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad - this.arrayDetalle[i].descuento)
                }
                return resultado;
            }

        },

        methods:{

           listarVenta(page,buscar,criterio){

               let me=this;

               const axios = require('axios');

               var url= '/venta?page=' + page + '&buscar='+ buscar + '&criterio='+criterio;

               axios.get(url).then(function (response) {
                    // handle success
                    //console.log(response);
                    var respuesta = response.data;
                    me.arrayVenta=respuesta.ventas.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });

           },

           buscarNumVenta(){

               let me=this;

                const axios = require('axios');

                var url= '/venta/buscarv?filtro=' + me.num_venta;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayVenta1 = respuesta.ventas;

                    if (me.arrayVenta1.length>0){
                        swal({
                            type: 'error',
                            title: 'Ya existe',
                            text: 'Ya existe numero de venta'
                        })
                        /*inicializa el error para volver ingresar*/
                        me.errorMostrarMsjVenta = [];
                        me.errorVenta = 0;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });

      
           },


           selectCliente(search,loading){
                let me=this;
                loading(true)

                const axios = require('axios');
           
                var url= '/cliente/selectCliente?filtro='+search;
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    q: search
                    me.arrayCliente=respuesta.clientes;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            
            getDatosCliente(val1){
                let me = this;
                me.loading = true;
                me.idcliente = val1.id;
            },

            selectFormaPago(search,loading){

                let me=this;
                loading(true)

                const axios = require('axios');
           
                var url= '/venta/selectFormaPago?filtro='+search;
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    q: search
                    me.arrayFormaPago=respuesta.formas;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });

            },

            getDatosForma(val1){
                let me = this;
                me.loading = true;
                me.idforma = val1.id;
     
            },



             buscarProducto(){
                let me=this;

                const axios = require('axios');

                var url= '/producto/buscarProductoVenta?filtro=' + me.codigo;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayProducto = respuesta.productos;

                    if (me.arrayProducto.length>0){
                        me.producto=me.arrayProducto[0]['nombre'];
                        me.idproducto=me.arrayProducto[0]['id'];
                        me.precio=me.arrayProducto[0]['precio_venta'];
                        me.stock=me.arrayProducto[0]['stock'];
                    }
                    else{
                        me.producto='No existe el producto';
                        me.idproducto=0;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            buscarCliente(){
                let me=this;

                const axios = require('axios');

                var url= '/cliente/buscaCliente?filtro=' + me.idcliente;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCliente = respuesta.clientes;

                })
                .catch(function (error) {
                    console.log(error);
                });
            },




           cambiarPagina(page,buscar,criterio){
              
              let me = this;

              //Actualiza  la pagina actual

               me.pagination.current_page=page;

               me.listarVenta(page,buscar,criterio);

           },

            encuentra(id){
                var sw=0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].idproducto==id){
                        sw=true;
                    }
                }
                return sw;
            },

            eliminarDetalle(index){
                let me = this;
                me.arrayDetalle.splice(index, 1);
            },

            verificaforma(){

                let me = this;

                /*para las formas de pago en efectivo*/

                if(me.idforma==1){

                     swal({
                            type: 'info',
                            title: 'Informacion...',
                            text: 'Forma de pago en efectivo',
                       })

                    me.modal1=0;
                    me.modal2=0;
             
                }

                if(me.idforma==2){

                    swal({
                        type: 'info',
                        title: 'Informacion...',
                        text: 'Forma de Pago con cheque',
                    })
                }

                if(me.idforma==3){

                    swal({
                        type: 'info',
                        title: 'Informacion...',
                        text: 'Forma de pago con Tarjeta',
                    })
                }

            },


             agregarDetalle(){
               let me=this;
                if(me.idproducto==0 || me.cantidad==0 || me.precio==0){
                }

                else{
                    if(me.encuentra(me.idproducto)){
                        swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'Ese producto ya fue agregado',
                            })
                    }
                    else{

                       if(me.cantidad>me.stock){
                           swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'No hay stock disponible',
                            })
                       } 
                       else{
                           me.arrayDetalle.push({
                                idproducto: me.idproducto,
                                producto: me.producto,
                                cantidad: me.cantidad,
                                precio: me.precio,
                                descuento: me.descuento,
                                stock: me.stock
                            });
                            me.codigo="";
                            me.idproducto=0;
                            me.producto="";
                            me.cantidad=0;
                            me.precio=0;
                            me.descuento=0;
                            me.stock=0
                       }
                    }
                    
                }

                
                        
            },

            agregarDetalleModal(data=[]){
                 
                let me=this;

                if(me.encuentra(data['id'])){
                        swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'Ese producto ya fue agregado',
                            })
                    }
                    else{
                       me.arrayDetalle.push({
                            idproducto: data['id'],
                            producto: data['nombre'],
                            cantidad: 1,
                            precio: data['precio_venta'],
                            descuento:0,
                            stock:data['stock']
                        }); 
                    }

            },

            /* para los datos del cliente de bancos*/
            asignardatosbcocliente(data=[]){
                 
                let me=this;

                if(data['idcliente']==0){
                          swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'El Cliente no ha sido seleccionado',
                            })
              

                }
                else {

                    /*Para pagos en cheque*/
                    me.forma_pago='Cheque';
                    me.idcliente=data["idcliente"];
                    me.idbanco1=data["idbanco"];
                    me.idtarjeta1=data["idtarjeta"];
                    me.valor=me.total;
                    swal({
                        type: 'info',
                        title: 'Informacion',
                        text: 'Se ha asignado datos de clientes con Cheque'
                    }) 
                }

                me.modal1=0;
                      
            },

            asignadatostarcliente(data=[]){

                let me=this;

                if(data['idcliente']==0){
                          swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'El Cliente no ha sido seleccionado',
                            })
              
                }
                else {
                   /*Para pagos en Tarjeta*/
                   /*llenar el arreglo para los pagos en tarjeta*/
                   me.forma_pago = 'Tarjeta';
                   me.idcliente = data["idcliente"];
                   me.idbanco1 = data["idbanco"];
                   me.idtarjeta1 = data["idtarjeta"];
                   me.valor = me.total;
                   /*cuadro de dialogo en el momento que asigna datos*/
                   swal({
                        type: 'info',
                        title: 'Informacion',
                        text: 'Se ha asignado datos de clientes con Tarjeta'
                   })
                }

                me.modal2=0;
                    
            },



            listarProducto (buscar,criterio){
                let me=this;

                const axios = require('axios');
                var url= '/producto/listarProductoVenta?buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayProducto = respuesta.productos.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            listarClienteBco (buscarQ,criterioQ){

                let me=this;

                const axios = require('axios');
                var url= '/bancos/listarBcosCli?buscar='+ buscarQ + '&criterio='+ criterioQ;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCtaBcoCliente = respuesta.bancoc.data;
                })
                .catch(function (error) {
                    console.log(error);
                });

            },

            listarClienteTarjeta (buscarR,criterioR){

                let me=this;

                const axios = require('axios');
                var url= '/tarjetas/listaclitarjeta?buscar='+ buscarR + '&criterio='+ criterioR;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCtaTarCliente = respuesta.tarjetas.data;
                })
                .catch(function (error) {
                    console.log(error);
                });



            },


           registrarVenta(){

              let me = this;

              if(me.idforma==0){
                     swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'No se ha seleccionado la forma de pago',
                        })


              } else {

                  if(this.validarVenta()){

                   return;
                  }

            
                const axios = require('axios');

                    axios.post('/venta/registrar',{
                        'idcliente': this.idcliente,
                        'tipo_identificacion': this.tipo_identificacion,
                        'num_venta': this.num_venta,
                        'impuesto': this.impuesto,
                        'total': this.total,
                        'data': this.arrayDetalle
            
                    }).then(function (response) {
                       /*no hace nada solo si es en efectivo*/
                       if(me.idforma==1){
                                me.listado=1;
                                me.listarVenta(1,'','num_venta');
                                me.tipo_identificacion='FACTURA';
                                me.idcliente=0;
                                me.num_venta='';
                                me.impuesto=0.12;
                                me.total=0.0;
                                me.idproducto=0;
                                me.producto='';
                                me.cantidad=0;
                                me.precio=0;
                                me.stock=0;
                                me.codigo='';
                                me.descuento=0;
                                me.arrayDetalle=[];
      
                       }
                       else {
                           swal({
                               type: 'info',
                               title: 'Informacion',
                               text: 'Se registro la venta pero tiene que registrar el pago'
                           })
                       }            
                    }).catch(function (error) {
                        console.log(error);
                    });

               

              }
               
           },

           registraPagoCheque(){

                           let me = this;

                           me.forma_pago = 'Cheque';

                           me.idtarjeta1 = 99;
                           
                            const axios = require('axios');

                            axios.post('/pago/pagar',{
                                'tipo_pago': this.forma_pago,
                                'idcliente': this.idcliente,
                                'idbanco': this.idbanco1,
                                'idtarjeta': this.idtarjeta1,
                                'valor': this.valor
                        
                            }).then(function (response) {
                                    me.listado=1;
                                    me.listarVenta(1,'','num_venta');
                                    me.tipo_identificacion='FACTURA';
                                    me.idcliente=0;
                                    me.num_venta='';
                                    me.impuesto=0.12;
                                    me.total=0.0;
                                    me.idproducto=0;
                                    me.producto='';
                                    me.cantidad=0;
                                    me.precio=0;
                                    me.stock=0;
                                    me.codigo='';
                                    me.descuento=0;
                                    me.arrayDetalle=[];
      
                            }).catch(function (error) {
                                console.log(error);
                            });

        
           },

           registraPagoTarjeta(){

                          let me = this;

                          me.forma_pago = 'Tarjeta';
                       
                          const axios = require('axios');

                            axios.post('/pago/pagar',{
                                'tipo_pago': this.forma_pago,
                                'idcliente': this.idcliente,
                                'idbanco': this.idbanco1,
                                'idtarjeta': this.idtarjeta1,
                                'valor': this.valor
                        
                            }).then(function (response) {
                                    me.listado=1;
                                    me.listarVenta(1,'','num_venta');
                                    me.tipo_identificacion='FACTURA';
                                    me.idcliente=0;
                                    me.num_venta='';
                                    me.impuesto=0.12;
                                    me.total=0.0;
                                    me.idproducto=0;
                                    me.producto='';
                                    me.cantidad=0;
                                    me.precio=0;
                                    me.stock=0;
                                    me.codigo='';
                                    me.descuento=0;
                                    me.arrayDetalle=[];
      
                            }).catch(function (error) {
                                console.log(error);
                            });

        
           },


      

            validarVenta(){

                let me=this;
                me.errorVenta=0;
                me.errorMostrarMsjVenta =[];
                var prod;
                
                me.arrayDetalle.map(function(x){
                    if (x.cantidad>x.stock){
                        prod=x.producto + " con stock insuficiente";
                        me.errorMostrarMsjVenta.push(prod);
                    }
                });

                if (me.arrayVenta1.length>0) me.errorMostrarMsjVenta.push("Ya existe un numero de venta");
               
                if (me.idcliente==0) me.errorMostrarMsjVenta.push("Seleccione un Cliente");
                if (me.tipo_identificacion==0) me.errorMostrarMsjVenta.push("Seleccione la identificación");
                if (!me.num_venta) me.errorMostrarMsjVenta.push("Ingrese el número de venta");
                if (!me.impuesto) me.errorMostrarMsjVenta.push("Ingrese el impuesto de venta");
                if (me.arrayDetalle.length<=0) me.errorMostrarMsjVenta.push("Ingrese detalles");

                /*Validar para el tipo de forma de pago*/
                if(me.idforma==2){

                    /*validar si se hay datos de clientes bancos*/
                    if(me.arrayCtaBcoCliente.length==0){
                        me.errorMostrarMsjVenta.push("No se ha seleccionado datos de clientes Bancos..");
                    }
                }

                /*Validar para el tipo de forma de tarjeta*/
                if(me.idforma==3){

                    /*validar si hay datos de clientes tarjetas*/
                    if(me.arrayCtaTarCliente.length==0){
                        me.errorMostrarMsjVenta.push("No se ha seleccionado datos de clientes Tarjetas..");
                    }
                }

                if (me.errorMostrarMsjVenta.length) me.errorVenta = 1;

                return me.errorVenta;
            },

            mostrarDetalle(){

                 let me= this;
                
                    me.listado=0;
                    me.idproveedor=0;
                    me.tipo_identificacion='FACTURA';
                    me.num_compra='';
                    me.impuesto=0.20;
                    me.total=0.0;
                    me.idproducto=0;
                    me.producto='';
                    me.cantidad=0;
                    me.precio=0;
                    me.arrayDetalle=[];
  
            },
            ocultarDetalle(){
                this.listado=1;
            },

            verVenta(id){

                let me=this;
                me.listado=2;

                 //Obtener los datos de la compra
                var arrayVentaT=[];

                const axios = require('axios');

                var url= '/venta/obtenerCabecera?id=' + id;
                
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayVentaT = respuesta.ventas;

                    me.cliente = arrayVentaT[0]['nombre'];
                    me.tipo_identificacion=arrayVentaT[0]['tipo_identificacion'];
                    me.num_venta=arrayVentaT[0]['num_venta'];
                    me.impuesto=arrayVentaT[0]['impuesto'];
                    me.total=arrayVentaT[0]['total'];
                })
                .catch(function (error) {
                    console.log(error);
                });

                //Obtener los datos de los detalles 
                var urld= '/venta/obtenerDetalle?id=' + id;
                
                axios.get(urld).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    me.arrayDetalle = respuesta.detalles;
                })
                .catch(function (error) {
                    console.log(error);
                });     
            },

           cerrarModal(){

                this.modal=0;
                this.tituloModal='';
               
           },

           cerrarModal1(){

               this.modal1=0;
               this.titulo_modal='';
        
           },

           cerrarModal2(){

               this.modal2=0;
               this.titulo_modal='';

           },
          
           abrirModal(){
            
            this.arrayProducto=[];
            this.modal = 1;
            this.tituloModal = 'Seleccione uno o varios productos';
                                               
           },

           abrirModal1(){

               let me = this;

               if(me.idforma==1){
                   this.modal1=0;
                   this.modal2=0;
                   this.titulo_modal='';
               }

          
               if(me.idforma==2){
                   this.arrayCtaBcoCliente=[];
                    this.modal1 = 1;
                    this.modal2 = 0;
                    this.titulo_modal = 'Selecciona uno o varias cuentas del cliente';

               }

               if(me.idforma==3){
                     this.arrayCtaTarCliente=[];
                     this.modal1 = 0;
                     this.modal2 = 1;
                     this.titulo_modal = 'Seleccione uno o varias tarjetas';
               }
              

           },

        
              desactivarVenta(id){
               swal({
                title: 'Esta seguro de anular la compra?',
                //type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="fa fa-check fa-2x"></i> Aceptar!',
                cancelButtonText: '<i class="fa fa-times fa-2x"></i> Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    const axios = require('axios');

                    axios.put('/venta/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarVenta(1,'','num_venta');
                        swal(
                        'Anulado!',
                        'La venta ha sido anulada con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },

            pdfVenta(id,estado){

             
                window.open('http://127.0.0.1:8000/venta/pdf'+ id + ',' + '_blank');
               
                
            },
           
        
        },
        
        mounted() {
            //console.log('Component mounted.')
            this.listarVenta(1,this.buscar,this.criterio);
        }
    }
</script>

<style>
           
     .modal-content{

      width:100% !important;
      position:absolute !important;
  }

  .mostrar{

      display:list-item !important;
      opacity:1 !important;
      position:absolute !important;
      background-color:#3c29297a !important;
  }

   .div-error{

      display:flex;
      justify-content:center;
  }

  .text-error{
      
      color:red !important;
      font-weight:bold;
      font-size:20px;
  }

  @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
    }

</style>
