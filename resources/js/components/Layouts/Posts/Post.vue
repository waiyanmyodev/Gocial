<template>
	<v-card class="my-5 rounded-lg " >
			<v-list class="col">
			<v-list-item >
				<v-list-item-avatar size="50">
					<v-img  :src="`/ProfilePhato/`+post.user_data.profile_phato">
						
					</v-img>
				</v-list-item-avatar>
				<v-list-item-content>
					<v-list-item-title >
						<div>
							<b>
								<router-link :to='profile' class='name black--text ' >
									{{ post.user_data.name  }}
								</router-link>
								<span v-if="post.feeling != 'none'" class="font-weight-regular subtitle-1">
									{{ empty }} {{ post.feeling }}
								</span>
							</b>
						</div> 
					</v-list-item-title>
					<v-list-item-subtitle>
						<b class='text-muted font-weight-regular subtitle-1'>
							{{date.years }} {{ date.months }}  {{ date.days }}
							<v-icon v-if="post.reach_to == 'public'">mdi-earth</v-icon>

							<v-icon v-if="post.reach_to == 'friends'">mdi-account-multiple</v-icon>
						</b>
					</v-list-item-subtitle>
				</v-list-item-content>
				<v-spacer></v-spacer>
				<v-list-item-icon>
					<v-menu :close-on-content-click='false' >
					<template  v-slot:activator="{ on , attr }">
						<v-btn fab icon v-bind="attr" v-on="on">
							<v-icon>mdi-dots-vertical</v-icon>
						</v-btn>	
					</template>		
					<v-list>
						<!-- Save Button Function -->
						<v-list-item v-if="save == false ">
							<v-list-item-title>
								<v-btn block @click="SavePost">
									Save Post <v-icon>mdi-book-plus</v-icon>
								</v-btn>
							</v-list-item-title>
						</v-list-item>

						<v-list-item v-if="save == true ">
							<v-list-item-title>
								<v-btn block @click="UnSavePost">
									UnSave Post <v-icon>mdi-book-minus</v-icon>
								</v-btn>
							</v-list-item-title>
						</v-list-item>
						<!-- Post Edit Function -->
						<v-list-item v-if="user.id == post.user_id ? true : false">
							<v-list-item-title  >
								<v-btn block @click="PostEditDialog = true ">
									Edit <v-icon>mdi-playlist-edit</v-icon>
								</v-btn>

								<v-dialog
									v-model="PostEditDialog"
									scrollable  persistent
									min-height="1000" width='700'
									transition="dialog-transition"
								>
									<EditPost :original_post="post" @done="PostEditDialog = false" />
								</v-dialog>
							</v-list-item-title>
						</v-list-item>
						<!-- Delete Post Function  -->
						<v-list-item v-if="user.id == post.user_id ? true : false" >
							<v-list-item-title >
								<v-btn block @click="DelConfirm = true" >
									Delete Post <v-icon>mdi-trash</v-icon>
								</v-btn>
								<v-dialog
								
									v-model="DelConfirm"
									persistent :overlay="false"
									max-width="290"
									transition="dialog-transition"
								>
									<v-card>
										<v-card-title class="text-h5">
											Are You Sure To Delete This Post ?
										</v-card-title>
										<v-card-text>This post will be can't recover.</v-card-text>
										<v-card-actions>
										<v-spacer></v-spacer>
										<v-btn
											color="green darken-1"
											text
											@click="DelConfirm = false"
										>
											Cancel
										</v-btn>
										<v-btn
											color="red darken-1"
											text
											@click="DeletePost"
										>
											Confirm
										</v-btn>
										</v-card-actions>
									</v-card>
								</v-dialog>
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
										<b @click="$router.push({path:`/profile/user/${people.id}`})" class='name black--text' >
											{{ people.name  }}
										</b>
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
	        
				</v-list-item-icon>
			</v-list-item>
		</v-list>

		
		<!-- Post Content  -->
		<v-card-text :class="`${post.text_color}--text`">
			{{ post.content }}
		</v-card-text>
		<!-- Post Image  -->
		<v-carousel>
			<v-carousel-item
				v-for="(item,index) in this.post.phato"
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
		         	<v-btn text  class="col-4 text-center py-5 " @click='Like'  @contextmenu.prevent="WhoLikeMyPost">
			         		<v-icon  >
					            mdi-thumb-up
					        </v-icon>
				        
	          			<span class="subheading" v-if="post.likes != '0'">{{ post.likes }}</span>

		         	</v-btn>
					<!--  ================ Comment ================== -->
					<v-btn text class="col-4 text-center py-5 btn-block " v-if="post.comment_open == 1" @click="ShowAllComment">
						<v-icon>
						mdi-message
					</v-icon>
						<span class="subheading" v-if="post.comments != '0'">{{ post.comments }}
						</span>

					</v-btn>
		         	
					<!-- ================== Share ====================== -->
		         	<v-btn text class="col-4 text-center py-5 " v-if="post.share_open == 1">
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
import EditPost from './EditPost';
	export default {
		props:['post'],
		data(){
			return {
				user:{
					id:localStorage.getItem('user_id')
				},
				date:{
					days:null,
					months:null,
					years:null,
				},
				empty:'  is ',
				comments:null,
				cmtbox:false,
				profile:`/profile/user/`+this.post.user_id,
				DelConfirm:false,
				PostEditDialog:false,
				whoLikeMyPost:false,
				likedPeoples:[],
				save:null
                
			}
		},
		methods:{
			// Show Comment 
			ShowAllComment(){
 				this.cmtbox = !this.cmtbox;
				 this.GetComments();
			},
			// Get Post Date Time 
			DatePicker(){
				const months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
				const d = new Date(this.post.created_at);
				this.date.months = months[d.getMonth()];
				this.date.days = d.getDate();
				this.date.years = d.getFullYear();
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
					}else {
						this.post.likes = parseInt(this.post.likes) - 1;
					}
				})
			},
			// Get Post Comments
			GetComments(){
				axios.post(`/api/comment/${this.post.id}`).then((res) => {
					this.comments =  res.data;
				})
			},

			// Delete Post Function 
			DeletePost(){
				if(this.user.id == this.post.user_id){
					axios.post(`/api/post/${this.post.id}/delete`,{user_id:this.user.id}).then((res) => {
						if(res.data == '1'){
							this.$message.success('Post Deleted!')
							this.DelConfirm = false;
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
			},
			// Save The Post 
			SavePost(){
				var data = {
					user_id:this.user.id,
					save_category_id:this.post.id,
					save_type:"Post"
				}
				axios.post(`/api/post/save`,data).then((res) => {
					if(res.data == true){
						this.$message.success('Post Saved!');
						
					}else {
					}
					this.IfSavePost()
				})
			},
			UnSavePost(){
				var data = {
					user_id:this.user.id,
					save_category_id:this.post.id,
					save_type:"Post"
				}
				axios.post(`/api/post/unsave`,data).then((res) => {
					if(res.data == true){
						this.$message.success('Post Unsaved!');
						this.IfSavePost()
					}else {
					}
				})
			},
			IfSavePost(){
				var data = {
					user_id:this.user.id,
					save_category_id:this.post.id,
					save_type:"Post"
				}
				axios.post(`/api/post/ifsave`,data).then((res) => {
					this.save = res.data;
				})
			}


		},
		// Component is mounted!
		mounted(){
            this.post.phato = eval(this.post.phato)
			this.CurrentUser();
			this.DatePicker();
			this.GetComments();
			this.IfSavePost();
		},
		// Components 
		components:{CommentCreate,ShowAllComment,EditPost}
	};
</script>
