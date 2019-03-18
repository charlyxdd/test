<template>
    <header class="main-header navbar navbar-expand-lg navbar-light"
            style="background:white;box-shadow:0 1px 3px 0 rgba(0,0,0,0.15)">
        <div class="row" style="width: 100%;">
            <div class="col-md-3">
                <button class="btn btn-navbar" v-if="!show" v-on:click="show_menu" style="float:left;">
                    <i class="fa fa-bars"></i>
                </button>
                <h3 style="float:left;">{{title.title}}</h3>
            </div>
            <div class="col-md-5"></div>
        </div>
    </header>
</template>

<script>
    export default {
        props: ['show', 'title'],
        data:function(){
            return {

            }
        },
        methods: {
            show_menu: function () {
                this.$emit('show_menu');
            },
        }
    }
</script>

<style scoped>
    header.main-header {
        position: fixed;
        z-index: 10;
    }

    .btn-navbar {
        background: transparent;
        border: none;
        margin-right: 10px;
    }
</style>