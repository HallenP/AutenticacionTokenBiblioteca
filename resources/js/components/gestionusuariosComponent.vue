<template>
<h1>Index</h1>

<p>
    <button class="btn btn-success" @click.prevent="modalcrearu()" v-if="permisos" > Nuevo Usuario </button>

</p>
<form asp-controller="Prestamoes" asp-action="Index" class="form-inline">
    <p>
        Buscar: <input type="text" name="cedula" class="form-text" placeholder="Ingresa la cedula usuario" v-model="cedula" />
        <button class="btn btn-success me-3" type="button" @click="buscaru"  > <i class="fa fa-search"></i> Buscar</button>

    </p>

</form>

<table class="table">
    <thead>
        <tr>
            <th>
                Nombre
            </th>
            <th>
                Apellido
            </th>
            <th>
                Cedula
            </th>
            <th>
                correo
            </th>
            <th>
                Contraseña
            </th>
            <th>
                Edad
            </th>
            <th>
                Fecha de ingreso
            </th>
            <th>
               Rol
            </th>
            <th></th>
        </tr>
    </thead>
    <tbody v-for = "user in users">

        <tr>
        
            <td>
                {{user.name}}
            </td>
            <td>
                {{user.lastname}}
            </td>
            <td>
                {{user.cedula}}
            </td>
            <td>
                {{user.email}}
            </td>
            <td>
                {{user.password}}
            </td>
            <td>
                {{user.edad}}
            </td>
            <td>
                {{user.created_at}}
            </td>
            <td>
                {{user.IdRol}}
            </td>
            <td v-if="permisos" >
                <a class="btn btn-warning" @click.prevent="editaru(user) ">Editar</a> |
                <a class="btn btn-info" @click.prevent="detalleu(user.id)" >Detalle</a> |
                <a class="btn btn-danger" @click.prevent="borraru(user)" >Eliminar</a>
            </td>
        </tr>

    </tbody>
</table>
<!-- Modal (ventanas emergentes) -->

