<template>

<h1>Index</h1>

<p>
    <button class="btn btn-success" @click.prevent="modalcrearp()"> Nuevo Prestamo </button>
    
</p>
<form asp-controller="Prestamoes" asp-action="Index" class="form-inline">
    <p>
        Buscar: <input type="text" name="buscar" class="form-text" placeholder="Ingresa el titulo " v-model="titulo" />
        <button class="btn btn-success me-3" type="button" @click="buscarp"  > <i class="fa fa-search"></i> Buscar</button>

    </p>

</form>
<table class="table">
    <thead>
        <tr>
            <th>
              FechaDevolucion
            </th>
            <th>
                FechaConfirmacionDevolucion
            </th>
            <th>
                Estado
            </th>
            <th>
                FechaCreacion
            </th>
            <th>
                IdLibro
            </th>
            <th>
                IdUsuario
            </th>
            <th></th>
        </tr>
    </thead>
    <tbody v-for="prestamo in this.prestamos">

        <tr>
            <td>
                {{prestamo.FechaDevolucion}}
            </td>
            <td>
                {{prestamo.FechaConfirmacionDevolucion}}
            </td>
            <td>
                {{prestamo.Estado}}
            </td>
            <td>
                {{prestamo.FechaCreacion}}
            </td>
            <td>
                {{prestamo.titulo}}
            </td>
            <td>
                {{prestamo.cedula}}
            </td>
            <td>
                <a class="btn btn-warning"  @click.prevent="editorprestamo(prestamo)">Editar</a> |
                <a class="btn btn-info" @click.prevent="detallep(prestamo.IdPrestamo)" >Detalle</a> |
                <a class="btn btn-danger" @click.prevent="borrarp(prestamo)">Eliminar</a>
            </td>
        </tr>

    </tbody>
</table>

<!-- Modal (ventanas emergentes) -->

<div class="modal fade" id="prestamoModal" tabindex="-1" aria-labelledby="prestamoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                        <div class="modal-content">
                        <input type="hidden" name="IdPrestamo" id="_idLibro" v-model="crearPrestamo.IdPrestamo"/> 
                            <div class="modal-header">
                                <h5 class="modal-title" id="prestamoModalLabel">{{ accionHeader }}libro</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                               
            <div asp-validation-summary="ModelOnly" class="text-danger"></div>
            

            <div class="form-group">
                <label class="control-label" >Fecha de Devolucion</label>
                <label>Fecha de finalización</label><br>
                <input type="date" name="fechadedevolucion" v-model="crearPrestamo.fechadedevolucion"  class="form-control" id="_fechadedevolucion" />
                <span  class="text-danger"></span>
            </div>
            <div class="form-group">
                <label  class="control-label">Fecha de Confirmacion de Devolucion</label>
                <input type="date" name="fechaconfirmacion" v-model="crearPrestamo.fechaconfirmacion"  class="form-control" id="_fechaconfirmacion" />
                <span  class="text-danger"></span>
            </div>

            
            <div class="form-group">
                <label  class="control-label">Estado</label>
                <input type="text" name="estado" v-model="crearPrestamo.estado"  class="form-control"  id="_estado"/>
                <span  class="text-danger"></span>
            </div>
            <div class="form-group">
                <label  class="control-label">Fecha creacion</label>
                <input type="date" name="fechacreacion" v-model="crearPrestamo.fechacreacion"  class="form-control"  id="_fechacreacion"/>
                <span  class="text-danger"></span>
            </div>
            <div class="form-group">
                <label  class="control-label">IdLibro</label>
                        <select class="form-control form-control-xs" v-model="crearPrestamo.idLibro" >
                            <option value="0" > -- Ver Todo -- </option>
                            <option v-for="libro in libros" v-bind:value="libro.idLibro"> {{ `${libro.titulo}` }}</option>
                        </select>

            </div>
            <div class="form-group">
                <label  class="control-label">Usuario</label>
                        <select class="form-control form-control-xs" v-model="crearPrestamo.id" >
                            <option value="0"> -- Ver Todo -- </option>
                            <option v-for="usuario in usuarios" v-bind:value="usuario.id"> {{ `${usuario.name} ${usuario.lastname}` }}</option>
                        </select>

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
                                <button type="submit" @click.prevent="CrearPrestamo" class="btn btn-primary"> Guardar </button>
                                <button type="submit" @click.prevent="limpiar" class="btn btn-primary">Limpiar </button>
                            </div>
                        </div>
                    </div>
            </div>


           <!-- Modal (detalles) -->

           <div class="modal fade" id="detallepModal" tabindex="-1" aria-labelledby="detallepModal" aria-hidden="true">
                <div class="modal-dialog">
                        <div class="modal-content">
                        
                            <div class="modal-header">
                                <h5 class="modal-title" id="detallepModal"> Detalle del Prestamo</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                               
                                <div>
    <h4>Prestamo Realizado</h4>
    <hr />
    <dl class="row" v-for="prestamos in prestamo">
        <dt class = "col-sm-5">
           Fecha de Devolucion:
        </dt>
        <dd class = "col-sm-10">
            {{ prestamos.FechaDevolucion }}
        </dd>
        <dt class = "col-sm-5">
          Fecha de la Confirmacion de la devolucion:
        </dt>
        <dd class = "col-sm-10">
            {{ prestamos.FechaConfirmacionDevolucion }}
        </dd>
        <dt class = "col-sm-5">
            Estado del Prestamo:
        </dt>
        <dd class = "col-sm-10">
            {{ prestamos.Estado }}
        </dd>
        <dt class = "col-sm-5">
            Fecha de Creacion:
        </dt>
        <dd class = "col-sm-10">
            {{ prestamos.FechaCreacion }}
        </dd>
        <dt class = "col-sm-5">
            Titulo del Libro Prestado: 
        </dt>
        <dd class = "col-sm-10">
            {{ prestamos.titulo }}
        </dd>
        <dt class = "col-sm-5">
           Identificacion del Usuario
        </dt>
        <dd class = "col-sm-10">
            {{ prestamos.cedula }}
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
            





