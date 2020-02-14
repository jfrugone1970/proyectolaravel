<template>
   <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="/">BACKEND - SISTEMA DE COMPRAS - VENTAS</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">

                       <h2>Listado de Clientes por banco</h2><br/>
                      
                        <button class="btn btn-primary btn-lg" type="button" @click="abrirModal('banco','registrar')">
                            <i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Agregar Banco
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="idcliente">Cliente</option>
                                      <option value="idbanco">Banco</option>
                                    </select>
                                    <input type="text"  @keyup.enter="listarBanco(1,buscar,criterio);" v-model="buscar" class="form-control" placeholder="Buscar texto">
                                    <button type="submit"  @click="listarBanco(1,buscar,criterio);" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr class="bg-primary">
                                   
                                    <th>Cliente</th>
                                    <th>Nombre_cli</th>
                                    <th>Banco</th>
                                    <th>Nombre_ban</th>
                                    <th>Tipo_cta</th>
                                    <th>Numero_cta</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                <tr v-for="banco in arrayClienteBanco" :key="banco.id">
                                    
                                    <td v-text="banco.idcliente"></td>
                                    <td v-text="banco.idbanco"></td>
                                    <td v-text="banco.nombre_banco"></td>
                                    <td v-text="banco.tipo_cta"></td>
                                    <td v-text="banco.numero_cta"></td>
           
                                    <td>
                                        <button type="button" class="btn btn-success btn-md" v-if="banco.estado">
                                    
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
                            
                            <div v-show="errorClienteBanco" class="form-group row div-error">
                                
                                <div class="text-center text-error">
                                    
                                    <div v-for="error in errorClienteBanco" :key="error" v-text="error"></div>

                                </div>
                            
                            </div>
                             

                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
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
                                            <label class="text-uppercase"><strong>Banco(*)</strong></label>
                                            <v-select
                                                :on-search="selectBanco"
                                                label="nombre"
                                                :options="arrayBanco"
                                                placeholder="Buscar Banco..."
                                                :onChange="getDatosBanco"                                        
                                            >

                                            </v-select>
                                        </div>
                                </div>

                                 
                            
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Banco</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="nombre_banco" class="form-control" placeholder="Banco">
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="text-uppercase"><strong>Tipo Cta(*)</strong></label>
                                        <select class="form-control" v-model="tipo_cta">
                                            <option value="0">Seleccione</option>
                                            <option value="CORRIENTE">Corriente</option>
                                            <option value="AHORO">Ahorro</option>
                                        
                                        </select>
                                    </div>
                                </div>

                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Numero_cta</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="numero_cta" class="form-control" placeholder="Número de Cta">                                        
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
           
        
        </main>
</template>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>

    export default {
        data(){

            return {
               
                banco_id:0,
                cliente_id:0,
                nombre_banco:'',
                nombre_cliente:'',
                descripcion:'',
                arrayClienteBanco:[],
                arrayCliente:[],
                arrayBanco:[],
                tipo_cta:'',
                numero_cta:'',
                modal:0,
                tituloModal:'',
                imagen:'',
                tipoAccion:0,
                errorClienteBanco:0,
                errorMostrarMsjClienteBanco:[],
                pagination:{
                   
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
           
                },
                offset:3,
                criterio:'idcliente',
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

           listarBanco(page,buscar,criterio){

               let me=this;

               const axios = require('axios');

               var url= '/bancos/indexClientesBanco?page=' + page + '&buscar='+ buscar + '&criterio='+criterio;

               axios.get(url).then(function (response) {
                    // handle success
                    //console.log(response);
                    var respuesta = response.data;
                    me.arrayClienteBanco=respuesta.clienteban.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
           },

           
           cambiarPagina(page,buscar,criterio){
              
              let me = this;

              //Actualiza  la pagina actual

               me.pagination.current_page=page;

               me.listarBanco(page,buscar,criterio);

           },

           registrarBanco(){

               if(this.validarClienteBanco()){

                   return;
               }

               let me = this;

               const axios = require('axios');

               axios.post('/bancos/registrarclibanco',{
                 
                 'idcliente':this.cliente_id,
                 'idbanco':this.banco_id,
                 'nombre_banco':this.nombre_banco,
                 'tipo_cta':this.tipo_cta,
                 'numero_cta':this.numero_cta

               }).then(function (response) {
                    // handle success
                    //console.log(response);
                    me.cerrarModal();
                    me.listarBanco(1,'','idcliente');

                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });

           },

            actualizarBancos(){

                if(this.validarClienteBanco()){

                   return;
               }

               let me=this;

               const axios = require('axios');

               axios.put('/bancos/actualizarcliebancos',{
                 
                 'idcliente':this.cliente_id,
                 'idbanco':this.banco_id,
                 'nombre_banco':this.nombre_banco,
                 'tipo_cta':this.tipo_cta,
                 'numero_cta':this.numero_cta,
                 'id':this.id
         

               }).then(function (response) {
                    // handle success
                    //console.log(response);
                    me.cerrarModal();
                    me.listarBanco(1,'','idcliente');

                }).catch(function (error) {
                    // handle error
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

            selectBanco(search,loading){
                let me=this;

                
                loading(true)

                const axios = require('axios');
                
                var url= '/bancos/selectBancos?filtro='+search;

                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    q: search
                    me.arrayBanco=respuesta.bancos;
                    me.nombre_banco=me.arrayBanco["nombre"];
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            
            getDatosBancos(val1){
                let me = this;
                me.loading = true;
                me.idbanco = val1.id;

            },




           

            

            validarClienteBanco(){

                 this.errorClienteBanco=0;
                 this.errorMostrarMsjClienteBanco=[];

                 if(!this.cliente_id)  this.errorMostrarMsjClienteBanco.push("(*)El código del cliente no puede estar vacio");

                 if(!this.banco_id) this.errorMostrarMsjClienteBanco.push("(*)El código del Banco no debe estar vacio");

                 if(!this.tipo_cta) this.errorMostrarMsjClienteBanco.push("(*)El tipo de cuenta no debe de estar vacio");

                 if(!this.numero_cta) this.errorMostrarMsjClienteBanco.push("(*) El numero de cuenta no debe de estar vacia");

                 
                 if(this.errorMostrarMsjClienteBanco.length) this.errorClienteBanco=1;
             
                 return this.errorClienteBanco;
            },

           cerrarModal(){

               this.modal=0;
               this.tituloModal="";
               this.nombre="";
               this.descripcion="";
               this.imagen="";
        
           },

           abrirModal(modelo,accion,data=[]){
                 
                 switch(modelo){

                    case "banco":
                    
                    {

                        switch(accion){

                            case "registrar":

                                {
                                   
                                   this.modal=1;
                                   this.tituloModal="Registrar Cliente Banco";
                                   this.nombre_banco="";
                                   this.tipo_cta="";
                                   this.numero_cta="";
                                   this.tipoAccion=1;
                                   break;
                                
                                }

                                case "actualizar":

                                {
                                    //console.log(data);
                                    this.modal=1;
                                    this.tituloModal="Editar Cliente Banco";
                                    this.tipoAccion=2;
                                    this.id=data["id"];
                                    this.idcliente=data["idcliente"];
                                    this.idbanco=data["idbanco"];
                                    this.nombre_banco=data["nombre_banco"];
                                    this.numero_cta=data["numero_cta"];
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
