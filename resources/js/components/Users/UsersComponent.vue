<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Lista de usuarios</div>

                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Correo electrónico</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users">
                                    <td>{{user.id}}</td>
                                    <td>{{user.name}}</td>
                                    <td>{{user.email}}</td>
                                    <td>{{user.role_id}}</td>
                                    <td>{{user.status == 0 ? 'Desactivado' : 'Activo'}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import User from '../../models/User';

    export default {
        mounted() {
            console.log('Component mounted.')
            this.update_template();
            this.initUsers();
        },
        data: function(){
            return {
                users:[]
            }
        },
        methods:{
            update_template(){
                this.$emit('change_title', {title: 'Usuarios', id: 4});
            },
            initUsers(){
                const u = new User();
                u.get().then((users)=>{
                   console.log('users', users);
                   this.users = users;
                });
            }
        }
    }
</script>
