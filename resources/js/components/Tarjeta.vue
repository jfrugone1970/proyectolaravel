<template>
   <main class="main">
            <!-- Breadcrumb -->
            <template v-if="ingreso==1">

            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="/">BACKEND - SISTEMA DE COMPRAS - VENTAS</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">

                       <h2>Listado de Tarjetas</h2><br/>
                      
                        <button class="btn btn-primary btn-lg" type="button" @click="abrirModal('tarjeta','registrar')">
                            <i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Agregar Tarjeta
                        </button>
                        <button type="button" class="btn btn-success btn-lg" @click="cargarPDF();">
                            <i class="fa fa-file fa-2x"></i>&nbsp;&nbsp;Reporte PDF
                        </button>

                        <button class="btn btn-success btn-lg" @click="AsignaTarjeta();">
                            <i class="fa fa-file fa-2x"></i>&nbsp;&nbsp;Asigna Tarjeta
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripcion</option>
                                    </select>
                                    <input type="text"  @keyup.enter="listarTarjeta(1,buscar,criterio);" v-model="buscar" class="form-control" placeholder="Buscar texto">
                                    <button type="submit"  @click="listarTarjeta(1,buscar,criterio);" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr class="bg-primary">
                                   
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Tipo_tarjeta</th>
                                    <th>idbancos</th>
                                    <th>Banco</th>
                                    <th>Estado</th>
                                    <th>Editar</th>
                                    <th>Cambiar Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                <tr v-for="tarjeta in arrayTarjeta" :key="tarjeta.id">
                                    
                                    <td v-text="tarjeta.nombre"></td>
                                    <td v-text="tarjeta.descripcion"></td>
                                    <td v-text="tarjeta.externa"></td>
                                    <td v-text="tarjeta.idbancos"></td>
                                    <td v-text="tarjeta.nombre_banco"></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-md" v-if="tarjeta.condicion">
                                    
                                          <i class="fa fa-check fa-2x"></i> Activo
                                        </button>

                                        <button type="button" class="btn btn-danger btn-md" v-else>
                                    
                                          <i class="fa fa-check fa-2x"></i> Desactivado
                                        </button>
                                       
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-info btn-md" @click="abrirModal('tarjeta','actualizar')">

                                          <i class="fa fa-edit fa-2x"></i> Editar
                                        </button> &nbsp;
                                    </td>


                                    <td>

                                        <template v-if="tarjeta.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarTarjeta(tarjeta.id)">
                                                <i class="fa fa-lock fa-2x"></i> Desactivar
                                            </button>
                                        </template>

                                        <template v-else>
                                            <button type="button" class="btn btn-success btn-sm" @click="desactivarTarjeta(tarjeta.id)">
                                                <i class="fa fa-lock fa-2x"></i> Activar
                                            </button>
                                        </template>
                                       
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
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            </template>
 
            <template v-if="ingreso==2">
                    <div class="card-header">

                       <h2>Asociar Clientes a Tarjetas</h2><br/>
                      
                    </div>

                     <div class="modal-body">
                            
                            <div v-show="errorTarjeta" class="form-group row div-error">
                                
                                <div class="text-center text-error">
                                    
                                    <div v-for="error in errorMostrarMsjCtleTarjeta" :key="error" v-text="error"></div>

                                </div>
                            
                            </div>

                    <div class="form-group row border">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cliente <span class="text-error" v-show="cliente_id==0">(*Ingrese código del cliente)</span></label>
                                    <div class="form-inline">
                                        <input type="text" class="form-control" v-model="cliente_id" @keyup.enter="buscarCliente()" placeholder="Ingrese código">
                                        <button @click="abrirModal1()" class="btn btn-primary">
                                           
                                           <i class="fa fa-plus"></i>&nbsp;Agregar Clientes

                                        </button>
                                        <input type="text" readonly class="form-control" v-model="nombre_cliente">
                                    </div>                                    
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tarjeta <span class="text-error" v-show="tarjeta_id==0">(*Ingrese código de la tarjeta)</span></label>
                                    <div class="form-inline">
                                        <input type="text" class="form-control" v-model="tarjeta_id" @keyup.enter="buscarTarjeta()" placeholder="Ingrese código">
                                        <button @click="abrirModal2()" class="btn btn-primary">
                                           
                                           <i class="fa fa-plus"></i>&nbsp;Agregar Tarjeta

                                        </button>
                                        <input type="text" readonly class="form-control" v-model="nombre">
                                    </div>                                    
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Banco <span class="text-error" v-show="banco_id==0">(*Ingrese código del banco)</span></label>
                                    <div class="form-inline">
                                        <input type="text" class="form-control" v-model="banco_id" @keyup.enter="buscarBanco()" placeholder="Ingrese código">
                                        <button @click="abrirModal3()" class="btn btn-primary">
                                           
                                           <i class="fa fa-plus"></i>&nbsp;Agregar Banco

                                        </button>
                                        <input type="text" readonly class="form-control" v-model="nombre_banco">
                                    </div>                                    
                                </div>
                            </div>


                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Numero_tarjeta <span class="text-error" v-show="tarjeta">(*Ingrese un valor)</span></label>
                                    <input type="text" value="0" class="form-control" v-model="tarjeta">
                                </div>
                            </div>

                        </div>
                     </div>

                    <div class="modal-footer">
                         <button type="button" @click="cerrar()" class="btn btn-success"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                         <button type="button" @click="registrarClienteTarjeta()" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
                    </div>  
   

                   
            </template>
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
                            
                            <div v-show="errorBanco" class="form-group row div-error">
                                
                                <div class="text-center text-error">
                                    
                                    <div v-for="error in errorMostrarMsjBanco" :key="error" v-text="error"></div>

                                </div>
                            
                            </div>
                             

                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre_Tarjeta</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de Tarjeta">
                                       
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Descripcion</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="descripcion" class="form-control" placeholder="Descripcion de La Tarjeta">
                                       
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Tipo_Tarjeta</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="tipo_tar">
                                            <option value="0">Seleccione</option>
                                            <option value="NACIONAL">Nacional</option>
                                            <option value="INTERNACIONAL">Internacional</option>
                                       </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Banco <span class="text-error" v-show="banco_id==0">(*Ingrese código del banco)</span></label>
                                        <div class="form-inline">
                                            <input type="text" class="form-control" v-model="banco_id" @keyup.enter="buscarBanco()" placeholder="Ingrese código">
                                            <input type="text" readonly class="form-control" v-model="nombre_banco">
                                        </div>                                    
                                    </div>
                                </div>
                                
   
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                            <button type="button" @click="registrarTarjeta()" v-if="tipoAccion==1" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
                            <button type="button" @click="actualizarTarjetas()" v-if="tipoAccion==2" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Actualizar</button>
                           
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->

             <!--Inicio del modal del cliente/consulta-->
            <div class="modal fade" :class="{'mostrar':modal1}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" @click="cerrarModal1()" class="close" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">

                         <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterioP">
                                      <option value="nombre">nombre</option>
                                      <option value="num_documento">num_documento</option>
                                    </select>
                                    <input type="text" @keyup.enter="listarCliente(buscarP,criterioP);" v-model="buscarP" class="form-control" placeholder="Buscar Texto">
                                    <button type="submit"  @click="listarCliente(buscarP,criterioP);" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
 
                                </div>
                            </div>
                        </div>
                          
                         <div class="table-responsive">

                           <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-primary">
                                    
                                        <th>Nombre</th>
                                        <th>tipo_documento</th>
                                        <th>num_documento</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                   <tr v-for="clientec in arrayCliente" :key="clientec.id">
                                        
                                        <td v-text="clientec.nombre"></td>
                                        <td v-text="clientec.tipo_documento"></td>
                                        <td v-text="clientec.num_documento"></td>
                             
                                        <td>
                                                <button type="button" @click="asignardatoscliente(clientec)" class="btn btn-primary btn-sm">
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

            <!--Inicio del modal del cliente/tarjeta-->
            <div class="modal fade" :class="{'mostrar':modal2}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" @click="cerrarModal2()" class="close" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">

                         <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterioR">
                                      <option value="nombre">nombre</option>
                                      <option value="descripcion">descripcion</option>
                                    </select>
                                    <input type="text" @keyup.enter="listarTarjetaCli(buscarR,criterioR);" v-model="buscarR" class="form-control" placeholder="Buscar Texto">
                                    <button type="submit"  @click="listarTarjetaCli(buscarR,criterioR);" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
 
                                </div>
                            </div>
                        </div>
                          
                         <div class="table-responsive">

                           <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-primary">
                                    
                                        <th>Nombre</th>
                                        <th>Descripcion</th>
                                        <th>Externa</th>
                                        <th>Idbanco</th>
                                        <th>Banco</th>    
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                   <tr v-for="tarjetac in arrayTarjeta1" :key="tarjetac.id">
                                        
                                        <td v-text="tarjetac.nombre"></td>
                                        <td v-text="tarjetac.descripcion"></td>
                                        <td v-text="tarjetac.externa"></td>
                                        <td v-text="tarjetac.idbancos"></td>
                                        <td v-text="tarjetac.nombre_banco"></td>
                             
                                        <td>
                                                <button type="button" @click="asignardatosclientetar(tarjetac)" class="btn btn-primary btn-sm">
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

            <!-- Inicio modal bancos -->
             <div class="modal fade" :class="{'mostrar':modal3}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" @click="cerrarModal3()" class="close" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">

                         <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterioQ">
                                      <option value="nombre">nombre</option>
                                      <option value="descripcion">descripcion</option>
                                    </select>
                                    <input type="text" @keyup.enter="listarBanco2(buscarQ,criterioQ);" v-model="buscarQ" class="form-control" placeholder="Buscar Texto">
                                    <button type="submit"  @click="listarBanco2(buscarQ,criterioQ);" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                          
                         <div class="table-responsive">

                           <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-primary">
                                    
                                        <th>Nombre</th>
                                        <th>Descripcion</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                   
                                        
                                    <tr v-for="bancoc in arrayBanco" :key="bancoc.id">
                                        
                                        <td v-text="bancoc.nombre"></td>
                                        <td v-text="bancoc.descripcion"></td>
                             
                                        <td>
                                                <button type="button" @click="asignardatosbanco(bancoc)" class="btn btn-primary btn-sm">
                                                <i class="fa fa-plus fa-2x"></i> Agregar 
                                                </button>
                                        </td>
                                    </tr>
                                    
                                
                                </tbody>
                        </table>


                         </div>

                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal3()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                            
                           
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>


            <!-- Fin modal bancos-->

           
        
        </main>
