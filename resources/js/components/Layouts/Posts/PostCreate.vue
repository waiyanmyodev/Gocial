<template>
	<div>
		<!--  Post Create Button  -->
		<v-btn text color='cyan lighten-1' @click="dialog = true">
			Create Post <v-icon></v-icon>
		</v-btn>
		<!-- Post Create Dialog  -->
		<v-dialog v-model="dialog" min-height="1000" width='700'>
			<v-app>
			<v-card>
				<v-card-title class="text-info">
					Post Create 
				</v-card-title>
				<v-divider></v-divider>
				<v-card-text>
					<div class="row d-flex justify-content-center ">
						<div class="col-8">
							<span>
								<v-avatar size='70'>
						        	<img :src="profile_phato" />
						        </v-avatar>
					        </span>
					        <span>
					        	<b class=""> {{ user.name }}</b>
					        </span>
						</div>
						<div class="col-2"></div>
						<div class="col-2 bottom-right pull-right">
						  <v-menu transition="fab-transition" :close-on-content-click="CloseOnContentClick">			
						  	<template v-slot:activator="{ on ,attrs }">
								<v-btn fab v-bind="attrs" v-on="on">
									<v-icon>mdi-cog</v-icon>
								</v-btn>
							</template>	
							<v-list min-width='200'>
								<v-list-item>
									<v-list-item-title>
										Reach To
										<v-icon v-if="post.reach_to == 'public'">mdi-earth</v-icon>
										<v-icon v-if="post.reach_to == 'friends'">mdi-account-multiple</v-icon>
										<v-radio-group v-model="post.reach_to">
									      <v-radio
									        label="Public "
									        value="public"
									      >
									      	
									      </v-radio>

									      <v-radio
									        label="Friends"
									        value="friends"
									      ></v-radio>

									    </v-radio-group>
									</v-list-item-title>
								</v-list-item>

								<v-list-item>
									<v-list-item-title>
									 <v-menu>
									 	<template v-slot:activator="{ on,attrs}">
									 		<v-btn v-bind="attrs" v-on='on'>
									 			<span v-if="post.text_color == ''">
									 				Select text color 
									 			</span>
									 			<span v-if="post.text_color != ''">
									 				{{ post.text_color }}
									 			</span>
									 		</v-btn>
									 	</template>
									 	<v-list>
									 		<v-list-item>
									 			<v-list-item-title>
									 				<v-radio-group v-model="post.text_color">
									 					<v-radio 
									 					 value='cyan'
									 					 label='Cyan'
									 					></v-radio>

									 					<v-radio 
									 					 value='red'
									 					 label='Red'
									 					></v-radio>

									 					<v-radio 
									 					 value='blue lighten-1'
									 					 label='Blue'
									 					></v-radio>

									 					<v-radio 
									 					 value='light-blue'
									 					 label='Light-Blue'
									 					></v-radio>

									 					<v-radio 
									 					 value='green'
									 					 label='Green'
									 					></v-radio>

									 					<v-radio 
									 					 value='Pink'
									 					 label='Pink'
									 					></v-radio>
									 				</v-radio-group> 
									 			</v-list-item-title>
									 		</v-list-item>
									 	</v-list>
									 </v-menu>
									</v-list-item-title>
								</v-list-item>

								<v-list-item>
									<v-list-item-title>
										<v-menu>
											<template v-slot:activator="{ on,attrs}">
												<v-btn 
													v-bind='attrs' v-on="on">
													<span v-if="post.feeling != ''">
														{{ post.feeling }}
													</span> 

													<span v-if="post.feeling == ''">
														Feeling 😀
													</span>
												</v-btn>
											</template>
											<v-list>

												<v-list-item v-for="(feel,id) in feels" :key="id">
													<v-list-item-title>
														
													  
													  <el-radio 
													  	v-model="post.feeling"
													  	:label="feel.value" 
													      >
													      {{ feel.value }}
													  	</el-radio>			
													</v-list-item-title>
												</v-list-item>
											</v-list>
										</v-menu>
									</v-list-item-title>
								</v-list-item>

								<v-list-item>
									<v-list-item-title>
										<el-checkbox v-model="post.comment_open">Comment Open</el-checkbox> 
										<v-icon>el-icon-chat-square</v-icon>
									</v-list-item-title>
								</v-list-item>

								<v-list-item>
									<v-list-item-title>
										<el-checkbox v-model="post.share_open">Share Open</el-checkbox> 
										<v-icon>mdi-share</v-icon>
									</v-list-item-title>
								</v-list-item>



							</v-list>
						  </v-menu>
						</div>
					</div>

					<!--  body  -->
					<div class="d-flex flex-column my-2 ">
						<!-- Status textarea box  -->
							<v-textarea
							  clearable
						      clear-icon="mdi-close-circle"	  
						      class="btn-block col-12 "
					          solo
					          v-model='post.status'
					          label="Something write here..."
					 		  height="auto"
					        ></v-textarea>
						<!-- Image Box  -->
						<div class="col-12 justify-content-center">
						    <el-upload
					            action="http://127.0.0.1:8000/api/image-upload"
					            :before-upload="beforeUpload"
					  			list-type="picture-card"
					  			:limit='image_limit'
								>
								<v-icon>mdi-camera</v-icon>
					  		 </el-upload>
						</div>
					</div>
				</v-card-text>
				<v-divider></v-divider>
				<v-card-actions>
					<v-btn>Clear</v-btn>
					<v-spacer></v-spacer>
					<v-btn @click="SubmitPost">Post</v-btn>
				</v-card-actions>
			</v-card>
			</v-app>
		</v-dialog>
	</div>
	<!-- Trash  -->
	<!--  -->

