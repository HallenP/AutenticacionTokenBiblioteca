<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"> </div>

                    <div class="card-body">
                        <form method="POST">


                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Ingrese correo</label>

                                <div class="col-md-6">
                                    <input id="id" type="email" class="form-control" name="text"
                                        v-model="creartoken.email" />



                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">Ingrese contra</label>
                                    <input id="id" type="password" class="form-control" name="password"
                                        v-model="creartoken.password" />



                                </div>
                            </div>





                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4 justify-conten-center">

                                    <button type="submit" class="btn btn-primary" @click.prevent="generartoken()">
                                        Generar token
                                    </button>





                                </div>
                            </div>



                        </form>
                        <div>
                            <a :href="'http://127.0.0.1:8000/token-login/' + this.tokens">Haz clic aquí para iniciar
                                sesion</a>
                        </div>
                        <div>
                            {{ this.tokens }}
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import axios from 'axios';
import swal from 'sweetalert';

export default {
    mounted() {
        this.mostrartoken()
    },
    data() {
        return {

            tokens: '',
            usuarioto: [],
            tokenusuario: [],
            creartoken: { email: '', password: '' }
        }
    },

    methods: {
        generartoken() {

            axios.post('/generatetoken/generarto', this.creartoken).then(res => {

                this.tokens = res.data.model;
                if (res.data.status  ) {

                    Swal.fire({
                        title: '¡Inicia sesión!',
                        text: 'Has sido logeado con token',
                        icon: 'success',
                        confirmButtonText: 'Cerrar',
                        confirmButtonText: '<a id="tokenLink">Haz clic aquí</a>',
                        customClass: {
                            confirmButton: 'swal-button',
                            title: 'swal-title',
                            content: 'swal-content'
                        },
                        didOpen: () => {
                            const tokenLink = document.getElementById('tokenLink');
                            if (tokenLink) {
                                tokenLink.href = 'http://127.0.0.1:8000/token-login/' + this.tokens;
                                tokenLink.style.color = 'white';
                                // Agrega otros estilos según sea necesario
                            }
                        }
                    });
                } else{

                    Swal.fire({
                        title: '¡Error!',
                        text: 'no se encontro el usuario.',
                        icon: 'error',
                        confirmButtonText: 'Cerrar'
                    });
                }

            });

        },

        mostrartoken() {

            axios.get('/mostrartoken/mostrarto').then(res => {
                this.tokenusuario = res.data.model.usertokens;
                this.usuarioto = res.data.models.users;

            })
        },

        props: [
            'usertokens', 'users'
        ]


    }

}
</script>