I<template>
	<div>
		<v-list-item @click="dialog = true">
			<v-list-item-content >
				<v-list-item-title>
					<b >Add More </b>
				</v-list-item-title>
			</v-list-item-content>
			<v-list-item-icon>
				<v-icon>mdi-more</v-icon>
			</v-list-item-icon>
		</v-list-item>
		
		<v-dialog v-model="dialog" max-width="1000" min-height="600" >
			<v-card>
        <v-card-title>Profile Details </v-card-title>
        <v-divider></v-divider>
        <v-card-text>
        	<div class="container">
        		<div class="row d-flex justify-content-center">
        			<div class="col-4">Relationship Status 
        				<span><v-icon>mdi-heart</v-icon></span>  
        			</div>
        			<div class="col-4"></div>
        			<div class="col-4">
        				<span v-if="details.relationship_status != 'none'">
							{{ details.relationship_status  }}
						</span> 
        				<span>
	        				<v-btn
	        				@click="OpenEditDialog('Relationship','relationship_status','mdi-heart')"
						      tile
						      color="white"
						    >
						      <v-icon left>
						        mdi-pencil
						      </v-icon>
						      Edit
						    </v-btn>
        				</span>
        			</div>
        		</div>
				<v-divider></v-divider>

        		<div class="row d-flex justify-content-center">
        			<div class="col-4"> Work 
        				<span><v-icon>el-icon-suitcase</v-icon></span>  
        			</div>
        			<div class="col-4"></div>
        			<div class="col-4">
						<span v-if="details.work != 'none'">
							{{ details.work  }}
						</span> 
        				<span>
	        				<v-btn
						      tile
						      @click="OpenEditDialog('Work','work','el-icon-suitcase')"
						      color="white"
						    >
						      <v-icon left>
						        mdi-pencil
						      </v-icon>
						      Edit
						    </v-btn>
        				</span>
        			</div>
        		</div>
				<v-divider></v-divider>
        		
        		<div class="row d-flex justify-content-center">
        			<div class="col-4"> Phone 
        				<span><v-icon>el-icon-phone</v-icon></span>  
        			</div>
        			<div class="col-4"></div>
        			<div class="col-4">
        				<span v-if="details.phone_number != 'none'">
        					{{ details.phone_number  }} 
        				</span>
        				<span>
	        				<v-btn
						      tile
						      @click="OpenEditDialog('PHone Number','phone_number','el-icon-phone')"
						      color="white"
						    >
						      <v-icon left>
						        mdi-pencil
						      </v-icon>
						      Edit
						    </v-btn>
        				</span>
        			</div>
        		</div>
				<v-divider></v-divider>
        		
        		<div class="row d-flex justify-content-center">
        			<div class="col-4"> Nickname 
        				<span><v-icon>el-icon-s-custom</v-icon></span>  
        			</div>
        			<div class="col-4"></div>
        			<div class="col-4">
        				<span v-if="details.nickname != 'none'">
        					{{ details.nickname}}
        				</span>
        				<span>
	        				<v-btn
						      tile
						      @click="OpenEditDialog('Nickname','nickname','el-icon-s-custom')"
						      color="white"
						    >
						      <v-icon left>
						        mdi-pencil
						      </v-icon>
						      Edit
						    </v-btn>
        				</span>
        			</div>
        		</div>
				<v-divider></v-divider>
        		
        		<div class="row d-flex justify-content-center">
        			<div class="col-4"> Link 
        				<span><v-icon>el-icon-link</v-icon></span>  
        			</div>
        			<div class="col-4"></div>
        			<div class="col-4">
        				<span v-if="details.links != 'none'">
        					{{ details.links  }} 
        				</span>
        				<span>
	        				<v-btn
						      tile
						      @click="OpenEditDialog('Link','links','el-icon-link')"
						      color="white"
						    >
						      <v-icon left>
						        mdi-pencil
						      </v-icon>
						      Edit
						    </v-btn>
        				</span>
        			</div>
        		</div>

				<v-divider></v-divider>
        		

        		<div class="row d-flex justify-content-center">
        			<div class="col-4">Website  
        				<span><v-icon>mdi-earth</v-icon></span>  
        			</div>
        			<div class="col-4"></div>
        			<div class="col-4">
        				<span v-if="details.website != 'none'">
        					{{ details.website  }} 
        				</span>
        				<span>
	        				<v-btn
						      tile
						      @click="OpenEditDialog('Website','website','mdi-earth')"
						      color="white"
						    >
						      <v-icon left>
						        mdi-pencil
						      </v-icon>
						      Edit
						    </v-btn>
        				</span>
        			</div>
        		</div>

        	</div>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-btn
            color="blue darken-1"
            text
            @click="dialog = false"
          >
            Close
          </v-btn>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="dialog = false"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
		</v-dialog>

		<!-- Edit Dialog  -->
		<v-dialog v-model="edit_dialog" max-width='400' max-height='450'>
			<v-card>
				<!-- Card Title  -->
				<v-card-title>{{ edit.title }} Edit Page </v-card-title>
				<v-divider></v-divider>
				<!-- Card Text  -->
				<v-card-text>
					<!-- If RSS -->
					<div v-if="edit.action == 'relationship_status'">
						<v-select
				    	v-model="edit.value"
				        :items="relationship_status"
				        :menu-props="{ top: true, offsetY: true }"
				        label="Relationship Status"
				        :prepend-icon='edit.icon'
				      	></v-select>
					</div>
					<!-- If Not RSS -->
					<div v-if="edit.action != 'relationship_status'">
						<v-text-field
				    		v-model="edit.value"
				      		type="text"
				      		:label="edit.action"
				      		:rules="form_rule"
				      		hide-details="auto"
				      		:prepend-icon='edit.icon'
				      		clearable
				    	></v-text-field>
			    	</div>
				</v-card-text>
				<v-divider></v-divider>
				<!--  Card Action  -->
				<v-card-actions>
					<v-btn color='blue darken-1' text @click="CloseEditDialog">Cancel </v-btn>
					<v-spacer></v-spacer>
					<v-btn color='blue darken-1' text @click="SaveEditData">save </v-btn>
				</v-card-actions>
			</v-card>
		</v-dialog>
	</div>
