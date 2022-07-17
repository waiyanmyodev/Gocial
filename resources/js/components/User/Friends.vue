<template>
  <v-card>
    <v-toolbar
      flat
    >
      <v-toolbar-title>User Profile</v-toolbar-title>
    </v-toolbar>
    <v-tabs vertical>
      <v-tab>
        <v-icon left>
          mdi-account
        </v-icon>
        Friends
      </v-tab>
      <v-tab>
          <v-badge
          v-if="counts.requests_count != 0"
          color="red"
          :content="counts.requests_count"
        >
           <v-icon left>
            mdi-account-arrow-left
            </v-icon>
            Requests
        </v-badge>
        <div v-if="counts.requests_count == 0">
            <v-icon left>
                mdi-account-arrow-left
            </v-icon>
                Requests
        </div>
      </v-tab>
      <v-tab>
         <v-badge
          v-if="counts.pending_count != 0"
          color="red"
          :content="counts.pending_count"
        >
           <v-icon left>
            mdi-account-arrow-right
            </v-icon>
            Pending
        </v-badge>
        <div v-if="counts.pending_count == 0">
            <v-icon left>
                mdi-account-arrow-right
            </v-icon>
                Pending
        </div>

      </v-tab>
     <!-- Friends  -->
      <v-tab-item>
        <v-card>
                <v-card-title >
                    {{ counts.friends_count }} Friends
                </v-card-title>

                <v-card-text>
                    <v-list subheader outlined>
                        <v-list-item v-for="friend in friends" :key="friend.id">
                            <v-list-item-avatar>
                                <v-img :src="`/ProfilePhato/`+friend.profile_phato" :alt="friend.name">
                                    
                                </v-img>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title @click="$router.push(`/profile/user/${friend.id}`)">
                                    <b>{{ friend.name }}</b>  
                                </v-list-item-title>
                                <v-list-item-subtitle v-if="friend.mutual_fri != 0 " >{{ friend.mutual_fri + " mutual friends."}}</v-list-item-subtitle>
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
      </v-tab-item>
      <!-- Request -->
      <v-tab-item>
        <v-card flat>
          <v-card-text>
            <v-card>
                <v-card-title >
                   {{ counts.requests_count }} Requests
                </v-card-title>

                <v-card-text>
                    <v-list subheader outlined>
                        <v-list-item v-for="request in requests" :key="request.id">
                            <v-list-item-avatar>
                                <v-img :src="`/ProfilePhato/`+request.profile_phato" :alt="request.name">
                                    
                                </v-img>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title @click="$router.push(`/profile/user/${request.id}`)">
                                    <b>{{ request.name }}</b> 
                                </v-list-item-title>
                                <v-list-item-subtitle v-if="request.mutual_fri != 0 " >{{ request.mutual_fri + " mutual friends."}}</v-list-item-subtitle>
                            </v-list-item-content>
                            <v-list-item-content class="row col">
                                <el-button type="white" class="col-5 " @click="Unfriend(request.id)">Cancel</el-button>
                                <el-button type="primary" color='white--text' class="col-5 mx-1" @click="FriConfirm(request.id)">Confirm</el-button>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card-text>

                <v-card-actions>
                </v-card-actions>
            </v-card>
          </v-card-text>
        </v-card>
      </v-tab-item>
      <!-- Pending request  -->
      <v-tab-item>
        <v-card flat>
          <v-card-text>
            <v-card>
                <v-card-title >
                    Pending Requests
                </v-card-title>

                <v-card-text>
                    <v-list subheader outlined>
                        <v-list-item v-for="pending in pendings" :key="pending.id">
                            <v-list-item-avatar>
                                <v-img :src="`/ProfilePhato/`+pending.profile_phato" :alt="pending.name">
                                    
                                </v-img>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title @click="$router.push(`/profile/user/${pending.id}`)">
                                    <b>{{ pending.name }}</b> 
                                </v-list-item-title>
                                <v-list-item-subtitle v-if="pending.mutual_fri != 0 " >{{ pending.mutual_fri + " mutual friends."}}</v-list-item-subtitle>
                            </v-list-item-content>
                            <v-list-item-content class="row col">
                                <el-button type="danger" class="col " @click="Unfriend(pending.id)">Cancel</el-button>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card-text>

                <v-card-actions>
                </v-card-actions>
            </v-card>
          </v-card-text>
        </v-card>
      </v-tab-item>
    </v-tabs>
  </v-card>
