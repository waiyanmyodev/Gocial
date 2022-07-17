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
			<!-- User Name -->
	        <div class="display-1">
	        	{{ profile_user.name}}
	        </div>
		  <!-- Friend Add Btn follow -->
		  <el-button  type="primary"  class="col col-md-6 col-lg-12 col-sm-4" style="color:white" @click="AddFriend" v-if="friendship.friend != true && friendship.request != true && friendship.pendding != true" >
			   Add Friend <v-icon >mdi-account-plus</v-icon>
		  </el-button>

		  <el-button  type="primary"  class="col col-md-6 col-lg-12 col-sm-4" style="color:white" v-if="friendship.pendding == true" @click="viewMore = true" >
			   Response... <v-icon>mdi-check</v-icon>
		  </el-button>

		  <el-button  type="primary"  class="col col-md-6 col-lg-12 col-sm-4" style="color:white" v-if="friendship.friend == true"  >
			   Friend <v-icon color="green--text">mdi-check</v-icon>
		  </el-button>

		  <el-button  type="primary"  class="col col-md-6 col-lg-12 col-sm-4" style="color:white" v-if="friendship.request == true"  @click="Unfriend" >
			   Pending... <v-icon>mdi-clock</v-icon>
		  </el-button>



	      </div><br> 
				  <v-card
				    class="mx-auto"
				    max-width="350"
				    tile
				  >
				    <v-list shaped>
				      <v-subheader>
				      	<b>About {{ profile_user.name }} </b>
				      </v-subheader>
				      <v-list-item-group
				        color="cyan "
				      >
				      <!-- Friends -->
				        <FriendsView  /> 
				        
				        <!-- Birthday  -->
				        <v-list-item>
				        	<v-list-item-content>
				        		<v-list-item-title>
				        			<b>{{ profile_user.birthday }}</b>
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
				        			<b>{{ profile_user.gender }}</b>
				        		</v-list-item-title>
				        	</v-list-item-content>
				        	<v-list-item-icon>
				        		<v-icon v-if="profile_user.gender == 'male'">el-icon-male</v-icon>
				        		<v-icon v-if="profile_user.gender == 'female'">el-icon-female</v-icon>
				        		
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



		      <v-btn icon @click="OpenMore()">
		        <v-icon>mdi-dots-vertical</v-icon>
		      </v-btn>

			  <v-dialog
				  v-model="viewMore"
				  scrollable fullscreen 
				  persistent :overlay="false"
 				  transition="dialog-transition"
			  >
				  <v-card>

					  <v-card-title>
						  <div>
							  <h3 class="headline mb-0 bold">Profile</h3>
						  </div>
						  <v-spacer></v-spacer>
							<v-btn  icon color="black" @click="viewMore=!viewMore">
								<v-icon>mdi-close</v-icon>
							</v-btn>
					  </v-card-title>
					  <v-divider></v-divider>
					  <v-card-text>
						  <!-- Add Friend Button  -->
							<el-button  type="primary" class="col"  style="color:white" @click="AddFriend" v-if="friendship.friend != true && friendship.request != true && friendship.pendding != true"  >
								Add Friend <v-icon>mdi-account-plus</v-icon>
							</el-button>
						 <!--  Respones Button  -->
							<div class="row col justify-content-center align-item-centerf">

								<el-button  type="white" class="col-5" color="black--text"   v-if="friendship.pendding == true" @click="Unfriend" >
								Cancel  <v-icon color="white--text">mdi-account-remove</v-icon>
								</el-button>

								<el-button  type="primary" class="col-5"  style="color:white" v-if="friendship.pendding == true" @click="FirConfirm" >
									Confirm <v-icon>mdi-check</v-icon>
								</el-button>

							
							</div>
						 <!-- Unfriend BUtton  -->
							<el-button  type="primary" class="col"  style="color:white" v-if="friendship.friend == true"  @click="Unfriend">
								Unfriend <v-icon>mdi-account-minus</v-icon>
							</el-button>
						 <!-- Pending Button  -->
							<el-button  type="primary" class="col"  style="color:white" v-if="friendship.request == true" @click="Unfriend" >
							Cancel Request <v-icon color="white--text">mdi-account-remove</v-icon>
							</el-button>
							
						  <br> <br>
						  <!-- block button  -->
							<el-button  type="danger"  block style="color:white"  class="col" @click="Block()" >
									Block <v-icon>mdi-account-cancel</v-icon>
							</el-button>
					  </v-card-text>
				  </v-card>
			  </v-dialog>
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
 	import Post from '../Layouts/Posts/Post';
 	import FriendsView from './FriendsView';
	export default {
		data(){
			return {
				token:localStorage.getItem('token'),
				user:{},
				profile_user:{},
				profile_phato:'',
				details:{},
				null:null,
				posts:null,
				friendship:{
					friend:null,
					block:null,
					request:null,
					pendding:null,
				},
				viewMore:false
			}
		},
		methods:{
			// update profile details 
			UpdateDetails(){
				axios.post('api/details',{user_id:$route.params.id}).then((response) => {
				   var details = response.data;
				   this.details = details[0]
				 });
			},
			// Add Friend Function 
			AddFriend(){
				var data  =  {
					user_id:this.user.id,
					friend_id:this.$route.params.id
				};
				axios.post(`/api/friend/add`,data)
				.then(res => {
	
					if(res.data == true){
						this.friendship.request = true;
						this.friendship.friend = null;
					}
				})
				.catch(err => {
					console.error(err); 
				});
			},
			// Show More Function 
			OpenMore(){
				this.viewMore = !this.viewMore;

			},
			// Block User
			Block(){
				var data = {
					user_id:this.user.id,
					friend_id:this.$route.params.id
				}
				axios.post(`/api/friend/block`,data).then((res) => {
					this.friendship.block = res.data;
				})
			},
			// Unfriend User Function 
			Unfriend(){
				var data = {
					user_id:this.user.id,
					friend_id:this.$route.params.id
				}
				axios.post(`/api/friend/unfriend`,data).then((res) => {
					if(res.data == true){
						this.friendship.friend = false;
						this.friendship.request = false;
						this.friendship.pending = false;
					}
				})
			},
			FirConfirm(){
				var data = {
					user_id:this.user.id,
					friend_id:this.$route.params.id
				}
				axios.post(`/api/friend/accept`,data).then((res) => {
					if(res.data == true){
						this.friendship.friend = true;
						this.friendship.pendding = false;
					}
				})
			}
		},
		created(){
			// getting user data and setting axios auth token
			axios.post(`/api/profile/${this.$route.params.id}`).then((res) => {
					 this.profile_user = res.data;
					 this.profile_phato = '/ProfilePhato/'+res.data.profile_phato;   
				 })
			if (this.token != null) {
				// Getting User Data .. 
				window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
				axios.post(`/api/user`).then((response) => {
				 this.user = response.data;
				// Getting Details 
				 axios.post('/api/details',{user_id:this.$route.params.id}).then((response) => {
				   var details = response.data;
				   this.details = details[0]
				 });
				 // Getting Post For User
				 axios.post(`/api/post/${this.$route.params.id}`).then((res) => {
				 	this.posts =  res.data;
				  });  
				 // Checking User is friend
				 const data = {
					 user_id:this.user.id,
					 friend_id:this.$route.params.id,
				 };
				 // Checking User is friend with you 
				 axios.post(`/api/friend/is-friend`,data).then((res) => {
					 this.friendship.friend = res.data;
				 })

				 // Check The Friend is pendding 
				 axios.post(`/api/friend/is-pendding`,data).then((res) => {
					 this.friendship.pendding = res.data;
				 })
				// Checking User is request to you
				 axios.post(`/api/friend/is-request`,data).then((res) => {
					 this.friendship.request = res.data;
				 })
				if(this.user.id == this.$route.params.id){
					this.$router.push(`/profile`)
				}

				});
			};

			
			// end 
		},
		
		components:{Post,FriendsView}
	};
</script>

<!-- css  -->
<style type="text/css">
	 .img-circle {
	 	border-radius: 50%;
	 }
	 .btn-add-friend {
		 background: rgb(77, 146, 224);
		 max-width: 350px;
		 min-width: 250px;
	 }
</style>