</template>

<script type="text/javascript">
	export default {
		props:['details'],
		data(){
			return {
				dialog:false,
				token:localStorage.getItem('token'),
				user:localStorage.getItem('user'),
				edit:{
					title:'',
					value:'',
					action:'',
					icon:'',
					edit_status:''
				},
				edit_dialog:false,
				form_rule: [
        			value => !!value || 'Required.',
        			value => (value && value.length >= 6) || 'Min 6 characters',
      			],
      			relationship_status:[
      				'Single',
      				'In a relationship',
      				'Married',
      				'In a civil union',
      				'In a domestic partnership',
      				'In a open relationship',
      				'it`s complicated',
      				'Separated',
      				'Divorced',
      				'Widowrd',
      				'Engaged',
      			],
			}
		},
		methods:{
			OpenEditDialog(title,action,icon){
				this.edit_dialog = true;
				this.edit.title = title;
				this.edit.action = action;
				this.edit.icon = icon;
			},
			CloseEditDialog(){
				this.edit_dialog = false;
				this.edit.value = null;
				this.edit.title = null;
				this.edit.action = null;
				this.edit.icon = null;
			},
			SaveEditData(){
				// close the dialog and clean cache data 
				this.edit_dialog = false;
				this.edit.title = null;
				this.edit.icon = null;
				// send Axios Requests 
				var form =  {
					id:this.details.id,
					action: this.edit.action,
					value: this.edit.value
				};
				var request = axios.post('api/details/edit',form);
				var request_response = request.then((response) => {
					this.edit.edit_status = response.data;
					console.log(response.data)
					if(response.data == "ok"){
						this.$emit('updateDetails','done')
						this.$message.success(this.edit.action+" edit successfully!")
					}
				});
				// clean the value and action 
				this.edit.value = null;
				
			}
		},
		mounted(){
		},
		created(){

		}
	};
</script>