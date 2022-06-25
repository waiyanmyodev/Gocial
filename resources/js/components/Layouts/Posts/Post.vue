<template>
	<v-card class="my-3 ">
		<v-card-title>
		 <div class="row">
			 <!-- Post Owner Image  -->
			<div class="col-2 col-md-1 mr-lg-2 ">
				<v-avatar color="grey darken-3">
			          <v-img
			            class="elevation-6 "
			            alt=""
			            :src="UserData.image"
			          ></v-img>
			    </v-avatar>
			</div>
			<div class="col-8 d-flex flex-column">
				<!-- Post  Owner User Name  -->
				<div>
					
			        <b>
						<router-link :to='profile' class='name black--text' >
							{{ UserData.name  }}
						</router-link>
						<span v-if="post.feeling != 'none'" class="font-weight-regular subtitle-1">
			        	 	  {{ empty }} {{ post.feeling }}
			        	</span>
			        </b>
				</div>
				<!-- Post Date Time  -->
				<div>
					<b class='text-muted font-weight-regular subtitle-1'>
	        			{{date.years }} {{ date.months }}  {{ date.days }}
	        			<v-icon v-if="post.reach_to == 'public'">mdi-earth</v-icon>

	        			<v-icon v-if="post.reach_to == 'friends'">mdi-account-multiple</v-icon>
	        		</b>
				</div>
			</div>

		 </div>

			<v-spacer></v-spacer>

	    

		<v-menu >
			<template  v-slot:activator="{ on , attr }">
				<v-btn fab icon v-bind="attr" v-on="on">
					<v-icon>mdi-dots-vertical</v-icon>
				</v-btn>	
			</template>		
			<v-list>
				<v-list-item v-for="item in MoreOptions" :key="item.title">
					<v-list-item-title v-if="item.access == true">
						<v-btn block v-on:click="item.function" >
							{{ item.title }} <v-icon>{{ item.icon }}</v-icon>
						</v-btn>
					</v-list-item-title>
				</v-list-item>
			</v-list>
			
		</v-menu>
		<v-dialog
				v-model="whoLikeMyPost"
				max-width="500px"
				height="500px"
			>
				<v-card>
					<v-card-title color="cyan  lighten-3">
						<div>
							<h3 class="headline mb-0">Who Like The Post ? </h3>
						</div>
					</v-card-title>
					<v-card-text>
						<v-list subheader>
						<v-subheader>Liked Peoples</v-subheader>

						<v-list-item
							v-for="people in likedPeoples"
							:key="people.name"
						>
							<v-list-item-avatar>
							<v-img
								:alt="`${people.name} avatar`"
								:src="`/ProfilePhato/`+people.phato"
							></v-img>
							</v-list-item-avatar>

							<v-list-item-content>
							<v-list-item-title >
								<router-link :to="`/profile/user/${people.id}`" class='name black--text' >
									{{ people.name  }}
								</router-link>
							</v-list-item-title>
							</v-list-item-content>

							<v-list-item-icon>
							<v-icon color="primary">
								mdi-thumb-up
							</v-icon>
							</v-list-item-icon>
						</v-list-item>
						</v-list>
			
					</v-card-text>
					<v-card-actions>
						
					</v-card-actions>
				</v-card>
			</v-dialog>
	        
		</v-card-title>
		<!-- Post Content  -->
		<v-card-text :class="`${post.text_color}--text`">
			{{ post.content }}
		</v-card-text>
		<!-- Post Image  -->
		<v-carousel>
			<v-carousel-item
				v-for="(item,index) in this.postData.image"
				:key='index'
				:src='`/PostPhato/`+item'
			></v-carousel-item>
		</v-carousel>
		<!-- Post share like comment counts  -->

			<!-- Post Like, Share ,Comment 
				Like is for like the post and response to post owner
				Share is for share to NewFeed,Friends,Other....
				Comment is for Blame XD:
			 -->
	        	<div class="d-flex align-content-center flex-row col-12  border border-light " color="cyan">
					<!-- ================ Like ===================== -->
		         	<v-btn  class="col-4 text-center py-5 " @click='Like'  @contextmenu.prevent="WhoLikeMyPost">
			         		<v-icon  >
					            mdi-thumb-up
					        </v-icon>
				        
	          			<span class="subheading" v-if="post.likes != '0'">{{ post.likes }}</span>

		         	</v-btn>
					<!--  ================ Comment ================== -->
					<v-btn class="col-4 text-center py-5 btn-block " v-if="post.comment_open == 1" @click="ShowAllComment">
						<v-icon>
						mdi-message
					</v-icon>
						<span class="subheading" v-if="post.comments != '0'">{{ post.comments }}
						</span>

					</v-btn>
		         	
					<!-- ================== Share ====================== -->
		         	<v-btn class="col-4 text-center py-5 " v-if="post.share_open == 1">
		         		<v-icon>
				            mdi-share-variant
				        </v-icon>
				        <span class="subheading" v-if="post.shares != '0'">{{post.shares}}</span>

		         	</v-btn>
		         </div>
				 	<!-- ============================ SHOW ALL COMMENTS ========================== -->
				 <v-expand-x-transition>
		         	<ShowAllComment  :comments='comments' :user='user' :post='post'  v-show="cmtbox"/> 
		         </v-expand-x-transition>
				 <!-- ================================ Comment Create ============================= -->
				 <CommentCreate :post_id='post.id'  v-if="post.comment_open == 1" />
	         

	</v-card>
