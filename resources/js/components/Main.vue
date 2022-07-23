<template>
  <v-app>
	  <v-card v-if="login == true">
		  <!-- Gocial App Bar   -->
		<v-app-bar
		:collapse-on-scroll="collapseOnScroll"
		min-width="200"
				
		scroll-target="#scrolling-techniques-6"
		>
		<v-app-bar-nav-icon  @click="drawer = true"></v-app-bar-nav-icon>
		<!-- Title  -->
		<v-toolbar-title>
			<router-link to='/' class='navbar-brand text-black'>Gocial </router-link>
		</v-toolbar-title>


		<v-spacer></v-spacer>
		<!-- Go To Profile With Avatar  -->
		<div class="justify-content-start align-item-start">
			<div class="col-5">
				<v-avatar
				@click="$router.push(`/profile`)"
					size="40"
					color="cyan"
				>
					<img :src="`/ProfilePhato/`+`${user.profile_phato}`" alt="alt">
				</v-avatar>
			</div>
		</div>

	


		
		


		<!-- Message Box  -->
		<div class="justify-content-start align-item-start py-3  ">
			<div class="col-5">
				<v-btn olor="black" icon outlined text>
					<v-icon>mdi-forum</v-icon>
				</v-btn>
			</div>
		</div>

		<!-- App Bar Controller -->
		<v-checkbox
        v-model="collapseOnScroll"
        color="black"
        hide-details
      ></v-checkbox>
		
		<!-- Tabs  -->
		<template v-slot:extension class="justify-content-start align-item-start col  ">
			<v-tabs align-with-title grow>
			<v-tab @click="$router.push(`/newfeed`)">
				New Feeds <v-icon>mdi-web</v-icon>
			</v-tab>

			<v-tab @click="$router.push(`/friend`)">
				Friends <v-icon>el-icon-user-solid</v-icon>
			</v-tab>

			<v-tab @click="$router.push(`/setting`)">Setting <v-icon>mdi-cog</v-icon></v-tab>
			</v-tabs>
		</template>
		</v-app-bar>
		
		<!-- Route View  -->
		<v-sheet
		id="scrolling-techniques-6"
		class="overflow-y-auto my-5 py-5 "
		max-height="550"
		max-width="auto"
		>

		
		<v-container   style="height: 1000px;" class="my-5 mb-5 ">
			<router-view :key="$route.path"></router-view>
		</v-container>
		</v-sheet>


		<!-- Navbar Drawer -->
		<v-navigation-drawer
			v-model="drawer"
			absolute
			temporary
			>
			<v-list
				nav
				dense
			>
				<v-list-item-group
				v-model="group"
				active-class="deep-purple--text text--accent-4"
				>
					<v-list-item v-if='login == false'>
						<Login @logined="Login" />
					</v-list-item>

					<v-list-item v-if='login == false'>
						<Register @logined="Login"  />
					</v-list-item>

					<v-list-item v-if='login == true'>
						<v-btn block text   @click="post_create = true"  class="col">
							Create Post <v-icon>mdi-newspaper-variant</v-icon>
						</v-btn>
						<PostCreate :dialog='post_create' @close="ClosePostCreate" />
					</v-list-item>

					<v-list-item v-if='login == true'>
						<v-btn    text  block @click="$router.push(`/save`)" >
							Save <v-icon>mdi-book</v-icon>
						</v-btn>
					</v-list-item>
					
					
	
				</v-list-item-group>
			</v-list>
    	</v-navigation-drawer>
	</v-card>
	<v-card v-if="login == false">
		<v-app-bar
		elevation="4"
		outlined
		rounded
		>
		<v-toolbar-title>
			<router-link to='/' class='navbar-brand text-black'>Gocial </router-link>
		</v-toolbar-title>
		<v-spacer></v-spacer>
		<Register @logined="Login"  />
		<Login @logined="Login" />
		</v-app-bar>
	</v-card>
  </v-app>
</template>
<script type="text/javascript">
    import Login from './Auth/Login';
    import Register from './Auth/Register';
    import PostCreate from './Layouts/Posts/PostCreate';
    export default {
        data(){
            return {
                token:localStorage.getItem('token'),
                user:{},
                login:false,
                collapseOnScroll:true,
				drawer: false,
     			 group: null,
				  post_create:false
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
            },
			ClosePostCreate(){
				this.post_create = false;
			}
        },
        mounted(){
            if(this.token != null){
            this.login = true;
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            axios.post(`/api/user`).then((response) => {
              this.user =  response.data;

              localStorage.setItem('user_email',this.user.email)
              localStorage.setItem('user_name',this.user.name);
              localStorage.setItem('user_profile_phato',this.user.profile_phato);
              localStorage.setItem('user_id',response.data.id)
            });
        }
        
        },
        components:{Login,Register,PostCreate}
    };
</script>
>