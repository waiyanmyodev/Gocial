<template>
   <div v-loading="loading" class="d-flex flex-column justify-content-center align-items-center "  >
       <v-card class="col-12 col-md-12 col-lg-9 d-flex  flex-column ">
           <v-card-title>
               <div>
                   <h3 >Gocial </h3>
               </div>
           </v-card-title>
           <v-card-actions>
               <v-btn block text @click="postcreate = true" >Create Post Here  <v-icon>mdi-newspaper-variant</v-icon>....</v-btn>
               <PostCreate :dialog="postcreate" @close="postcreate = false" /> 
           </v-card-actions>
       </v-card>
        <div v-if="show != false" class="col-12 col-md-12 col-lg-9"  >
            <Post :post="post"  v-for='(post,id) in posts' :key='id'   />
        </div>
        <div v-if="show == false" >
            <h2>No Content Available Now.</h2>
        </div>
   </div>
</template>


<script>
import Post from  './Post';
import PostCreate from  '../Posts/PostCreate';
export default {
    data(){
        return { 
            show:false,
            token:localStorage.getItem('token'),
            user:localStorage.getItem('user'),
            posts:[],
            loading:true,
            postcreate:false
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
                // Ready For Show 
                this.show = true;
                this.loading = false;

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
    components:{Post,PostCreate}
}
</script>