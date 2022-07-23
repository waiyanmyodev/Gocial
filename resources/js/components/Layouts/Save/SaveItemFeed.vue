<template>
    <v-card flat>
        <v-card-title>
            <div>
                <h3 class="headline mb-0">
                    Save Items 
                    <v-icon>mdi-book</v-icon>
                </h3>
            </div>

        </v-card-title>
        <v-card-text>
            <div>
                <h4>Posts</h4>
                <Post :post="post" v-for='(post,id) in posts' :key='id'/>
            </div>
            <v-divider></v-divider>

            <div>
                <h4>Users</h4>
                <v-card class="col rounded-lg" v-for="user in users" :key="user.id" >
                    <v-card-title @click="$router.push(`/profile/user/${user.id}`)">
                        <v-avatar color="grey darken-3">
                            <v-img
                                class="elevation-6 "
                                alt=""
                                :src="`/ProfilePhato/`+user.profile_phato"
                            ></v-img>
                        </v-avatar>
                        <b>{{ " " +  user.name }}</b>
                    </v-card-title>
                </v-card>
            </div>
        </v-card-text>
    </v-card>
</template>

<script>
import Post from '../NewFeed/Post';
export default {
    data(){
        return {
            token:localStorage.getItem('token'),
            user:[],
            user_id:localStorage.getItem('user_id'),
            posts:[],
            users:[]
        }
    },
    methods:{
        Posts(){
            axios.post(`/api/post/save/${this.user_id}`).then((res) => {
                this.posts = res.data;
            })
        },
        Users(){
            axios.post(`/api/user/saves/${this.user_id}`).then((res) => {
                var raw_data = res.data;
                var users_id = [];
                var users  = [];
                var user_id = this.user_id;
                raw_data.forEach(function(item,index){
                    users_id.push(item.id);
                });

                users_id.forEach(function(item,index){
                    
                    axios.post(`/api/profile/${item}`).then((res) => {
                        var user = res.data;
                        var data = {
                            friend_id:item,
                            user_id:user_id
                        }
                        axios.post(`/api/friend/matual-fri`,data).then((res) => {
                            user.mutual_fri = res.data;
                            users.push(user);
                        })
                        
                    })
                })
                this.users = users;
            })
        }
    },
    created(){
        this.Posts();
        this.Users()
    },
    mounted(){
        if(this.token != null){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            axios.post(`/api/user`).then((response) => {
                this.user =  response.data;
            });
        }
        
    },
    components:{Post}
}
</script>