</template>
<script type="text/javascript">
	import CommentCreate from './Comments/CommentCreate';
	import ShowAllComment from './Comments/ShowAllComment';
	export default {
		props:['post'],
		data(){
			return {
				user:localStorage.getItem('user'),
				postData:{
					image:null,
					content:null,
				},
				UserData:{
					image:null,
					name:null,
				},
				date:{
					days:null,
					months:null,
					years:null,
				},
				empty:'  is ',
				like:null,
				comments:null,
				cmtbox:false,
				profile:'/profile/user/'+this.post.user_id,
				MoreOptions:[
					{
						'title':'Edit ',
						'icon':'mdi-playlist-edit',
						'function':this.EditThePost,
						'access':true
					},
					{
						'title':'Delete Post',
						'icon':'mdi-trash-can-outline',
						'function':this.DeletePost,
						'access':localStorage.getItem('user_id') == this.post.user_id ? true : false
					},
				],
				whoLikeMyPost:false,
				likedPeoples:[]
			}
		},
		methods:{
			// Show Comment 
			ShowAllComment(){
 				this.cmtbox = !this.cmtbox;
				 this.GetComments();
			},
			// Get User Data
			getUserData(id){
				axios.post(`/api/post/user/${id}`).then((res) => {
					this.UserData.image = "/ProfilePhato/"+res.data.profile_phato;
					this.UserData.name  = res.data.name;
					this.UserData.id  = res.data.id;
				});
			},
			// Get Post Date Time 
			DatePicker(){
				const months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
				const d = new Date(this.post.created_at);
				this.date.months = months[d.getMonth()];
				this.date.days = d.getDate();
				this.date.years = d.getFullYear();
			},
			// Get Post 
			FormatPostData(){
				this.postData.content  = this.post.content;
				this.postData.image = JSON.parse(this.post.phato);

			},
			ifLike(){
				axios.post(`/api/post/iflike/${this.post.id}/${this.post.user_id}`).then((res) => {
					if(res.data == 1){
						this.like = true;
					}else {
						this.like = 'blue--text';
					}
				})
			},
			// Current User Data
			CurrentUser(){
				axios.post(`/api/user`).then((res) => {
					this.user = res.data;
				})
			},
			// Like Object 
			Like(){
				axios.post(`/api/post/like/${this.post.id}/${this.user.id}`).then((res) => {
					if(res.data == 1){
						this.post.likes = parseInt(this.post.likes) + 1;
						this.like == 'blue--text';
					}else {
						this.post.likes = parseInt(this.post.likes) - 1;
						this.like == true;
					}
				})
			},
			// Get Post Comments
			GetComments(){
				axios.post(`/api/comment/${this.post.id}`).then((res) => {
					this.comments =  res.data;
				})
			}
			// Edit Post Function
			,EditThePost(){
				
			},

			// Delete Post Function 
			DeletePost(){
				if(this.user.id == this.post.user_id){
					axios.post(`/api/post/${this.post.id}/delete`,{user_id:this.user.id}).then((res) => {
						if(res.data == '1'){
							this.$message.success('Post Deleted!')
						}
					})
				}
			},

			// Who like the post 
			WhoLikeMyPost(){
				this.whoLikeMyPost = true;
				axios.post(`/api/post/like/${this.post.id}`).then((res) => {
					this.likedPeoples = res.data;
				})
			}


		},
		// Component is mounted!
		mounted(){
			console.log(localStorage.getItem('user_id'))
			this.CurrentUser();
			this.ifLike();
			this.DatePicker();
			this.getUserData(this.post.user_id);
			this.FormatPostData();
			this.GetComments();
		},
		// Components 
		components:{CommentCreate,ShowAllComment}
	};
</script>
<style>
	.name {
		text-decoration: none;
		color: black;
	}
</style>