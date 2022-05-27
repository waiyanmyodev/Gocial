<template>
	<v-card class="my-3 ">
		<v-card-title>
		 <div class="row">
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
				<div>
					
			        <b>
						{{ UserData.name }}
						<span v-if="post.feeling != 'none'" class="font-weight-regular subtitle-1">
			        	 	  {{ empty }} {{ post.feeling }}
			        	</span>
			        </b>
				</div>
				<div>
					<b class='text-muted font-weight-regular subtitle-1'>
	        			{{date.years }} {{ date.month }}  {{ date.days }}
	        			<v-icon v-if="post.reach_to == 'public'">mdi-earth</v-icon>

	        			<v-icon v-if="post.reach_to == 'friends'">mdi-account-multiple</v-icon>
	        		</b>
				</div>
			</div>

		 </div>

			<v-spacer></v-spacer>

	        
	        
		</v-card-title>
		<v-card-text :class="`${post.text_color}--text`">
			{{ post.content }}
		</v-card-text>
		<v-img :src="postData.image"></v-img>

	        <hr>
	        	<div class="d-flex align-content-center flex-row col-12  border border-light " color="cyan">
		         	<v-btn class="col-4 text-center py-5 " @click='Like' >
			         		<v-icon >
					            mdi-thumb-up
					        </v-icon>
				        
	          			<span class="subheading" v-if="post.likes != '0'">{{ post.likes }}</span>

		         	</v-btn>

		         	 	<v-btn class="col-4 text-center py-5 btn-block " v-if="post.comment_open == 1" @click="ShowAllComments">
							<v-icon>
					       mdi-message
					    </v-icon>
							<span class="subheading" v-if="post.comments != '0'">{{ post.comments }}
							</span>

						</v-btn>
		         	

		         	<v-btn class="col-4 text-center py-5 " v-if="post.share_open == 1">
		         		<v-icon>
				            mdi-share-variant
				        </v-icon>
				        <span class="subheading" v-if="post.shares != '0'">{{post.shares}}</span>

		         	</v-btn>
		         </div>
		         <ShowAllComment :comments='comments' :user='user' :post='post'  v-if="cmtbox == true"/> 
		         <CommentCreate :post_id='post.id'  />
	         

	</v-card>
</template>
<script type="text/javascript">
	import CommentCreate from './Comments/CommentCreate';
	import ShowAllComment from './Comments/ShowAllComment';
	export default {
		props:['post'],
		data(){
			return {
				user:null,
				postData:{
					image:null,
					content:null,
				},
				UserData:{
					image:null,
					name:null,
				},
				date:{
					secounds:null,
					minutes:null,
					hours:null,
					days:null,
					day:null,
					month:null,
					months:null,
					years:null,
				},
				empty:'  is ',
				like:null,
				comments:null,
				cmtbox:false
			}
		},
		methods:{
			// Show Comment 
			ShowAllComment(){
 				this.cmtbox = !this.cmtbox;
			},
			// Get User Data
			getUserData(id){
				axios.post(`api/post/user/${id}`).then((res) => {
					this.UserData.image = "ProfilePhato/"+res.data.profile_phato;
					this.UserData.name  = res.data.name;
				});
			},
			// Get Post Date Time 
			GetPostDatetime(id){
				axios.post(`api/post/date/${id}`).then((res) => {
					this.date = res.data;
				})
			},
			// Get Post 
			FormatPostData(){
				this.postData.content  = this.post.content;
				this.postData.image = 'PostPhato/'+this.post.phato;

			},
			ifLike(){
				axios.post(`api/post/iflike/${this.post.id}/${this.post.user_id}`).then((res) => {
					if(res.data == 1){
						this.like = true;
					}else {
						this.like = 'blue--text';
					}
				})
			},
			CurrentUser(){
				axios.post('api/user').then((res) => {
					this.user = res.data;
				})
			},
			Like(){
				axios.post(`api/post/like/${this.post.id}/${this.post.user_id}`).then((res) => {
					if(res.data == 1){
						this.post.likes = parseInt(this.post.likes) + 1;
						this.like == 'blue--text';
					}else {
						this.post.likes = parseInt(this.post.likes) - 1;
						this.like == true;
					}
				})
			},
			
			GetComments(){
				axios.post(`api/comment/${this.post.id}`).then((res) => {
					this.comments =  res.data;
				})
			}

		},
		mounted(){
			this.ifLike();
			this.GetPostDatetime(this.post.id);
			this.getUserData(this.post.user_id);
			this.FormatPostData();
			this.GetComments();
		},
		components:{CommentCreate,ShowAllComment}
	};
</script>