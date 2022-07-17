<template>
    <div>
        <v-card>
            <v-card-title primary-title>
                <div>
                    <h3 class="headline mb-0">New Feed</h3>
                    <div>Gocial</div>
                </div>
            </v-card-title>
        </v-card>

        <v-card>
            <Post :post="post" v-for='(post,id) in posts' :key='id'/>
            
        </v-card>

    </div>
</template>


<script>
import Post from  '../Posts/Post';
export default {
    data(){
        return { 
            token:localStorage.getItem('token'),
            user:localStorage.getItem('user'),
            posts:[]
        }
    },
    methods:{
        PostGetter(){
            var data = {
                user_id:localStorage.getItem('user_id')
            };
            axios.post(`/api/new-feed`,data).then((res) => {
                this.posts = res.data;
            })
        }
    },
    mounted(){
        if(this.token != null){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            axios.post(`/api/user`).then((response) => {
              this.user =  response.data;
              localStorage.setItem('user',response.data)
              localStorage.setItem('user_id',response.data.id)
            });
        }
        this.PostGetter();
    },
    components:{Post}
}
</script>