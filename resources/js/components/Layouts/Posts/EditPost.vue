<template>
	<div>
		<!-- Post Edit Dialog  -->
			<v-card>
				<v-card-title class="text-info">
					Post Edit 
                    <v-spacer></v-spacer>
                    <v-btn  icon color="black" @click="$emit('done',true)">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
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
						  <v-menu transition="fab-transition" :close-on-content-click="false">			
						  	<template v-slot:activator="{ on ,attrs }">
								<v-btn fab v-bind="attrs" v-on="on">
									<v-icon>mdi-cog</v-icon>
								</v-btn>
							</template>	
							<v-list min-width='200'>
								<v-list-item>
									<v-list-item-title>
										Reach To
										<v-icon v-if="original_post.reach_to == 'public'">mdi-earth</v-icon>
										<v-icon v-if="original_post.reach_to == 'friends'">mdi-account-multiple</v-icon>
										<v-radio-group v-model="original_post.reach_to">
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
									 			<span v-if="original_post.text_color == ''">
									 				Select text color 
									 			</span>
									 			<span v-if="original_post.text_color != ''">
									 				{{ original_post.text_color }}
									 			</span>
									 		</v-btn>
									 	</template>
									 	<v-list>
									 		<v-list-item>
									 			<v-list-item-title>
									 				<v-radio-group v-model="original_post.text_color">
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
													<span v-if="original_post.feeling != ''">
														{{ original_post.feeling }}
													</span> 

													<span v-if="original_post.feeling == ''">
														Feeling 😀
													</span>
												</v-btn>
											</template>
											<v-list>

												<v-list-item v-for="(feel,id) in feels" :key="id">
													<v-list-item-title>
														
													  
													  <el-radio 
													  	v-model="original_post.feeling"
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
										<el-checkbox v-model="original_post.comment_open">Comment Open</el-checkbox> 
										<v-icon>el-icon-chat-square</v-icon>
									</v-list-item-title>
								</v-list-item>

								<v-list-item>
									<v-list-item-title>
										<el-checkbox v-model="original_post.share_open">Share Open</el-checkbox> 
										<v-icon>mdi-share</v-icon>
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
					          v-model='original_post.content'
					          label="Something write here..."
					 		  height="auto"
					        ></v-textarea>
				</v-card-text>
				<v-card-actions>
					<v-btn @click="UpdatePost" block color="cyan--text lighten-1">Save</v-btn>
				</v-card-actions>
			</v-card>
	</div>
</template>
<script type="text/javascript">
	export default {
        props:['original_post'],
		data(){
			return {
				token:localStorage.getItem('token'),
				PostImagePre:[],
				user:{},
				profile_phato:'',
				content_rule: [
        			value => !!value || 'Required.',
        			value => (value && value.length >= 0) || 'Min 1 characters',
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
      		UpdatePost(){
      			// Creating Post Form 
      		    axios.post(`/api/post/update`,this.original_post).then((res) => {
                      if(res.data == true ){
                          this.$message.success("Post Updated!")
                      }else {
                          this.$message.error('Something is wrong!')
                      }
                      this.$emit('done',true)
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