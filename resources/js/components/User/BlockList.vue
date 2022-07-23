<template>
    <div>
        <v-list-item @click="dialog = true">
            <v-list-item-content>
                <v-list-item-title>Blocking  <v-icon>mdi-account-cancel</v-icon></v-list-item-title>
                <v-list-item-subtitle>You make blocked users are here. <v-icon>mdi-account-cancel</v-icon> </v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>

        <v-dialog
            v-model="dialog"
            scrollable fullscreen 
            persistent :overlay="false"
            max-width="500px"
            transition="dialog-transition"
        >
            <v-card>
                <v-card-title >
                    Block List 
                    <v-spacer></v-spacer>
                    <v-btn  icon color="black" @click="dialog=!dialog">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>

                <v-card-text>
                    <v-list subheader outlined>
                        <v-list-item v-for="user in blocklist" :key="user.id">
                            <v-list-item-avatar>
                                <v-img :src="`/ProfilePhato/`+user.profile_phato" :alt="user.name">
                                    
                                </v-img>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>
                                    {{ user.name }}
                                </v-list-item-title>
                                <v-list-item-subtitle v-if="user.mutual_friends != 0 " >{{ user.mutual_friends + " mutual friends."}}</v-list-item-subtitle>
                            </v-list-item-content>
                            <v-list-item-icon>
                                 <el-button type="info" size="small" @click="UnBlock(user.id)" >Unblock  <v-icon>mdi-account-cancel</v-icon></el-button>
                            </v-list-item-icon>
                        </v-list-item>
                    </v-list>
                </v-card-text>

                <v-card-actions>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>

export default {
    props:['blocklist'],
    data(){
        return {
            dialog:false,
            friends_id:[],
            user_id:this.$route.params.id,
            profile_phato:'',
        }
    } ,
    methods:{
        DialogOpen(){
            this.dialog = !this.dialog;
        },
        ImageGetter(id){
			axios.post(`/api/profile/${id}`).then((res) => {
                this.profile_phato = `/ProfilePhato/`+res.data.profile_phato;
            })
            return this.profile_phato;
        },
        UnBlock(id){
            var data = {
                user_id:localStorage.getItem('user_id'),
                friend_id:id
            }
            axios.post(`/api/friend/unfriend`,data).then((res) => {
                if(res.data == true){
                    this.$message.info("Unblocked!");
                    this.BlockList;
                    
                }
            })
        },
        BlockList(){
            var data = {
            user_id:localStorage.getItem('user_id')
            }
            axios.post(`/api/friend/block-list/`,data).then((res) => {
            this.blocklist = res.data;
            })
        }
    },
    mounted(){
    }
};
</script>