</template>



<script>

export default {
    data(){
        return {
            friends_id:[],
            profile_phato:'',
            friends:[],
            fri_reqs:[],
            requests:[],
            pendings:[],
            user_id:localStorage.getItem('user_id'),
            counts:[]
        }
    } ,
    methods:{

        // Getting All Friends
        GetFriends(){
            const data = {
                user_id:this.user_id
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
                var user_id = this.user_id;
                friends_id.forEach(function(item,index){
                    
                    axios.post(`/api/profile/${item}`).then((res) => {
                        var user = res.data;
                        var data = {
                            friend_id:item,
                            user_id:user_id
                        }
                        axios.post(`/api/friend/matual-fri`,data).then((res) => {
                            user.mutual_fri = res.data;
                            friends.push(user);
                        })
                        
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
        },
        getFriendRequests(){
            const data  = {
                user_id: this.user_id
            }
            axios.post(`/api/friend/get-fri-req`,data).then((res) => {
                var requests_id = [];
                res.data.forEach(function(item,index){
                    requests_id.push(item.sender_id)
                });
                var requests = [];
                var user_id = this.user_id;
                requests_id.forEach(function(item,index){    
                    axios.post(`/api/profile/${item}`).then((res) => {
                        var user = res.data;
                        var data = {
                            friend_id:item,
                            user_id:user_id
                        }
                        axios.post(`/api/friend/matual-fri`,data).then((res) => {
                            user.mutual_fri = res.data;
                            requests.push(user);
                        })
                    })
                })
                this.requests = requests;
            })
        },
        GetFriendPending(){
            // data for axios request
            var data =  {
                user_id:this.user_id
            };
            // request to get pending friendships 
            axios.post(`/api/friend/get-fri-pending`,data).then((res) => { 
                // pending users id 
                var pending_id = [];
                res.data.forEach(function(item,index) {
                    // pushing to pending_id 
                    pending_id.push(item.recipient_id);
                });
                // temp pending object  
                var pendings = [];
                // looping pending_id list for getting user data
                var user_id = this.user_id;
                pending_id.forEach(function(item,index){    
                    axios.post(`/api/profile/${item}`).then((res) => {
                        var user = res.data;
                        var data = {
                            friend_id:item,
                            user_id:user_id
                        }
                        axios.post(`/api/friend/matual-fri`,data).then((res) => {
                            user.mutual_fri = res.data;
                            pendings.push(user);
                        })
                    })
                });
                this.pendings = pendings;
                
            })
        },
        // Unfriend User Function 
        Unfriend(fri_id){
            var data = {
                user_id:this.user_id,
                friend_id:fri_id
            }
            axios.post(`/api/friend/unfriend`,data).then((res) => {
                if(res.data == true){
                    this.GetFriends()
                    this.getFriendRequests()
                    this.GetFriendPending();
                    this.AListOf()
                }
            })
        },

        FriConfirm(fir_id){
            var data = {
                user_id:this.user_id,
                friend_id:fir_id
            }
            axios.post(`/api/friend/accept`,data).then((res) => {
                if(res.data == true){
                    this.GetFriends();
                    this.getFriendRequests();
                    this.AListOf()
                }
            })
        },
        // list of friends,pending users,request users
        AListOf(){
            axios.post(`/api/friend/get-friends-count`,{user_id:this.user_id})
            .then((res) => {
                this.counts = res.data;
            })
        }
    },
    mounted(){
        this.GetFriends();
        this.getFriendRequests();
        this.GetFriendPending();
        this.AListOf()
        
    },
    created(){
        
    }
};
</script>

