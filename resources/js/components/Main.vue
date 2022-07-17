<template>
  <v-app>
	  <v-card >
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
				<v-btn  icon outlined>
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

			<v-tab>Setting <v-icon>mdi-cog</v-icon></v-tab>
			</v-tabs>
		</template>
		</v-app-bar>
		
		<!-- Route View  -->
		<v-sheet
		id="scrolling-techniques-6"
		class="overflow-y-auto my-5 py-5 "
		max-height="550"
		>

		
		<v-container   style="height: 1000px;">
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
						<PostCreate />
					</v-list-item>

					
					

				</v-list-item-group>
			</v-list>
    	</v-navigation-drawer>
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
>