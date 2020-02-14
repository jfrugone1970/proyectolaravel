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

                       <h2>Listado de Categorías</h2><br/>
                      
                        <button class="btn btn-primary btn-lg" type="button" @click="abrirModal('categoria','registrar')">
                            <i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Agregar Categoría
                        </button>
                        <button type="button" class="btn btn-success btn-lg" @click="cargarPDF();">
                            <i class="fa fa-file fa-2x"></i>&nbsp;&nbsp;Reporte PDF
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Categoría</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text"  @keyup.enter="listarCategoria(1,buscar,criterio);" v-model="buscar" class="form-control" placeholder="Buscar texto">
                                    <button type="submit"  @click="listarCategoria(1,buscar,criterio);" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr class="bg-primary">
                                   
                                    <th>Categoría</th>
                                    <th>Descripción</th>
                                    <th>Imagen</th>
                                    <th>Estado</th>
                                    <th>Editar</th>
                                    <th>Cambiar Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                <tr v-for="categoria in arrayCategoria" :key="categoria.id">
                                    
                                    <td v-text="categoria.nombre"></td>
                                    <td v-text="categoria.descripcion"></td>

                                    <td>
                                        <img :src="'img/categoria/' + categoria.imagen" class="img-responsive" width="100px" heigth="100px">
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-success btn-md" v-if="categoria.condicion">
                                    
                                          <i class="fa fa-check fa-2x"></i> Activo
                                        </button>

                                        <button type="button" class="btn btn-danger btn-md" v-else>
                                    
                                          <i class="fa fa-check fa-2x"></i> Desactivado
                                        </button>
                                       
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-info btn-md" @click="abrirModal('categoria','actualizar',categoria)">

                                          <i class="fa fa-edit fa-2x"></i> Editar
                                        </button> &nbsp;
                                    </td>

                                    <td>

                                        <template v-if="categoria.condicion==1">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarCategoria(categoria.id)">
                                                <i class="fa fa-lock fa-2x"></i> Desactivar
                                            </button>
                                        </template>

                                        <template v-if="categoria.condicion==0">
                                            <button type="button" class="btn btn-success btn-sm" @click="activarCategoria(categoria.id)">
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
                            
                            <div v-show="errorCategoria" class="form-group row div-error">
                                
                                <div class="text-center text-error">
                                    
                                    <div v-for="error in errorMostrarMsjCategoria" :key="error" v-text="error"></div>

                                </div>
                            
                            </div>
                             

                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Categoría</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de categoría">
                                       
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="descripcion" class="form-control" placeholder="Ingrese descripcion">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Imagen</label>
                                    <div class="col-md-9">
                                        <!--poniendo :src se llama a la variable imagen-->

                                        <div v-if="tipoAccion==1">
                                             <input type="file" @change="subirImagen" class="form-control" placeholder="">
                                             <img :src="imagen" class="img-responsive" width="100px" heigth="100px">

                                        </div>

                                        <div v-if="tipoAccion==2">
                                            <input type="file" @change="subirImagen" class="form-control" placeholder="">
                                            <img :src="imagen" class="img-responsive" width="100px" height="100px">


                                        </div>

                                    </div>

                                </div>


                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                            <button type="button" @click="registrarCategoria()" v-if="tipoAccion==1" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
                            <button type="button" @click="actualizarCategoria()" v-if="tipoAccion==2" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Actualizar</button>
                           
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
               
                categoria_id:0,
                nombre:'',
                descripcion:'',
                arrayCategoria:[],
                modal:0,
                tituloModal:'',
                imagen:'',
                tipoAccion:0,
                errorCategoria:0,
                errorMostrarMsjCategoria:[],
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

           listarCategoria(page,buscar,criterio){

               let me=this;

               const axios = require('axios');

               var url= '/categoria?page=' + page + '&buscar='+ buscar + '&criterio='+criterio;

               axios.get(url).then(function (response) {
                    // handle success
                    //console.log(response);
                    var respuesta = response.data;
                    me.arrayCategoria=respuesta.categorias.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
           },

           cargarPDF(){

               window.open('http://127.0.0.1:8000/categoria/listarPDF', '_blank');
      
           },

           cambiarPagina(page,buscar,criterio){
              
              let me = this;

              //Actualiza  la pagina actual

               me.pagination.current_page=page;

               me.listarCategoria(page,buscar,criterio);

           },

           registrarCategoria(){

               if(this.validarCategoria()){

                   return;
               }

               let me=this;

               const axios = require('axios');

               axios.post('/categoria/registrar',{
                 
                 'nombre':me.nombre,
                 'descripcion':me.descripcion,
                 'imagen':me.imagen


               }).then(function (response) {
                    // handle success
                    //console.log(response);
                    me.cerrarModal();
                    me.listarCategoria(1,'','nombre');

                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });

           },

            actualizarCategoria(){

                if(this.validarCategoria()){

                   return;
               }

               let me=this;

               const axios = require('axios');

               axios.put('/categoria/actualizar',{
                 
                 'nombre':this.nombre,
                 'descripcion':this.descripcion,
                 'imagen':this.imagen,
                 'id':this.categoria_id


               }).then(function (response) {
                    // handle success
                    //console.log(response);
                    me.cerrarModal();
                    me.listarCategoria(1,'','nombre');

                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });

            },

            subirImagen(e){

                let me = this;

                let file = e.target.files[0];

                // console.log(file);

                let reader = new FileReader();

                reader.onloadend = (file) => {

                    me.imagen = reader.result;

                }
                reader.readAsDataURL(file);


            },


            desactivarCategoria(id){
                            
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

               axios.put('/categoria/desactivar',{
                 
                 'id':id


               }).then(function (response) {
                    // handle success
                    //console.log(response);
                    me.listarCategoria(1,'','nombre');

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

             activarCategoria(id){
                            
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

               axios.put('/categoria/activar',{
                 
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

            validarCategoria(){

                 this.errorCategoria=0;
                 this.errorMostrarMsjCategoria=[];

                 if(!this.nombre)  this.errorMostrarMsjCategoria.push("(*)El nombre de la categoria no puede estar vacio");
                 if(!this.imagen) this.errorMostrarMsjCategoria.push("(*)Debe subir una imagen");
               
                 if(this.errorMostrarMsjCategoria.length) this.errorCategoria=1;
             
                 return this.errorCategoria;
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

                    case "categoria":
                    
                    {

                        switch(accion){

                            case "registrar":

                                {
                                   
                                   this.modal=1;
                                   this.tituloModal="Registrar Categoria";
                                   this.nombre="";
                                   this.descripcion="";
                                   this.tipoAccion=1;
                                   break;
                                
                                }

                                case "actualizar":

                                {
                                    //console.log(data);
                                    this.modal=1;
                                    this.tituloModal="Editar Categoria";
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
            this.listarCategoria(1,this.buscar,this.criterio);
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