</template>
<script type="text/javascript">
	export default {
		data(){
			return {
				dialog:false,
				image_limit:1,
				CloseOnContentClick:false,
				token:localStorage.getItem('token'),
				user:{},
				profile_phato:'',
				image_limit:1,
				post:{
					user_id:'',
					status:'',
					image:null,
					share_open:true,
					comment_open:true,
					reach_to:'public',
					text_color:'',
					feeling:''

				},
				reachTO:['public','friends'],
				feels:[
				{label:'happy',value:'Happy 🥰'},
				{label:'angry',value:'Angry 😡'},
				{label:'thinking',value:'Thinking 🤔'},
				{label:'funny',value:'Funny 🤣'},
				{label:'crazy',value:'Crazy 🤪'},
				{label:'cute',value:'Cute 😘'},
				{label:'love',value:'Love 😍'},
				{label:'party',value:'Party 🥳'},
				{label:'sad🥲',value:'Sad 🥲'},
				]
			}
		},
		methods:{
			// BEFORE UPLOAD IMAGE 
			beforeUpload(file) {
        	  const isLt2M = file.size / 1024 / 1024 < 2;
        	  if (!isLt2M) {
          		this.$message.error(' picture size can not exceed 2MB!');
        		}
        	  this.post.image = file;
      		},
      		SubmitPost(){
      			// Creating Post Form 
      			var form = new FormData();
      			form.append('user_id',this.user.id);
      			form.append('status',this.post.status);
      			form.append('image',this.post.image);
      			form.append('text_color',this.post.text_color);
      			form.append('feeling',this.post.feeling);
      			form.append('reach_to',this.post.reach_to);
      			form.append('comment_open',this.post.comment_open);
      			form.append('share_open',this.post.share_open);
      			var poster = axios.post('api/post/create',form);
      			poster.then((res) => {
      				console.log(res.data)
      			})


      		}
		},
		mounted(){
			axios.post('api/user').then((response) => {
			  // TODO
			  this.profile_phato = 'ProfilePhato/'+response.data.profile_phato;
			  this.user = response.data;

			});
			
		},
	};
</script>