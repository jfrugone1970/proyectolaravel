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

                       <h2>Listado de Bancos</h2><br/>
                      
                        <button class="btn btn-primary btn-lg" type="button" @click="abrirModal('banco','registrar')">
                            <i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Agregar Banco
                        </button>
                        <button type="button" class="btn btn-success btn-lg" @click="cargarPDF();">
                            <i class="fa fa-file fa-2x"></i>&nbsp;&nbsp;Reporte PDF
                        </button>

                        <button class="btn btn-success btn-lg" @click="AsignaBanco();">
                            <i class="fa fa-file fa-2x"></i>&nbsp;&nbsp;Asigna Banco
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text"  @keyup.enter="listarBanco(1,buscar,criterio);" v-model="buscar" class="form-control" placeholder="Buscar texto">
                                    <button type="submit"  @click="listarBanco(1,buscar,criterio);" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr class="bg-primary">
                                   
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                    <th>Editar</th>
                                    <th>Cambiar Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                <tr v-for="banco in arrayBanco" :key="banco.id">
                                    
                                    <td v-text="banco.nombre"></td>
                                    <td v-text="banco.descripcion"></td>
           
                                    <td>
                                        <button type="button" class="btn btn-success btn-md" v-if="banco.condicion">
                                    
                                          <i class="fa fa-check fa-2x"></i> Activo
                                        </button>

                                        <button type="button" class="btn btn-danger btn-md" v-else>
                                    
                                          <i class="fa fa-check fa-2x"></i> Desactivado
                                        </button>
                                       
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-info btn-md" @click="abrirModal('banco','actualizar',banco)">

                                          <i class="fa fa-edit fa-2x"></i> Editar
                                        </button> &nbsp;
                                    </td>


                                    <td>

                                        <template v-if="banco.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarBanco(banco.id)">
                                                <i class="fa fa-lock fa-2x"></i> Desactivar
                                            </button>
                                        </template>

                                        <template v-else>
                                            <button type="button" class="btn btn-success btn-sm" @click="activarBanco(banco.id)">
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

                       <h2>Asociar Clientes a Bancos</h2><br/>
                      
                    </div>

                    <div class="modal-body">
                            
                            <div v-show="errorClienteBanco" class="form-group row div-error">
                                
                                <div class="text-center text-error">
                                    
                                    <div v-for="error in errorMostrarMsjCtleBanco" :key="error" v-text="error"></div>

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
                                    <label>Banco <span class="text-error" v-show="banco_id==0">(*Ingrese código del banco)</span></label>
                                    <div class="form-inline">
                                        <input type="text" class="form-control" v-model="banco_id" @keyup.enter="buscarBanco()" placeholder="Ingrese código">
                                        <button @click="abrirModal2()" class="btn btn-primary">
                                           
                                           <i class="fa fa-plus"></i>&nbsp;Agregar Bancos

                                        </button>
                                        <input type="text" readonly class="form-control" v-model="nombre_banco">
                                    </div>                                    
                                </div>
                            </div>


                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Tipo_cta <span class="text-error" v-show="tipo_cta">(*Ingrese tipo de cuenta)</span></label>
                                     <select class="form-control" v-model="tipo_cta">
                                        <option value="0">Seleccione</option>
                                        <option value="CORRIENTE">Corriente</option>
                                        <option value="AHORRO">Ahorro</option>
                                      
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Numero_cta <span class="text-error" v-show="cuenta">(*Ingrese un valor)</span></label>
                                    <input type="text" class="form-control" v-model="cuenta">
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                         <button type="button" @click="cancelaIng()" v-if="ingreso==2" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cancelar</button>
                         <button type="button" @click="registrarClienteBanco()" v-if="ingreso==2" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
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
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de Banco">
                                       
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="descripcion" class="form-control" placeholder="Ingrese descripcion">
                                    </div>
                                </div>
                                
   
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                            <button type="button" @click="registrarBanco()" v-if="tipoAccion==1" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
                            <button type="button" @click="actualizarBanco()" v-if="tipoAccion==2" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Actualizar</button>
                           
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

            <!--Inicio del modal del banco/consulta-->
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
                                
                                   
                                        
                                    <tr v-for="bancoc in arrayBanco1" :key="bancoc.id">
                                        
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

    export default {
       
        data(){

            return {
               
                banco_id:0,
                cliente_id:0,
                nombre:'',
                nombre_cliente:'',
                nombre_banco:'',
                ingreso:1,
                descripcion:'',
                arrayBanco:[],
                arrayBanco1:[],
                arrayCliente:[],
                arrayCliBanco:[],
                modal:0,
                modal1:0,
                modal2:0,
                tituloModal:'',
                imagen:'',
                tipoAccion:0,
                tipoAsocia:0,
                tipo_cta:'',
                cuenta:'',
                errorBanco:0,
                errorClienteBanco:0,
                errorMostrarMsjBanco:[],
                errorMostrarMsjCtleBanco:[],
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
                buscar:'',
                criterioP:'nombre',
                buscarP:'',
                criterioQ:'nombre',
                buscarQ:''
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

           listarBanco(page,buscar,criterio){

               let me=this;

               const axios = require('axios');

               var url= '/bancos?page=' + page + '&buscar='+ buscar + '&criterio='+criterio;

               axios.get(url).then(function (response) {
                    // haoyundle success
                    //console.log(response);
                    var respuesta = response.data;
                    me.arrayBanco=respuesta.bancos.data;
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

            listarBanco2 (buscarQ,criterioQ){

                let me=this;

                const axios = require('axios');
                var url= '/bancos/listarBancos?buscar='+ buscarQ + '&criterio='+ criterioQ;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayBanco1 = respuesta.bancos.data;
                })
                .catch(function (error) {
                    console.log(error);
                });

            },

      
            asignardatoscliente(data=[]){

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

          asignardatosbanco(data=[]){

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

                me.modal2=0;
                me.tituloModal='';
        

          },

        

           cargarPDF(){

              
               window.open('http://127.0.0.1:8080/bancos/listarPDF', '_blank');
      
           },

           AsignaBanco(){

               this.ingreso=2;
      
           },

           cancelaIng(){

               this.cliente_id=0;
               this.nombre_cliente='';
               this.banco_id=0;
               this.nombre_banco='';
               this.cuenta='';
               this.modal='';
               this.modal1='';
               this.modal2='';
               this.tituloModal='';
            
               this.listarBanco(1,'','nombre');
               this.ingreso=1;
               
           },
          
         
      
           cambiarPagina(page,buscar,criterio){
              
              let me = this;

              //Actualiza  la pagina actual

               me.pagination.current_page=page;

               me.listarBanco(page,buscar,criterio);

           },

           registrarClienteBanco(){

               if(this.validarClienteBanco()){

                   return;
               }

                   let me = this;

               const axios = require('axios');

               axios.post('/bancos/registrarclibanco',{
                 
                 'idcliente':this.cliente_id,
                 'idbanco':this.banco_id,
                 'banco':this.nombre_banco,
                 'tipo_cta':this.tipo_cta,
                 'cuenta':this.cuenta
               

               }).then(function (response) {
                    // handle success
                    //console.log(response);
                   me.listarBanco(1,'','nombre'); 
                   me.ingreso=1;
                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });

           },


           registrarBanco(){

               if(this.validarBanco()){

                   return;
               }

               let me = this;

               const axios = require('axios');

               axios.post('/bancos/registrar',{
                 
                 'nombre':this.nombre,
                 'descripcion':this.descripcion
               

               }).then(function (response) {
                    // handle success
                    //console.log(response);
                    me.cerrarModal();
                    me.listarBanco(1,'','nombre');

                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });

           },

            actualizarBancos(){

                if(this.validarBanco()){

                   return;
               }

               let me=this;

               const axios = require('axios');

               axios.put('/bancos/actualizar',{
                 
                 'nombre':this.nombre,
                 'descripcion':this.descripcion,
                 'id':this.banco_id


               }).then(function (response) {
                    // handle success
                    //console.log(response);
                    me.cerrarModal();
                    me.listarBanco(1,'','nombre');

                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });

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

                 this.arrayBanco=[];
                 this.modal2=1;
                 this.tituloModal='Seleccione uno o varios bancos';
            },

            desactivarBancos(id){
                            
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

               axios.put('/bancos/desactivar',{
                 
                 'id':id


               }).then(function (response) {
                    // handle success
                    //console.log(response);
                    me.listarBanco(1,'','nombre');

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

             activarBanco(id){
                            
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

               axios.put('/bancos/activar',{
                 
                 'id':id


               }).then(function (response) {
                    // handle success
                    //console.log(response);
                    me.listarCategoria(1,'','nombre');

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

            validarBanco(){

                 this.errorBanco=0;
                 this.errorMostrarMsjBanco=[];

                 if(!this.nombre)  this.errorMostrarMsjBanco.push("(*)El nombre del banco no puede estar vacio");

                 if(!this.descripcion) this.errorMostrarMsjBanco.push("(*)La descripción del banco no puede estar vacia");
               
                 if(this.errorMostrarMsjBanco.length) this.errorBanco=1;
             
                 return this.errorBanco;
            },

            validarClienteBanco(){

                 this.errorClienteBanco=0;
                 this.errorMostrarMsjCtleBanco=[];

                 if(this.cliente_id==0) this.errorMostrarMsjCtleBanco.push("(*)El cliente no debe de estar vacio");
                 
                 if(this.banco_id==0) this.errorMostrarMsjCtleBanco.push("(*)El Banco no debe de estar vacio");

                 if(!this.tipo_cta) this.errorMostrarMsjCtleBanco.push("(*)El tipo de cuenta no debe de estar vacio");
                
                 if(!this.cuenta) this.errorMostrarMsjCtleBanco.push("(*) El número de cuenta no debe de estar vacio");

                 if(this.errorMostrarMsjCtleBanco.length) this.errorClienteBanco=1;

                 return this.errorClienteBanco;
           

            },


           cerrarModal(){
               this.modal=0;
               this.nombre="";
               this.descripcion="";
               this.tituloModal="";
       
           },


           cerrarModal1(){

               this.modal1=0;
               this.tituloModal="";
        
           },

           cerrarModal2(){

               this.modal2=0;
               this.tituloModal="";
          

           },


           abrirModal(modelo,accion,data=[]){
                 
                 switch(modelo){

                    case "banco":
                    
                    {

                        switch(accion){

                            case "registrar":

                                {
                                   
                                   this.modal=1;
                                   this.tituloModal="Registrar Banco";
                                   this.nombre="";
                                   this.descripcion="";
                                   this.tipoAccion=1;
                                   break;
                                
                                }

                                case "actualizar":

                                {
                                    //console.log(data);
                                    this.modal=1;
                                    this.tituloModal="Editar Banco";
                                    this.tipoAccion=2;
                                    this.categoria_id=data["id"];
                                    this.nombre=data["nombre"];
                                    this.descripcion=data["descripcion"];
                                    break;
                                }
                        
                        }


                    }

                }

                        
           }
        
        },
        
        mounted() {
            //console.log('Component mounted.')
            this.listarBanco(1,this.buscar,this.criterio);
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
