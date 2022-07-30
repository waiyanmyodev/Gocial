<template>
    <div>
        <v-card class="my-2">
            <v-list subheader class="col">
                <v-list-item>
                    <v-list-item-avatar size="50">
                        <v-img :src="UserData.image">
                            
                        </v-img>
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title @click="$router.push(`/profile/user/${friend.id}`)">
                            <b  @click="$router.push({path:`/profile/user/${comment.user_id}`,replace:true})" class='name black--text' >
                                {{ UserData.name  }}
                            </b> 
                        </v-list-item-title>
                        <v-list-item-subtitle >
                            <b class='text-muted font-weight-regular subtitle-1'>
                                {{date.years }} {{ date.months }}  {{ date.days }}
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
                            <v-list two-line>
                                <v-list-item v-if="user_id == UserData.id" @click="comment_edit = true" >
                                            <v-btn text block>
                                            Edit <v-icon right>mdi-pencil</v-icon>
                                            </v-btn>
                                </v-list-item>
                                    
                                <!-- Save Button Function -->
                                <v-list-item v-if="save == false ">
                                        <v-btn block @click="SaveComment">
                                            Save Comment <v-icon>mdi-book-plus</v-icon>
                                        </v-btn>
                                </v-list-item>

                                <v-list-item v-if="save == true ">
                                        <v-btn block @click="UnSaveComment">
                                            UnSave Comment <v-icon>mdi-book-minus</v-icon>
                                        </v-btn>
                                </v-list-item>

                                <v-list-item  v-if="user_id == UserData.id" @click="comment_delete = true">
                                        <v-btn text block>
                                           Delete <v-icon right>mdi-delete</v-icon>
                                        </v-btn>
                                </v-list-item>

                                
                            </v-list>
                        </v-menu>
                    </v-list-item-icon>
                </v-list-item>
            </v-list>
            <v-dialog v-model="comment_edit" persistent max-width="500">
                <v-card>
                    <v-card-title class="headline">
                            Comment Edit <v-icon>mdi-pencil</v-icon>
                        <v-spacer></v-spacer>
                        <v-btn text icon @click="comment_edit = false">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                        <v-text-field
                            name="comment edit..."
                            label="Comment "
                            v-model="comment_edit_content"
                            :rules="comment_rule"
                        ></v-text-field>
                    </v-card-text>
                    <v-divider></v-divider>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="green lighten-2 "  text @click="CommentEdit">Save <v-icon>mdi-save</v-icon></v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-dialog v-model="comment_delete" persistent max-width="300">
                <v-card>
                    <v-card-title class="headline">
                            Comment Delete <v-icon>mdi-delete</v-icon>
                        <v-spacer></v-spacer>
                        <v-btn text icon @click="comment_delete = false">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                       <v-icon>mdi-alert-cicle</v-icon> Are you sure to delete this comment. if you delete the comment the comment is not can't recover.
                    </v-card-text>
                    <v-divider></v-divider>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="red lighten-2 "  text @click="comment_delete = false">Cancel <v-icon>mdi-close</v-icon></v-btn>
                        <v-btn color="red lighten-1 "  text @click="CommentDelete">Save <v-icon>mdi-alert-box</v-icon></v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>



            <!-- Comment Content  -->
            <v-card-text class="mr-5">
                {{ comment.content }}
            </v-card-text>
        </v-card>
    </div>
</template>
<script>
export default {
    props:['comment'],
    data(){
        return { 
            // Date Time Of Comment 
            more:false,
            comment_edit:false,
            comment_edit_content:this.comment.content,
            comment_delete:false,
            comment_rule: [
        			value => !!value || 'Required.',
        			value => (value && value.length >= 0) || 'Min 1 characters',
      			],
            user_id:localStorage.getItem('user_id'),
            date:{
					days:null,
					months:null,
					years:null,
				},
            // Data Of Commenter
            UserData:{
                id:null,
                name:null,
                image:null
            },
            profile:'/profile/user/'+this.comment.user_id,
            save:null
        }
    },
    methods:{
        // Get Date Data From Comment 
        DatePicker(){
            const months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
            const d = new Date(this.comment.created_at);
            this.date.months = months[d.getMonth()];
            this.date.days = d.getDate();
            this.date.years = d.getFullYear();
        },
        // Get User Data
        GetUserData(){
            axios.post(`/api/comment/user/${this.comment.user_id}`).then((res) => {
                this.UserData.name = res.data.name;
                this.UserData.id = res.data.id;
                this.UserData.image = "/ProfilePhato/"+res.data.profile_phato;
            })
        },
        CommentEdit(){
            var data = {
                id:this.comment.id,
                user_id:localStorage.getItem('user_id'),
                content:this.comment_edit_content
            }
            axios.post(`/api/comment/edit/${this.comment.id}`,data)
            .then(res => {
                if(res.data == true){
                    this.$message.success('Comment Edit Success!')
                }else {
                    this.$message.error('Request Failed!');
                }
            })
        },
        CommentDelete(){
            var data = {
                user_id:localStorage.getItem('user_id')
            }
            axios.post(`/api/comment/delete/${this.comment.id}`,data)
            .then(res => {
                if(res.data == true){
                    this.$message.success('Comment Deleted!')
                }else {
                    this.$message.error('Request Failed!')
                }
            })
            .catch(err => {
                console.error(err); 
            })
        },
        
        SaveComment(){
            var data = {
                save_category_id:this.comment.id,
                user_id:localStorage.getItem('user_id'),
                save_type:"Comment",
            }
            axios.post(`/api/comment/save/${this.comment.id}`,data)
            .then(res => {
                if(res.data == true){
                    this.$message.success('Comment Saved!')
                }else {
                    this.$message.error('Request Failed!')
                }
                this.IfSaveComment()
            })
        },
        UnSaveComment(){
				var data = {
					user_id:localStorage.getItem('user_id'),
					save_category_id:this.comment.id,
					save_type:"Comment"
				}
				axios.post(`/api/comment/unsave/${this.comment.id}`,data).then((res) => {
					if(res.data == true){
						this.$message.success('Post Unsaved!');
						
					}else {
                        this.$message.error('Request Failed!')
					}
					this.IfSaveComment()
				})
			},
        IfSaveComment(){
            var data = {
                user_id:localStorage.getItem('user_id'),
                save_category_id:this.comment.id,
                save_type:"Comment"
            }
            axios.post(`/api/comment/ifsave/${this.comment.id}`,data).then((res) => {
                this.save = res.data;
            })
        }

    },
    mounted(){
        this.DatePicker();
        this.GetUserData();
        this.IfSaveComment();
    }
}
</script>



<style>
	.name {
		text-decoration: none;
		color: black;
	}
</style>