</template>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>

    export default {

        data(){

            return {
               
                banco_id:0,
                cliente_id:0,
                tarjeta_id:0,
                nombre:'',
                nombre_cliente:'',
                nombre_banco:'',
                tarjeta:'',
                ingreso:1,
                descripcion:'',
                arrayBanco:[],
                arrayCliente:[],
                arrayTarjeta:[],
                arrayTarjeta1:[],
                arrayTarCliente:[],
                modal:0,
                modal1:0,
                modal2:0,
                modal3:0,
                buscarP:'',
                criterioP:'nombre',
                buscarQ:'',
                criterioQ:'nombre',
                buscarR:'',
                criterioR:'nombre',
                tipoAccion:0,
                tituloModal:'',
                imagen:'',
                tipoAsocia:0,
                tipo_cta:'',
                tipo_tar:'',
                numero_cta:'',
                errorBanco:0,
                errorTarjeta:0,
                errorMostrarMsjCtleTarjeta:[],
                errorMostrarMsjBanco:[],
                pagination:{
                   
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
           
                },
                offset:3,
                criterio:'nombre',
                buscar:''
            }

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


            }

        },

        methods:{

           listarTarjeta(page,buscar,criterio){

               let me=this;

               const axios = require('axios');

               var url= '/tarjetas?page=' + page + '&buscar='+ buscar + '&criterio='+criterio;

               axios.get(url).then(function (response) {
                    // handle success
                    //console.log(response);
                    var respuesta = response.data;
                    me.arrayTarjeta=respuesta.tarjetas.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
           },

           listarCliente (buscarP,criterioP){
                let me=this;

                const axios = require('axios');
                var url= '/cliente/listarCliente?buscar='+ buscarP + '&criterio='+ criterioP;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCliente = respuesta.clientes.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            asignardatoscliente (data=[]){

                 let me=this;

                if(data['id']==0){
                          swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'El Cliente no ha sido seleccionado',
                            })
              
                }
                else {
                   /*selecciona datos del cliente*/
                   me.cliente_id = data["id"];
                   me.nombre_cliente = data["nombre"];
                   /*cuadro de dialogo en el momento que asigna datos*/
                   swal({
                        type: 'info',
                        title: 'Informacion',
                        text: 'Se ha asignado datos de clientes'
                   })
                }

                me.modal1=0;
                


            },


            listarTarjetaCli (buscarR, criterioR){

                let me=this;

                const axios = require('axios');
                var url= '/tarjetas/listarTarCliente?buscar='+ buscarR + '&criterio='+ criterioR;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayTarjeta1 = respuesta.tarjetas.data;
                })
                .catch(function (error) {
                    console.log(error);
                });

            },

            asignardatosclientetar (data=[]){

                let me=this;

                if(data['id']==0){
                          swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'La tarjeta no ha sido seleccionada',
                            })
              
                }
                else {
                   /*selecciona datos la tarjeta*/
                   me.tarjeta_id = data["id"];
                   me.nombre = data["nombre"];
                   /*cuadro de dialogo en el momento que asigna datos*/
                   swal({
                        type: 'info',
                        title: 'Informacion',
                        text: 'Se ha asignado datos de la tarjeta'
                   })
                }

                me.modal2=0;
                



            },



            listarBanco2 (buscarQ,criterioQ){

                let me=this;

                const axios = require('axios');
                var url= '/bancos/listarBancos?buscar='+ buscarQ + '&criterio='+ criterioQ;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayBanco = respuesta.bancos.data;
                })
                .catch(function (error) {
                    console.log(error);
                });

            },

            asignardatosbanco (data=[]){

                let me=this;

                if(data['id']==0){
                          swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'El Banco no ha sido seleccionado',
                            })
              
                }
                else {
                   /*selecciona datos del cliente*/
                   me.banco_id = data["id"];
                   me.nombre_banco = data["nombre"];
                   /*cuadro de dialogo en el momento que asigna datos*/
                   swal({
                        type: 'info',
                        title: 'Informacion',
                        text: 'Se ha asignado datos de Banco'
                   })
                }

                me.modal3=0;
              

            },



           cargarPDF(){

              
               window.open('http://127.0.0.1:8080/tarjetas/listarPDF', '_blank');
      
           },

           AsignaTarjeta(){

               this.ingreso=2;
      
           },

         
      
           cambiarPagina(page,buscar,criterio){
              
              let me = this;

              //Actualiza  la pagina actual

               me.pagination.current_page=page;

               me.listarTarjeta(page,buscar,criterio);

           },

           registrarClienteTarjeta(){

               if(this.validarCtleTarjeta()){

                   return;
               }


                   let me = this;

               const axios = require('axios');

               axios.post('/tarjetas/registrarclitarjeta',{
                 
                 'idcliente':this.cliente_id,
                 'idtarjeta':this.tarjeta_id,
                 'tarjeta':this.nombre,
                 'idbanco':this.banco_id,
                 'ntarjeta':this.tarjeta

               }).then(function (response) {
                    // handle success
                    //console.log(response);
                   me.listarTarjeta(1,'','nombre');
                   me.ingreso=1;
                   
                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });

           },


           registrarTarjeta(){

               if(this.validarTarjeta()){

                   return;
               }

               let me = this;

               const axios = require('axios');

               axios.post('/tarjetas/registrar',{
                 
                 'nombre':this.nombre,
                 'descripcion':this.descripcion,
                 'externa':this.tipo_tar,
                 'idbancos':this.banco_id
               

               }).then(function (response) {
                    // handle success
                    //console.log(response);
                    me.cerrarModal();
                    me.listarTarjeta(1,'','nombre');
                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });

           },

            actualizarTarjetas(){

                if(this.validarTarjeta()){

                   return;
               }

               let me=this;

               const axios = require('axios');

               axios.put('/tarjetas/actualizar',{
                 
                 'nombre':this.nombre,
                 'descripcion':this.descripcion,
                 'externa':this.tipo_tar,
                 'idbancos':this.banco_id,
                 'id':this.id
             

               }).then(function (response) {
                    // handle success
                    //console.log(response);
                    me.cerrarModal();
                    me.listarTarjeta(1,'','nombre');
                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });

            },

            cerrar(){

                let me = this;
                me.ingreso=1;
                
                me.listarTarjeta(1,'','nombre');


            },


            buscarCliente(){
                let me = this;

                const axios = require('axios');

                var url= '/cliente/buscaCliente?filtro='+me.cliente_id;

                 axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    me.arrayCliente=respuesta.clientes;
                    
                    if (me.arrayCliente.length>0){
                       me.nombre_cliente=me.arrayCliente[0]['nombre'];

                    }
                    else{
                       me.nombre_cliente='No existe Cliente';
                       me.cliente_id=0;

                    }
                    
                })
                .catch(function (error) {
                    console.log(error);
                });


 

            },

            buscarTarjeta(){
                let me = this;

                const axios = require('axios');

                var url= '/tarjetas/selectTarjetas?filtro='+me.tarjeta_id;

                 axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    me.arrayTarjeta=respuesta.tarjetas;
                    
                    if (me.arrayTarjeta.length>0){
                       me.nombre=me.arrayTarjeta[0]['nombre'];

                    }
                    else{
                       me.nombre='No existe Tarjeta';
                       me.tarjeta_id=0;

                    }
                    
                })
                .catch(function (error) {
                    console.log(error);
                });


 

            },

           
             buscarBanco(){
                let me = this;

                const axios = require('axios');

                var url= '/bancos/buscaBanco?filtro='+me.banco_id;

                 axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    me.arrayBanco=respuesta.bancos;
                    
                    if (me.arrayBanco.length>0){
                       me.nombre_banco=me.arrayBanco[0]['nombre'];

                    }
                    else{
                       me.nombre_banco='No existe el banco';
                       me.banco_id=0;

                    }
                    
                })
                .catch(function (error) {
                    console.log(error);
                });


 

            },

           

            abrirModal1(){

                 this.arrayCliente=[];
                 this.modal1=1;
                 this.tituloModal='Seleccione uno o varios clientes';
            },

            abrirModal2(){

                this.arrayTarjeta1=[];
                this.modal2=1;
                this.tituloModal='Seleccione uno o varias tarjetas';
       
            },

            abrirModal3(){

                this.arrayBanco=[];
                this.modal3=1;
                this.tituloModal='Seleccione uno o varios bancos';
       

            },


            desactivarTarjeta(id){
                            
                const swalWithBootstrapButtons = Swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: 'Estas seguro de desactivar la categoria?',
                //type: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-check fa-2x"></i> Aceptar',
                cancelButtonText: '<i class="fa fa-times fa-2x"></i> Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {

                  let me=this;

                  const axios = require('axios');

               axios.put('/tarjetas/desactivar',{
                 
                 'id':idtarjeta


               }).then(function (response) {
                    // handle success
                    //console.log(response);
                    me.listarTarjeta(1,'','nombre');

                     swalWithBootstrapButtons(
                    'Desactivado!',
                    'El registro ha sido desactivado con exito.',
                    'success'
                )

                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });


               
                } else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
                ) {
               
                }
              })

            },

             activarTarjeta(id){
                            
                const swalWithBootstrapButtons = Swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: 'Estas seguro de activar la categoria?',
                //type: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-check fa-2x"></i> Aceptar',
                cancelButtonText: '<i class="fa fa-times fa-2x"></i> Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {

                  let me=this;

                  const axios = require('axios');

               axios.put('/tarjetas/activar',{
                 
                 'id':idtarjeta


               }).then(function (response) {
                    // handle success
                    //console.log(response);
                    me.listarTarjeta(1,'','nombre');

                     swalWithBootstrapButtons(
                    'Activado!',
                    'El registro ha sido activado con exito.',
                    'success'
                )

                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });


               
                } else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
                ) {
               
                }
              })

            },

            validarTarjeta(){

                 this.errorBanco=0;
                 this.errorMostrarMsjBanco=[];

                 if(!this.nombre)  this.errorMostrarMsjBanco.push("(*)El nombre de la tarjeta no debe estar vacío");

                 if(!this.descripcion) this.errorMostrarMsjBanco.push("(*) La descripcion no debe estar vacia");
                
                 if(!this.tipo_tar) this.errorMostrarMsjBanco.push("(*)El tipo de tarjeta no debe estar vacio");

                 if(!this.banco_id) this.errorMostrarMsjBanco.push("(*) El código del banco no debe estar vacio");

               
                 if(this.errorMostrarMsjBanco.length) this.errorBanco=1;
             
                 return this.errorBanco;
            },

            validarCtleTarjeta(){

                this.errorTarjeta=0;
                this.errorMostrarMsjCtleTarjeta=[];

                if(this.cliente_id==0) this.errorMostrarMsjCtleTarjeta.push("(*)El cliente no debe de estar vacio");

                if(this.tarjeta_id==0) this.errorMostrarMsjCtleTarjeta.push("(*)La tarjeta no debe estar vacia");

                if(!this.tarjeta) this.errorMostrarMsjCtleTarjeta.push("(*)El numero de tarjeta no debe de estar vacio");

                if(this.errorMostrarMsjCtleTarjeta.length) this.errorTarjeta=1;

                return this.errorTarjeta;
        
            },


           cerrarModal(){

               this.modal=0;
               this.tituloModal="";
               this.nombre="";
               this.descripcion="";
               this.tipo_tar="";
               this.banco_id=0;
           },

           cerrarModal1(){

               this.modal1=0;
               this.tituloModal="";


           },

           cerrarModal2(){

                this.modal2=0;
                this.tituloModal="";

           },

           cerrarModal3(){

                this.modal3=0;
                this.tituloModal="";
           },



           abrirModal(modelo,accion,data=[]){
                 
                 switch(modelo){

                    case "tarjeta":
                    
                    {

                        switch(accion){

                            case "registrar":

                                {
                                   
                                   this.modal=1;
                                   this.tituloModal="Registrar Tarjeta";
                                   this.nombre="";
                                   this.descripcion="";
                                   this.tipo_tar="";
                                   this.idbanco=0;
                                   this.tipoAccion=1;
                                   break;
                                
                                }

                                case "actualizar":

                                {
                                    //console.log(data);
                                    this.modal=1;
                                    this.tituloModal="Editar Tarjeta";
                                    this.tipoAccion=2;
                                    this.nombre=data["nombre"];
                                    this.descripcion=data["descripcion"];
                                    this.tipo_tar=data["externa"];
                                    this.idbanco=data["idbancos"];
                                    break;
                                }
                        
                        }


                    }

                }

                        
           }
        
        },
        
        mounted() {
            //console.log('Component mounted.')
            this.listarTarjeta(1,this.buscar,this.criterio);
        }
    }
</script>

<style>
           
     .modal-content{

      width:100% !important;
      position:absolute !important;
  }

  .mostrar{

      height:1000px;
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

</style>
