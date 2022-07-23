<template>
    <div v-if="show != false" >
            <Post :post="post"  v-for='(post,id) in posts' :key='id'   />
    </div>
</template>


<script>
import Post from  './Post';
export default {
    data(){
        return { 
            show:false,
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
                // Posts
                this.posts = res.data;
                // error in first index of array so we will delete to first index 
                // this.posts.shift();
                // Ready For Show 
                this.show = true;

            })
        },
        
    },
    mounted(){
        if(this.token != null){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            axios.post(`/api/user`).then((response) => {
              this.user =  response.data;
            });
        }
        this.PostGetter();
    },
    components:{Post}
}
</script>