</template>

<script>
import axios from 'axios';
import swal from 'sweetalert';
import { ref } from 'vue';
import Datepicker from 'vuejs3-datepicker';
    export default {
        mounted() {
            this.getPrestamos()
            //this.getPrestamo()
            this.getLibros()
            this.getUsers()
        },
        data(){

            return {
            fechadedevolucion:ref( new Date()),
            titulo:'',
            usuarios:[],
            libros:[],
              prestamo:[],
              prestamos:[],
              crearPrestamo:{ fechadedevolucion:'', fechaconfirmacion:'', estado:'', fechacreacion:'',idLibro:0, id:0 }, 
              accionHeader:'Crear',
              statusresponse:false,
              messageresponse:[]
            }
            
        },
        methods:{
            modalcrearp(){
                this.clearMessage('Crear');
                this.crearPrestamo={ fechadedevolucion:'', fechaconfirmacion:'', estado:'', fechacreacion:'',idLibro:0, id:0 };
                $('#prestamoModal').modal('show')
            },
            clearMessage(tipo){
                this.accionHeader = tipo;
                this.messageresponse = [];
                this.statusresponse = false;
            },

            CrearPrestamo(){
                axios.post(`/vistacrearprestamo/crearprestamo `, this.crearPrestamo).then(res=>{
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
                    this.getPrestamos()
                    this.eliminarformulario()
                })    
            },

            eliminarformulario(){
                if(this.statusresponse == false && this.clearMessage == 'Crear' ){
                    this.crearPrestamo = { fechadedevolucion:'', fechaconfirmacion:'', estado:'', fechacreacion:'',idLibro:0, id:0 }
                }
            },

            getLibros(){
                axios.get('getlibros').then(res=>{
                    this.libros = res.data.model
                })
            },
            getPrestamos(){
                axios.get('/getprestamos').then(res=>{
                    this.prestamos = res.data.model
                })
            },

            

            editorprestamo(prestamo){
                this.crearPrestamo.IdPrestamo = prestamo.IdPrestamo;
               this.crearPrestamo.fechadedevolucion = prestamo.FechaDevolucion;
               this.crearPrestamo.fechaconfirmacion = prestamo.FechaConfirmacionDevolucion;
               this.crearPrestamo.estado = prestamo.Estado;
               this.crearPrestamo.fechacreacion= prestamo.FechaCreacion;
               this.crearPrestamo.idLibro = prestamo.IdLibro;
               this.crearPrestamo.id= prestamo.IdUsuario;
               this.clearMessage('actualizar');
               $('#prestamoModal').modal('show');
            },
            
            limpiar(){
                this.crearPrestamo = { fechadedevolucion:'', fechaconfirmacion:'', estado:'', fechacreacion:'',idLibro:0, id:0 }
            },

            detallep(detalle){
               axios.get(`getprestamodetalle/${detalle}`).then(res => {
                this.prestamo = res.data.model
               })
             $(`#detallepModal`).modal('show')
            },
            borrarp(prestamo){
                axios.post('/borrarprestamo/'+prestamo.IdPrestamo).then(res => {
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
                    this.getPrestamos()
                    //this.getprestamo()
                });
            },

            buscarp(){
                axios.post('/buscarprestamo', {
                    titulo:this.titulo
                }).then(res => {
                    this.prestamos = res.data.model
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
            },
            getUsers(){
                axios.get('/getUsers').then(res=>{
                    this.usuarios = res.data.model 
                })
            }
        },

        components: {
                Datepicker
            }
    }
</script>