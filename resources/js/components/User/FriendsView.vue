<template>
    <div>
        <v-list-item @click="DialogOpen()">
            <v-list-item-content>
            <v-list-item-title> 
                <b>Friends</b>
                
            </v-list-item-title>
            </v-list-item-content>
            <v-list-item-icon>
            <v-icon>el-icon-user-solid</v-icon>
            </v-list-item-icon>
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
                    Friends
                    <v-spacer></v-spacer>
                    <v-btn  icon color="black" @click="dialog=!dialog">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>

                <v-card-text>
                    <v-list subheader outlined>
                        <v-list-item v-for="friend in friends" :key="friend.id">
                            <v-list-item-avatar>
                                <v-img :src="`/ProfilePhato/`+friend.profile_phato" :alt="friend.name">
                                    
                                </v-img>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>
                                    {{ friend.name }}
                                </v-list-item-title>
                            </v-list-item-content>
                            <v-list-item-icon>
                                <v-icon>mdi-account</v-icon>
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
    data(){
        return {
            dialog:false,
            friends_id:[],
            user_id:this.$route.params.id,
            profile_phato:'',
            friends:[]
        }
    } ,
    methods:{
        DialogOpen(){
            this.dialog = !this.dialog;
            this.GetFriends();
        },
        // Getting All Friends
        GetFriends(){
            const data = {
                user_id:this.$route.params.id
            };
            axios.post(`/api/friend/all-friends`,data).then((res) => {
                var user_id = this.user_id;
                var friends_id = [];
                res.data.forEach(function(item,index){
                    if(user_id == item.sender_id){
                        friends_id.push(item.recipient_id)
                    }

                    if(user_id == item.recipient_id){
                        friends_id.push(item.sender_id)
                    }

                });
                this.friends_id = friends_id;
                var friends = [];
                friends_id.forEach(function(item,index){
                    
                    axios.post(`/api/profile/${item}`).then((res) => {
                        friends.push(res.data);
                    })
                })
                this.friends = friends;
            })
        },
        ImageGetter(id){
			axios.post(`/api/profile/${id}`).then((res) => {
                this.profile_phato = `/ProfilePhato/`+res.data.profile_phato;
            })
            return this.profile_phato;
        }
    },
    mounted(){
    }
};
</script>
