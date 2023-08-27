<template>

<h1>Index </h1>

<p>
    <button class="btn btn-success" @click.prevent="modalcrear()"> Nuevo Libro </button>
   
</p>
<form  class="form-inline">
    <p>
        Buscar: <input type="text" name="buscar" class="form-text" placeholder="Ingresa el titulo del libro"  v-model="titulo"/>
        
        <button class="btn btn-success me-3" type="button" @click="buscar" > <i class="fa fa-search"></i> Buscar</button>

    </p>

</form>


<table class="table">
    <thead>
        <tr>
            <th>
                titulo
            </th>
            <th>
                Nombreportada
            </th>
            <th>
                Autor
            </th>
            <th>
                Genero Literario
            </th>
            <th>
                Editorial
            </th>
            <th>
                Ubicacion
            </th>
            <th>
                Ejemplares
            </th>
            <th></th>
        </tr>
    </thead>
    <tbody v-for="libro in this.libros">


        <tr>
            <td>
                {{ libro.titulo}}
            </td>
            <td>
                {{ libro.nombrePortada}}
            </td>
            <td>
                {{ libro.autor}}
            </td>
            <td>
                {{ libro.genero_Literario}}
            </td>
            <td>
                {{ libro.editorial}}
            </td>
            <td>
                {{ libro.ubicacion}}
            </td>
            <td>
                {{ libro.ejemplares}}
            </td>
            <td>
                <a class="btn btn-warning" @click.prevent="abrireditor(libro)" >Editar</a> |
                <a  class="btn btn-info" @click.prevent="abrirdetalle(libro.idLibro)" >Detalle</a> |
                <a class="btn btn-danger" @click.prevent="borrar(libro)" >Borrar</a>
            </td>
        </tr>

    </tbody>
    <!-- Modal (ventanas emergentes) -->

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                        <div class="modal-content">
                        <input type="hidden" name="IdLibro" id="_idLibro" v-model="crearLibro.IdLibro"/> 
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ accionHeader }}libro</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                               
            <div asp-validation-summary="ModelOnly" class="text-danger"></div>
            
            <div class="form-group">
                <label class="control-label" >Titulo</label>
                <input type="text" name="titulo" v-model="crearLibro.titulo" class="form-control" id="_titulo" />
                <span  class="text-danger"></span>
            </div>
            <div class="form-group">
                <label  class="control-label">Nombre de la Portada</label>
                <input type="text" name="nombreportada" v-model="crearLibro.nombreportada"  class="form-control" id="_nombreportada" />
                <span  class="text-danger"></span>
            </div>
            <div class="form-group">
                <label  class="control-label">Autor</label>
                <input type="text" name="autor" v-model="crearLibro.autor"  class="form-control"  id="_autor"/>
                <span  class="text-danger"></span>
            </div>
            <div class="form-group">
                <label  class="control-label">Genero Literario</label>
                <input type="text" name="generoliterario" v-model="crearLibro.generoliterario"  class="form-control" id="_generoliterario" />
                <span  class="text-danger"></span>
            </div>
            <div class="form-group">
                <label  class="control-label">Editorial</label>
                <input type="text" name="editorial" v-model="crearLibro.editorial"  class="form-control" id="_editorial"/>
                <span  class="text-danger"></span>
            </div>
            <div class="form-group">
                <label  class="control-label">Ubicacion</label>
                <input type="text" name="ubicacion" v-model="crearLibro.ubicacion"  class="form-control" id="_ubicacion" />
                <span  class="text-danger"></span>
            </div>
            <div class="form-group">
                <label  class="control-label">Ejemplares </label>
                <input type="number" name="ejemplares" v-model="crearLibro.ejemplares" class="form-control" id="_ejemplares" />
                <span class="text-danger"></span>
            </div>
            
        
                            </div>
                            <div class="alert alert-danger" v-if="statusresponse"> 
                            <ul> 
                            <li v-for="message in this.messageresponse">
                                {{message}}
                            </li>
                            </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" >Cancelar</button>
                                <button type="submit" @click.prevent="CrearLibro" class="btn btn-primary">Aceptar </button>
                                <button type="submit" @click.prevent="limpiar" class="btn btn-primary">Limpiar </button>
                            </div>
                        </div>
                    </div>
            </div>


           <!-- Modal (detalles) -->

           <div class="modal fade" id="detalleModal" tabindex="-1" aria-labelledby="detalleModal" aria-hidden="true">
                <div class="modal-dialog">
                        <div class="modal-content">
                        
                            <div class="modal-header">
                                <h5 class="modal-title" id="detalleModal"> Detalle del libro</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                               
                                <div>
    <h4>Libro</h4>
    <hr />
    <dl class="row" v-for="libros in libro">
        <dt class = "col-sm-5">
           Titulo:
        </dt>
        <dd class = "col-sm-10">
            {{ libros.titulo }}
        </dd>
        <dt class = "col-sm-5">
          Nombre de la Portada:
        </dt>
        <dd class = "col-sm-10">
            {{ libros.nombrePortada }}
        </dd>
        <dt class = "col-sm-5">
            Autor:
        </dt>
        <dd class = "col-sm-10">
            {{ libros.autor }}
        </dd>
        <dt class = "col-sm-5">
            Genero Literario:
        </dt>
        <dd class = "col-sm-10">
            {{ libros.genero_Literario }}
        </dd>
        <dt class = "col-sm-5">
            Editorial: 
        </dt>
        <dd class = "col-sm-10">
            {{ libros.editorial }}
        </dd>
        <dt class = "col-sm-5">
           Ubicacion:
        </dt>
        <dd class = "col-sm-10">
            {{ libros.ubicacion }}
        </dd>
        <dt class = "col-sm-5">
            Ejemplares:
        </dt>
        <dd class = "col-sm-10">
            {{ libros.ejemplares }}
        </dd>
    </dl>
