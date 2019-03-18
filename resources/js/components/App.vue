<template>
    <div class="main">
        <NavComponent @hide_menu="hide_menu" :show="show_menu" :focus="title"></NavComponent>
        <div class="content" :class="{expand: show_menu}">
            <HeaderComponent @show_menu="show_menu_click" :show="show_menu" :title="title"></HeaderComponent>
            <main class="col-md-12">
                <router-view @change_title="change_title"></router-view>
            </main>
        </div>
    </div>
</template>

<script>
    import HeaderComponent from './Header/HeaderComponent';
    import NavComponent from './Nav/NavComponent';
    import AuthService from "../services/AuthService";
    import User from "../models/User";

    const auth = new AuthService();
    const u = new User();

    export default {
        mounted: function () {
            if (auth.check()) {
                axios.defaults.headers.common['authorization'] = auth.getToken();
                axios.defaults.headers.common['Content-Type'] = 'application/json';
                u.find(auth.getIdentity().id).then((user) => {
                    if (user.status) {
                        auth.login(user.json(), auth.getToken().toString().substring(7), true);
                    }
                    else {
                        alert("La sesión ha caducado");
                        localStorage.clear();
                        this.$router.push('/login');
                    }
                });
            }
        },
        data: function () {
            return {
                show_menu: true,
                title: {}
            }
        },
        components: {
            HeaderComponent,
            NavComponent
        },
        methods: {
            hide_menu: function () {
                this.show_menu = false;
            },
            show_menu_click: function () {
                this.show_menu = true;
            },
            change_title: function (title) {
                this.title = title;
            }
        }
    }
</script>

<style scoped>
    body, .main {
        min-width: 1133px;
    }

    .content, header.main-header {
        float: right;
        width: 100%;
        transition: all ease-in-out 0.5s;
    }

    .content.expand, .content.expand header.main-header {
        width: 85%;
    }

    main {
        margin-top: 60px;
    }
</style>