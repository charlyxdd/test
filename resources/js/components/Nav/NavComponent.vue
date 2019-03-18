<template>
    <div class="nav-main" :class="{hide:!show}">
        <div class="logo-container">
            <h1 class="title-brand">Scrumify</h1>
            <button class="btn btn-navbar" v-on:click="hide_menu">
                <i class="fa fa-arrow-left"></i>
            </button>
        </div>
        <div>
            <nav>
                <router-link to="/roles" class="nav-item" :class="{active:(focus.id === 2)}">Roles</router-link>
                <router-link to="/users" class="nav-item" :class="{active:(focus.id === 4)}">Usuarios</router-link>
            </nav>
        </div>
    </div>
</template>

<script>
    import AuthService from "../../services/AuthService";
    export default {
        mounted:function(){

        },
        components:{

        },
        data:function(){
            return {
                projects:[]
            };
        },
        props:['show', 'focus'],
        methods: {
            hide_menu: function () {
                this.$emit('hide_menu');
            }
        }
    }
</script>

<style scoped>
    .nav-main {
        background: #2f2f2f;
        color: white !important;
        position: fixed;
        width: 15%;
        min-width: 170px;
        height: 100%;
        left: 0;
        top: 0;
        transition: all ease-in-out 0.5s;
    }

    .nav-main.hide {
        left: -15%;
    }

    .logo-container {
        padding: 8px 16px;
    }

    .title-brand {
        font-size: 25px;
        float: left;
    }

    .btn-navbar {
        float: right;
        background: transparent;
        border: none;
        color: white;
    }

    nav{
        display: block;
        width: 100%;
        margin-top:40px;
    }

    .nav-item{
        width: 100%;
        display: block;
        color:white;
        cursor: pointer;
        padding:5px 16px;
        text-decoration: none;
    }
    .nav-item:hover, .nav-item.active{
        background: rgba(255,255,255,0.2);
    }

    .project-list{
        padding:10px 16px;
        margin-top:20px;
    }
</style>