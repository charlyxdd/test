require('./bootstrap');
import AuthService from "./services/AuthService";
window.Vue = require('vue');
import Vuetify from 'vuetify';
import VueRouter from 'vue-router';
import App from './components/App';
import Login from './components/Login/Login';
import UsersComponent from './components/Users/UsersComponent';

Vue.use(VueRouter);
Vue.use(Vuetify);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/users',
            name: 'users',
            component: UsersComponent
        },
    ],
});

const auth = new AuthService();

const app = new Vue({
    el: '#app',
    mounted:function(){
        if(!auth.check()){
            this.$router.push('/login');
        }
        else{
            if(location.pathname === '/login') {
                this.$router.push('/users');
            }
        }
    },
    data:function(){
        return {
            login: auth.check()
        }
    },
    components: {App, Login},
    methods:{
        fn_login:function(){
            this.login=true;
            this.$router.push('/');
        }
    },
    router,
});