<template>
    <div class="main" style="margin-top:100px;">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title" style="text-align: center">Test de Users</h1>
                        <form v-on:submit.prevent="login">
                            <div class="alert alert-danger" role="alert" v-show="error">
                                {{error}}
                            </div>
                            <div class="form-group">
                                <label for="txtUsername">Nombre de usuario</label>
                                <input type="text" v-model="username" id="txtUsername" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="txtPassword">Contraseña</label>
                                <input type="password" v-model="password" id="txtPassword" class="form-control">
                            </div>

                            <button class="btn btn-primary" type="submit" :disabled="loading">Iniciar sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import AuthService from '../../services/AuthService';

    const auth = new AuthService();
    export default {
        data: function () {
            return {
                username: '',
                password: '',
                error: '',
                loading: false
            }
        },
        methods: {
            login() {
                if (!this.username) {
                    this.error = 'Ingrese el nombre de usuario';
                    return;
                }
                if (!this.password) {
                    this.error = 'Ingrese la contraseña';
                    return;
                }
                this.error = '';
                this.loading = true;
                auth.signIn({username: this.username, password: this.password})
                    .then((response) => {
                        console.log(response);
                        auth.login(response.data.user, response.data.token, true);
                        this.loading=false;
                        this.$emit('login');
                    })
                    .catch((error) => {
                        if (error.response.data.result === 'error') {
                            this.error = error.response.data.error;
                        }
                        else{
                            this.error = "Ha ocurrido un error interno";
                        }
                        this.loading=false;
                    })
            }
        }
    }
</script>

<style scoped>

</style>