<template>
	<div>
		<!--  Post Create Button  -->
		<v-btn text color='cyan lighten-1' @click="dialog = true">
			Create Post <v-icon></v-icon>
		</v-btn>
		<!-- Post Create Dialog  -->
		<v-dialog v-model="dialog" min-height="1000" width='700'>
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
							<span>
								
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
								<!--  Divider  -->
								<v-divider></v-divider>
								<v-list-item>
									<v-list-item-title>
									 <v-menu>
									 	<template v-slot:activator="{ on,attrs}">
									 		<v-btn block v-bind="attrs" v-on='on'>
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

								<!--  Divider  -->
								<v-divider></v-divider>

								<v-list-item>
									<v-list-item-title>
										<v-menu>
											<template v-slot:activator="{ on,attrs}">
												<v-btn 
													block
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

								<!--  Divider  -->
								<v-divider></v-divider>

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

								<v-divider></v-divider>

								<v-list-item align='center' justify='center'>
									<v-list-item-title class="text-center " >
										<el-upload
											:action='`/api/image-upload`'
											:before-upload="beforeUpload"
											:multiple="true"
											>
											<!-- <v-icon>mdi-plus</v-icon> -->
												<el-tooltip class="item" effect="light" content="Add Phato" placement="top-start">
													<v-btn block color="lighten-1" class="text-center">
														<v-icon>mdi-camera-enhance</v-icon>
													</v-btn>
												</el-tooltip>
										</el-upload>
									</v-list-item-title>
								</v-list-item>

								


							</v-list>
						  </v-menu>
						</div>
					</div>

					<!--  body  -->
						<!-- Status textarea box  -->
							<v-textarea
							  clearable
						      clear-icon="mdi-close-circle"	  
					          :rules="content_rule"
					          v-model='post.status'
					          label="Something write here..."
					 		  height="auto"
					        ></v-textarea>
						<!-- Image Box  -->
						    
							<v-carousel v-if="post.images != null">
								<v-carousel-item
								v-for="(item,i) in PostImagePre"
								:key="i"
								:src="item"
								>
								
								<v-row class="fill-height" align="center" justify="center">
									<el-upload
										class="d-flex align-item-center justify-content-center"
										action="http://127.0.0.1:8000/api/image-upload"
										:before-upload="beforeUpload"
										:multiple="true"
										:show-file-list="false"
										>
										<button class="glass-button btn btn-lg px-5 mx-5" > 
											<v-icon>mdi-plus</v-icon>
										</button>
									</el-upload>
								</v-row>
					
								</v-carousel-item>
							</v-carousel>
				</v-card-text>
				<v-card-actions>
					<v-btn @click="SubmitPost" block color="cyan--text lighten-1">Post</v-btn>
				</v-card-actions>
			</v-card>
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
				CloseOnContentClick:false,
				token:localStorage.getItem('token'),
				PostImagePre:[],
				user:{},
				profile_phato:'',
				post:{
					user_id:'',
					status:'',
					images:null,
					share_open:true,
					comment_open:true,
					reach_to:'public',
					text_color:'',
					feeling:''

				},
				content_rule: [
        			value => !!value || 'Required.',
        			value => (value && value.length >= 1) || 'Min 1 characters',
      			],
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
			  if(this.post.images != null){
				  
				  this.post.images.push(file)
			  }else {
				  this.post.images = [];
				  this.post.images.push(file)
			  }
			  var  reader = new FileReader
				reader.onload = e => {
					this.PostImagePre.push(e.target.result);
				}
				reader.readAsDataURL(file);
			  console.log(this.post.images)
      		},
      		SubmitPost(){
      			// Creating Post Form 
      			var form = new FormData();
      			form.append('user_id',this.user.id);
      			form.append('status',this.post.status);
      			form.append('text_color',this.post.text_color);
				  // Images appending to FormData
				  this.post.images.forEach((item,index) => {
					  form.append(`images[${index}]`,item);
				  })

      			form.append('feeling',this.post.feeling);
      			form.append('reach_to',this.post.reach_to);
      			form.append('comment_open',this.post.comment_open);
      			form.append('share_open',this.post.share_open);
      			var poster = axios.post('api/post/create',form);
      			poster.then((res) => {
      				if(res.data != 1){
						  this.$message.error('Something is wrong! Try Again');
					  }else {
						  this.$message.success('Post Created!');
						  this.dialog = false;
						  this.post = {
								user_id:'',
								status:'',
								images:null,
								share_open:true,
								comment_open:true,
								reach_to:'public',
								text_color:'',
								feeling:''

							}
					  }
      			})


      		}
		},
		mounted(){
			axios.post('api/user').then((response) => {
			  // TODO
			  this.profile_phato = `/ProfilePhato/`+response.data.profile_phato;
			  this.user = response.data;

			});
			
		},
	};
</script>


<style>
.glass-button {
   background: rgba(255,255,255,.10);
   box-shadow: 0 5px 5px rgba(0,0,0.2);
 }

</style>