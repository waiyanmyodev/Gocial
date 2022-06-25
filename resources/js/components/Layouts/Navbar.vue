<template>
    <div>
        <v-app class='v-app mb-3 '>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top mb-3 ">
            <div class="container">
                    <router-link to='/' class='navbar-brand' color="cyan lighten-1">Gocial </router-link>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto" data-app>
                        <!-- Authentication Links -->
                                <li class="nav-item" v-if='login == false'>
                                    <Login @logined="Login"/>
                                </li>
                                <li class="nav-item mx-2 " v-if='login == false'>
                                    <Register @logined="Login" />
                                </li>
                                <li class="nav-item mx-2" v-if='login == true'>
                                    <PostCreate />
                                </li>
                            <li class="nav-item dropdown" v-if='login == true '>
                                <div class="text-center">
                            <v-menu>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn
                                        v-bind="attrs"
                                        v-on="on"
                                    >
                                    {{ user.name }} <i class="el-icon-user-solid"></i>
                                    </v-btn>
                                    </template>

                                    <v-list>
                                     <v-list-item @click="Logout">
                                        <v-list-item-title>
                                            Logout
                                        </v-list-item-title>
                                     </v-list-item>
                                     <v-list-item>
                                        <v-list-item-title>
                                            <router-link to="/profile" class="link">profile</router-link>
                                        </v-list-item-title>
                                     </v-list-item>
                                    </v-list>
                            </v-menu>
                                </div>
                            </li>
                    </ul>
                </div>
            </div>
        </nav>
    </v-app>
    </div>
</template>

<script type="text/javascript">
    import Login from '../Auth/Login';
    import Register from '../Auth/Register';
    import PostCreate from './Posts/PostCreate';
    export default {
        data(){
            return {
                token:localStorage.getItem('token'),
                user:{},
                login:false
            }
        },
        methods:{
            Logout(){
                this.login = false;
                this.token = null;
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                localStorage.removeItem('user_id');
            },
            Login(){
                this.login = true;
                axios.post(`/api/user`).then((response) => {
                    this.user =  response.data;
                    localStorage.setItem('user',response.data)
                    localStorage.setItem('user_id',response.data.id)
                });
            }
        },
        mounted(){
            if(this.token != null){
            this.login = true;
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            axios.post(`/api/user`).then((response) => {
              this.user =  response.data;
              localStorage.setItem('user',response.data)
              localStorage.setItem('user_id',response.data.id)
            });
        }
        
        },
        components:{Login,Register,PostCreate}
    };
</script>
<style type="text/css">
    .v-app {
        height: 6rem;
    }
    .navbar {
        height: 4rem;
    }
</style>