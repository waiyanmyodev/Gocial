<!-- Template  -->
<template>
	<div>

	  <div class="container bootstrap snippet">
	    <div class="row">
	  		<div class="col-xs-12 col-md-3 col-sm-12 col-lg-3 "><!--left col-->
	      <div class="text-center">
	        <v-avatar size='200'>
	        	<img :src="profile_phato" />
	        </v-avatar>
	        <br>
	        <div class="display-1">
	        	{{ user.name}}
	        </div>
	      </div><br> 
				  <v-card
				    class="mx-auto"
				    max-width="350"
				    tile
				  >
				    <v-list shaped>
				      <v-subheader>
				      	<b>About {{ user.name }} </b>
				      </v-subheader>
				      <v-list-item-group
				        color="red"
				      >
				      <!-- Friends -->
				        <v-list-item>
				          <v-list-item-content>
				            <v-list-item-title> 
				            	<b>Friends</b>
				            </v-list-item-title>
				          </v-list-item-content>
				          <v-list-item-icon>
				            <v-icon>el-icon-user-solid</v-icon>
				          </v-list-item-icon>
				        </v-list-item>
				        <!--  Email -->
				        <v-list-item>
				        	<v-list-item-content>
				        		<v-list-item-title>
				        			<b>{{ user.email }}</b>
				        		</v-list-item-title>
				        	</v-list-item-content>
				        	<v-list-item-icon>
				        		<v-icon>mdi-email</v-icon>
				        	</v-list-item-icon>
				        </v-list-item>
				        <!-- Birthday  -->
				        <v-list-item>
				        	<v-list-item-content>
				        		<v-list-item-title>
				        			<b>{{ user.birthday }}</b>
				        		</v-list-item-title>
				        	</v-list-item-content>
				        	<v-list-item-icon>
				        		<v-icon>mdi-cake</v-icon>
				        	</v-list-item-icon>
				        </v-list-item>

				        <!-- Gender  -->
				        <v-list-item>
				        	<v-list-item-content>
				        		<v-list-item-title> 
				        			<b>{{ user.gender }}</b>
				        		</v-list-item-title>
				        	</v-list-item-content>
				        	<v-list-item-icon>
				        		<v-icon v-if="user.gender == 'male'">el-icon-male</v-icon>
				        		<v-icon v-if="user.gender == 'female'">el-icon-female</v-icon>
				        		
				        	</v-list-item-icon>
				        </v-list-item>
				        <!-- Relationship Status  -->
				        <v-list-item v-if="details.relationship_status != 'none'">
				        	<v-list-item-content>
				        		<v-list-item-title>
				        			<b>{{ details.relationship_status }} </b>
				        		</v-list-item-title>
				        	</v-list-item-content>
				        	<v-list-item-icon>
				        		<v-icon>mdi-heart</v-icon>
				        	</v-list-item-icon>
				        </v-list-item>
				        <!--  Phone Number  -->
				        <v-list-item v-if="details.phone_number != 'none'">
				        	<v-list-item-content>
				        		<v-list-item-title>
				        			<b>{{ details.phone_number }} </b>
				        		</v-list-item-title>
				        	</v-list-item-content>
				        	<v-list-item-icon>
				        		<v-icon>el-icon-phone</v-icon>
				        	</v-list-item-icon>
				        </v-list-item>
				        <!--  Work  -->
				        <v-list-item v-if="details.work != 'none'">
				        	<v-list-item-content>
				        		<v-list-item-title>
				        			<b>{{ details.work }} </b>
				        		</v-list-item-title>
				        	</v-list-item-content>
				        	<v-list-item-icon>
				        		<v-icon>el-icon-suitcase</v-icon>
				        	</v-list-item-icon>
				        </v-list-item>
				        <!-- Links  -->
				        <v-list-item v-if="details.links != 'none'">
				        	<v-list-item-content>
				        		<v-list-item-title>
				        			<b class="links">{{ details.links }}</b>
				        		</v-list-item-title>
				        	</v-list-item-content>
				        	<v-list-item-icon>
				        		<v-icon>el-icon-link</v-icon>
				        	</v-list-item-icon>
				        </v-list-item>
				        <!-- Nickname -->
				        <v-list-item v-if="details.nickname != 'none'">
				        	<v-list-item-content>
				        		<v-list-item-title>
				        			<b>{{ details.nickname }}</b>
				        		</v-list-item-title>
				        	</v-list-item-content>
				        	<v-list-item-icon>
				        		<v-icon>el-icon-s-custom</v-icon>
				        	</v-list-item-icon>
				        </v-list-item>
				        <!-- Website -->
				        <v-list-item v-if="details.website != 'none'">
				        	<v-list-item-content>
				        		<v-list-item-title>
				        			<b class="links">{{ details.website }}</b>
				        		</v-list-item-title>
				        	</v-list-item-content>
				        	<v-list-item-icon>
				        		<v-icon>mdi-earth</v-icon>
				        	</v-list-item-icon>
				        </v-list-item>


				        <!-- More Details -->
				        
				        <ProfileDetails :details="details" @updateDetails="UpdateDetails" />
				        
				      </v-list-item-group>
				    </v-list>
				  </v-card>

	              
	        </div><!--/col-3-->
	    	<div class="col-sm-12 col-xs-12 col-md-9 col-lg-9">
	    	<v-app-bar
	    	  flat
		      color="white"
		    >

		      <v-toolbar-title>
		      	<b>
		      		Profile
		      	</b>
		      </v-toolbar-title>

		      <v-spacer></v-spacer>



		      <v-btn icon>
		        <v-icon>mdi-dots-vertical</v-icon>
		      </v-btn>
		    </v-app-bar>

	              
	          <div class="tab-content">
	            <div class="tab-pane active" id="home">
	      
	            	<Post :post="post" v-for='(post,id) in posts' :key='id'/>

	            </div><!--/tab-pane-->
	          </div><!--/tab-content-->

	        </div><!--/col-9-->

	    </div><!--/row-->
		<!-- -->
	</div>
	</div>
</template>

<!--  javascript  -->
<script type="text/javascript">
 	import ProfileDetails from './Details';
 	import Post from '../Layouts/Posts/Post';
	export default {
		data(){
			return {
				token:localStorage.getItem('token'),
				user:{},
				profile_phato:'',
				details:{},
				null:null,
				posts:null
			}
		},
		methods:{
			UpdateDetails(){
				axios.post('api/details',{user_id:this.user.id}).then((response) => {
				   var details = response.data;
				   this.details = details[0]
				 });
			}
		},
		created(){
			// getting user data and setting axios auth token
			if (this.token != null) {
				window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
				axios.post('api/user').then((response) => {
				 this.user = response.data;
				 this.profile_phato = 'ProfilePhato/'+response.data.profile_phato;
				 axios.post('api/details',{user_id:this.user.id}).then((response) => {
				   var details = response.data;
				   this.details = details[0]
				 });
				 // Getting Post For User
				 axios.post(`api/post/${this.user.id}`).then((res) => {
				 	this.posts =  res.data;
				  });  


				});
			};


			// end 
		},
		components:{ProfileDetails,Post}
	};
</script>

<!-- css  -->
<style type="text/css">
	 .img-circle {
	 	border-radius: 50%;
	 }
</style>