</div>


        
                            </div>
                            <div class="alert alert-danger" v-if="statusresponse"> 
                            <ul> 
                            <li v-for="message in this.messageresponse">
                                {{message}}
                            </li>
                            </ul>
                            </div>
                            
                        </div>
                    </div>
            </div>  
            
</table>




</template>

<script>
import axios from 'axios';
import swal from 'sweetalert';
    export default {
        mounted() {
            this.getlibros()
            this.getlibro()
        },
        data(){

            return {
            libro:[],
              libros:[],
              crearLibro:{ titulo:'', nombreportada:'', autor:'', generoliterario:'', editorial:'', ubicacion:'', ejemplares:0 }, 
              accionHeader:'Crear',
              statusresponse:false,
              messageresponse:[]
            }
            
        },
        methods:{
            modalcrear(){
                this.clearMessage('Crear');
                this.crearLibro={ titulo:'', nombreportada:'', autor:'', generoliterario:'', editorial:'', ubicacion:'', ejemplares:0 };
                $('#exampleModal').modal('show')
            },
            clearMessage(tipo){
                this.accionHeader = tipo;
                this.messageresponse = [];
                this.statusresponse = false;
            },

            CrearLibro(){
                axios.post(`/vistacrearlibro/crearlibro `, this.crearLibro).then(res=>{
                    this.statusresponse = !res.data.status
                    if(!res.data.status){
                        this.messageresponse = []
                        for(const property in res.data.validate){
                            this.messageresponse.push(`${(res.data.validate)[property]}`)
                        }
                        swal("¡¡Error!!", res.data.message, "warning")
                    }else{
                        swal("¡¡Correcto!!", res.data.message, "success")
                    }
                    this.getlibros()
                    this.eliminarformulario()
                })    
            },

            eliminarformulario(){
                if(this.statusresponse == false && this.clearMessage == 'Crear' ){
                    this.crearLibro = {titulo:'', nombreportada:'', autor:'', generoliterario:'', editorial:'', ubicacion:'', ejemplares:0 }
                }
            },

            getlibros(){
                axios.get('/getlibros').then(res=>{
                    this.libros = res.data.model
                })
            },

            

            abrireditor(libro){
                this.crearLibro.IdLibro = libro.idLibro;
               this.crearLibro.titulo = libro.titulo;
               this.crearLibro.nombreportada = libro.nombrePortada;
               this.crearLibro.autor = libro.autor;
               this.crearLibro.generoliterario= libro.genero_Literario;
               this.crearLibro.editorial = libro.editorial;
               this.crearLibro.ubicacion = libro.ubicacion;
               this.crearLibro.ejemplares = libro.ejemplares;
               this.clearMessage('actualizar');
               $('#exampleModal').modal('show');
            },
            
            limpiar(){
                this.crearLibro = {titulo:'', nombreportada:'', autor:'', generoliterario:'', editorial:'', ubicacion:'', ejemplares:0 }
            },

            abrirdetalle(detalle){
               axios.get(`getlibrodetalle/${detalle}`).then(res => {
                this.libro = res.data.model
               })
             $(`#detalleModal`).modal('show')
            },
            borrar(libro){
                axios.post('/borrarlibro/'+libro.idLibro).then(res => {
                    this.statusresponse = !res.data.status
                    if(!res.data.status){
                        this.messageresponse = []
                        for(const property in res.data.validate){
                            this.messageresponse.push(`${(res.data.validate)[property]}`)
                        }
                        swal("¡¡Error!!", res.data.message, "warning")
                    }else{
                        swal("¡¡Correcto!!", res.data.message, "success")
                    }
                    this.getlibros()
                    this.getlibro()
                });
            },

            buscar(){
                axios.post('/buscarlibro', {
                    titulo:this.titulo
                }).then(res => {
                    this.libros = res.data.model
                    this.statusresponse = !res.data.status
                    if(!res.data.status){
                        this.messageresponse = []
                        for(const property in res.data.validate){
                            this.messageresponse.push(`${(res.data.validate)[property]}`)
                        }
                        swal("¡¡Error!!", res.data.message, "warning")
                    }else{
                        swal("¡¡Correcto!!", res.data.message, "success")
                    }
                })
            }
        }
    }
</script>