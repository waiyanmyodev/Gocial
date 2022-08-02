<template>
    <v-dialog v-model="messenger" fullscreen transition="dialog-bottom-transition" :overlay="false">
        <v-card>
            <v-card-title> 
                Gocial Chat  
                <v-spacer></v-spacer>
                <v-btn fab icon @click="messenger = false || $router.push(`/`)">
                  <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>

            <v-card-text>
              <v-row class="no-gutters elevation-4">
                <v-col
                  cols="12" sm="3"
                  class="flex-grow-1 flex-shrink-0"
                  style="border-right: 1px solid #0000001f;"
                >
                  <v-responsive
                    class="overflow-y-auto fill-height d-none d-sm-flex"
                    height="500"
                  >
                    <v-list subheader>
                      <v-list-item-group v-model="activeChat">
                        <div v-for="(friend, index) in friends " :key="friend.created_at">
                        <template >
                          <v-list-item
                             @click="GetMessage(friend)"
                            :key="`parent${index}`"
                            :value="friend.id"
                          >
                              <v-badge
                                bordered
                                bottom
                                :color="(ActiveUsers.find(ActiveUser=>ActiveUser.id==friend.id)?'green accent-4':'red accent-4')"
                                dot
                                offset-x="10"
                                offset-y="10"
                              >
                                <v-avatar
                                  size="40"
                                  color="cyan"
                                >
                                  <img :src="`/ProfilePhato/`+`${friend.profile_phato}`" alt="alt">
                                </v-avatar>
                              </v-badge>
                              
                            <v-list-item-content class="mx-2"> 
                              <v-list-item-title >
                                {{  friend.name  }} 
                              </v-list-item-title>
                              <v-list-item-subtitle v-if="friend.message" >
                                {{ friend.message.data }}
                              </v-list-item-subtitle>
                            </v-list-item-content>
                            <v-list-item-icon>
                              <v-icon :color="friend ? 'deep-purple accent-4' : 'grey'">
                                chat_bubble
                              </v-icon>
                            </v-list-item-icon>
                          </v-list-item>
                          <v-divider
                            :key="`chatDivider${index}`"
                            class="my-0"
                          />
                        </template>
                        </div>
                      </v-list-item-group>
                    </v-list>
                  </v-responsive>
                </v-col>
                <v-col
                  cols="auto"
                  class="flex-grow-1 flex-shrink-0"
                >
                  <v-responsive
                    v-if="activeChat"
                    class="overflow-y-hidden fill-height"
                    height="500"
                  >
                    <v-card
                      flat
                      class="d-flex flex-column fill-height"
                    >
                      <v-card-title>
                        <div @click="$router.push(`/profile/user/${selectedFri.id}`)">
                          <v-avatar
                          class="ml-2 "
                            size="40"
                          >
                            <img :src="`/ProfilePhato/`+selectedFri.profile_phato" alt="alt">
                          </v-avatar>
                          {{ selectedFri.name }}
                        </div>
                      </v-card-title>
                      <v-card-text class="flex-grow-1 overflow-y-auto" v-chat-scroll>
                        <!--   -->
                        <div v-for="message in messages" :key="message.name">
                        <template>
                          <div
                            :class="{ 'd-flex flex-row-reverse': message.sender_id == user.id }"
                          >
                            <v-menu offset-y>
                              <template v-slot:activator="{ on }">
                                <v-hover
                                  v-slot:default="{ hover }"
                                >
                                  <v-chip
                                    :color="message.sender_id == user.id  ? 'primary' : ''"
                                    dark
                                    style="height:auto;white-space: normal;"
                                    class="pa-4 mb-2"
                                    v-on="on"
                                  >
                                    {{ message.data }}
                                    <!-- <sub
                                      class="ml-2"
                                      style="font-size: 0.5rem;"
                                    >{{ message.created_at }}</sub> -->
                                    <v-icon
                                      v-if="hover"
                                      small
                                    >
                                      expand_more
                                    </v-icon>
                                  </v-chip>
                                </v-hover>
                              </template>
                              <v-list>
                                <v-list-item>
                                  <v-list-item-title>delete</v-list-item-title>
                                </v-list-item>
                              </v-list>
                            </v-menu>
                          </div>
                        </template>

                        
                        </div>
                        <div v-if="typing.status == true">
                          <v-chip
                            v-if="selectedFri.id == typing.user.id "
                              dark
                              style="height:auto;white-space: normal;"
                              class="pa-4 mb-2"
                            >
                                {{ selectedFri.name }}
                                 is typing....
                          </v-chip>
                        </div>
                      </v-card-text>
                      <v-card-text class="flex-shrink-1">
                          <v-text-field
                          v-model="message"
                          label="Type a message"
                          type="text"
                          no-details
                          outlined
                          append-outer-icon="send"
                          @keyup.enter="SendMessage(activeChat)"
                          @click:append-outer="SendMessage(activeChat)"
                          hide-details
                        />
                      </v-card-text>
                    </v-card>
                  </v-responsive>
                </v-col>
              </v-row>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>


<script>

export default {
    components: {
    },
    data(){
        return {
            token:localStorage.getItem('token'),
            user:[],
            typing:{status:false},
            messenger:true,
            message:null,
            activeChat:null,
            messages:[],
            friends:[],
            selectedFri:{},
            ActiveUsers:[]
        }
    },
    watch:{
      message(){
        Echo.private('chat')
        .whisper('typing', {
           status:true,
            message:this.message,
            user:this.user
        });
      }
    },
    methods:{

      GetMessage(user){
        this.selectedFri = user;
        axios.post(`/api/messenger/get`,{receiver_id:user.id}).then((res) => {
          this.messages = res.data;
        })
      },
      SendMessage(id){
        var data = {
          sender_id:localStorage.getItem('user_id'),
          receiver_id:id,
          data:this.message,
          type:'text'
        }
        axios.post(`/api/messenger/send`,data)
        .then(res => {
          if(res.data == true) {
            this.messages.push(data)
             this.message = null;
          }
        })
      }
    },
    mounted(){
        if(this.token != null){
          window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;

          axios.post(`/api/user`).then((response) => {
            this.user =  response.data;

            localStorage.setItem('user_email',this.user.email)
            localStorage.setItem('user_name',this.user.name);
            localStorage.setItem('user_profile_phato',this.user.profile_phato);
            localStorage.setItem('user_id',response.data.id)
          });
          axios.post(`/api/messenger/friends`)
          .then(res => {
            var friends = res.data;
            var friends = friends.sort(function(a,b) {
						 return new Date(b.created_at).getTime() - new Date(a.created_at).getTime();
					  })	
            this.friends = friends
          })
          .catch(err => {
            console.error(err); 
          })

          Echo.private('chat').listen('MessageEvent',(e) => {
            this.messages.push(e.message)
          })
          .listenForWhisper('typing', (e) => {
                if(e.message != ''){
                  this.typing = e;
                }else {
                  this.typing.status = false;
                }
          });
          Echo.join(`chat`)
            .here((users) => {
               this.ActiveUsers = users;
            })
            .joining((user) => {
               this.ActiveUsers.push(user);
            })
            .leaving((user) => {
                this.ActiveUsers.splice(this.ActiveUsers.indexOf(user))
            })
            .error((error) => {
                
            });
      }else {
        this.$router.push(`/`)
      }
    }
}
</script>