<div class="modal fade" id="usuarioModal" tabindex="-1" aria-labelledby="usuarioModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                        <div class="modal-content">
                        <input type="hidden" name="idUsuario" id="_idUsuario" v-model="crearUsuario.idUsuario"/> 
                            <div class="modal-header">
                                <h5 class="modal-title" id="prestamoModalLabel">{{ accionHeader }}libro</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                               
            <div asp-validation-summary="ModelOnly" class="text-danger"></div>
            

            <div class="form-group">
                <label  class="control-label">Cedula</label>
                <input type="number" name="cedula" v-model="crearUsuario.cedula"  class="form-control"  id="_cedula"  />
                <span  class="text-danger"></span>
            </div>
            <div class="form-group">
                <label  class="control-label">Nombres</label>
                <input type="text" name="name" v-model="crearUsuario.name"  class="form-control"  id="_name"  />
                <span  class="text-danger"></span>
            </div>
            <div class="form-group">
                <label  class="control-label">Apellidos</label>
                <input type="text" name="lastname" v-model="crearUsuario.lastname"  class="form-control"  id="_lastname"/>
                <span  class="text-danger"></span>
            </div>
            <div class="form-group">
                <label class="control-label">Correo</label>
                <input type="email" name="email" v-model="crearUsuario.email"   id="_email" class="form-control" />
                <span class="text-danger"></span>
            </div>
            <div class="form-group">
                <label class="control-label">Contraseña</label>
                <input type="password" name="password" v-model="crearUsuario.password"   id="_password" class="form-control" />
                <span  class="text-danger"></span>
            </div>
            <div class="form-group">
                <label class="control-label"> Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" v-model="crearUsuario.password_confirmation"   id="_password_confirmation" class="form-control" />
                <span  class="text-danger"></span>
            </div>
            <div class="form-group">
                <label  class="control-label">Edad</label>
                <input type="number" name="edad" v-model="crearUsuario.edad"   id="_edad" class="form-control" />
                <span  class="text-danger"></span>
            </div>
            <div class="form-group">
                <label  class="control-label">Rol</label>
                        <select name="rol" class="form-control form-control-xs" v-model="crearUsuario.rol" >
                            <option value="0" > -- Ver Todo -- </option>
                            <option v-for="rol in roles" v-bind:value="rol.IdRol"> {{ `${rol.Descripcion}` }}</option>
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
                                <button type="submit" @click.prevent="CrearUsuario" class="btn btn-primary"> Guardar </button>
                                <button type="submit" @click.prevent="limpiar" class="btn btn-primary">Limpiar </button>
                            </div>
                        </div>
                    </div>
            </div>


           <!-- Modal (detalles) -->

           <div class="modal fade" id="detalleuModal" tabindex="-1" aria-labelledby="detalleuModal" aria-hidden="true">
                <div class="modal-dialog">
                        <div class="modal-content">
                        
                            <div class="modal-header">
                                <h5 class="modal-title" id="detalleuModal"> Detalle del Prestamo</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                               
                                <div>
    <h4>Prestamo Realizado</h4>
    <hr />
    <dl class="row" v-for="usuarios in user">
        <dt class = "col-sm-5">
           Nombres:
        </dt>
        <dd class = "col-sm-10">
            {{ usuarios.name }}
        </dd>
        <dt class = "col-sm-5">
          Apellidos:
        </dt>
        <dd class = "col-sm-10">
            {{ usuarios.lastname }}
        </dd>
        <dt class = "col-sm-5">
            Correo:
        </dt>
        <dd class = "col-sm-10">
            {{ usuarios.email }}
        </dd>
        <dt class = "col-sm-5">
            Edad del usuario:
        </dt>
        <dd class = "col-sm-10">
            {{ usuarios.edad }}
        </dd>
        <dt class = "col-sm-5">
            Fecha en la que fue creado: 
        </dt>
        <dd class = "col-sm-10">
            {{ usuarios.created_at }}
        </dd>
        <dt class = "col-sm-5">
           Rol del Usuario:
        </dt>
        <dd class = "col-sm-10">
            {{ usuarios.descripcion }}
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
import axios from 'axios'
    export default {
        mounted() {
            this.getUsers()
            this.getRol()
            this.getadmin()
        },
        data(){
            
            return {

                permisos:false,
                cedula:'',
                user:[],
                accionHeader:'crear',
                statusresponse:false,
                messageresponse:[],
                roles:[],
                users: [],
                crearUsuario:{ name:'', lastname:'', cedula:'', email:'', edad:0, password:'', rol:'' }
            }
            
        },
        methods:{
            
            
            getUsers(){
                axios.get('/getUsers').then(res=>{
                    this.users = res.data.model 
                })
            },

            modalcrearu(){
                this.clearMessage('crear');
                this.crearUsuario={ name:'', lastname:'', cedula:'', email:'', edad:0, password:'', rol:'' };
                $('#usuarioModal').modal('show')
            },
            clearMessage(tipo){
                this.accionHeader = tipo;
                this.messageresponse = [];
                this.statusresponse = false;
            },

            CrearUsuario(){
                axios.post(`/vistacrearusuario/crearusuario`, this.crearUsuario).then(res=>{
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
                   this.getUsers()
                    this.eliminarformulario()
                })    
            },

            getRol(){
                axios.get('/getRol').then(res=>{
                    this.roles = res.data.model 
                })
            },

            editaru(user){
                this.crearUsuario.idUsuario = user.id;
                this.crearUsuario.name = user.name;
                this.crearUsuario.lastname = user.lastname;
                this.crearUsuario.edad = user.edad;
                this.crearUsuario.cedula = user.cedula;
                this.crearUsuario.email = user.email;
                this.crearUsuario.rol = user.IdRol;
                this.clearMessage('actualizar');
               $('#usuarioModal').modal('show');
            },

            detalleu(detalle){
               axios.get(`getdetalleu/${detalle}`).then(res => {
                this.user = res.data.model
               })
             $(`#detalleuModal`).modal('show')
            },

            
            borraru(usu){
                    Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Esta acción eliminará al usuario permanentemente.',
                        icon: 'warning',
                     showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                        axios.post('/borraru/' + usu.id).then(res => {
                        this.statusresponse = !res.data.status;

                        if (!res.data.status) {
                        this.messageresponse = [];
                            for (const property in res.data.validate) {
                            this.messageresponse.push(`${res.data.validate[property]}`);
                                }
                        Swal.fire({
                        title: '¡Error!',
                        text: res.data.message,
                        icon: 'warning',
                        confirmButtonText: 'Cerrar'
                        });
                         }        else {
                         Swal.fire({
                        title: '¡Correcto!',
                        text: res.data.message,
                        icon: 'success',
                        confirmButtonText: 'Cerrar'
                        });
                            this.getUsers();
                                }
                            });
                        }
                     });
            },

            buscaru(){
                axios.post('/buscaru', {
                    cedula:this.cedula
                }).then(res => {
                    this.users = res.data.model
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

            getadmin(){
                axios.post(`/getestadoau/permiso`).then(res =>{console.log(this.permisos = res.data.authenticated)})
                
            }


        },

        /*
        computed: {
        isAdmin() {
      // Verifica si el usuario autenticado es administrador
          return this.permisos.some(permisos => permisos.IdRol === '1');
        },
        isGestor() {
      // Verifica si el usuario autenticado es gestor
          return this.permisos.some(permisos => permisos.IdRol === '2' );
     }
        }*/
    }
</script>