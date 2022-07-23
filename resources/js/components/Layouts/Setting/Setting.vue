<template>
    <v-card tile>
          <v-toolbar
            flat
            
            color="primary lighten-1"
          >
            <v-toolbar-title>Settings <v-icon>mdi-cog</v-icon></v-toolbar-title>

          </v-toolbar>
          <v-card-text>
        
            <v-list
              three-line
              subheader
            >
              <v-subheader>User Controls</v-subheader>
              <v-list-item @click="namec_dialog = true">
                <v-list-item-content>
                  <v-list-item-title>Name Your Change</v-list-item-title>
                  <v-list-item-subtitle>Change your gocial account name <v-icon>mdi-account</v-icon></v-list-item-subtitle>
                </v-list-item-content>
              </v-list-item>
              <!-- Name Change Dialog  -->
              <v-dialog
                v-model="namec_dialog"
                scrollable  
                persistent 
                max-width="500px"
                transition="dialog-transition"
              >
                <v-card>

                  <v-card-title>
                    <div>
                      <h3 class="headline mb-0">Change Your Name  </h3>
                    </div>
                    <v-spacer></v-spacer>
                    <v-btn  icon color="black" @click="namec_dialog = false">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                  </v-card-title>
                  <v-divider></v-divider>
                  <v-card-text>
                    <div>
                      You can change your name from here.
                    </div>
                    <v-text-field
                      v-model="nameChangeForm.name"
                      name="Name"
                      label="Name"
                      id="name"
                      :rules="rules"
                      clearable
                      prepend-icon="mdi-account"

                    ></v-text-field>

                    <div>
                      Type your account password to change your account name.
                    </div>
                    <v-text-field
                      v-model="nameChangeForm.password"
                      name="Password"
                      label="Password"
                      id="password"
                      clearable
                      :rules="rule2"
                      prepend-icon="mdi-lock"
                    ></v-text-field>
                  </v-card-text>
                  <v-divider></v-divider>
                  <v-card-actions>
                    <v-btn text color="green " @click="ChangeName">save</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
              
              <v-list-item @click="passc_dialog = true">
                <v-list-item-content>
                  <v-list-item-title>Password</v-list-item-title>
                  <v-list-item-subtitle>Change your gocial account password <v-icon>mdi-lock</v-icon> </v-list-item-subtitle>
                </v-list-item-content>
              </v-list-item>
                            <!-- Name Change Dialog  -->
              <v-dialog
                v-model="passc_dialog"
                scrollable  
                persistent 
                max-width="500px"
                transition="dialog-transition"
              >
                <v-card>

                  <v-card-title>
                    <div>
                      <h3 class="headline mb-0">Change Account Password  </h3>
                    </div>
                    <v-spacer></v-spacer>
                    <v-btn  icon color="black" @click="passc_dialog = false">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                  </v-card-title>
                  <v-divider></v-divider>
                  <v-card-text>
                    <div>
                      Type the current account password for change a new password.
                    </div>
                    <v-text-field
                    type="password"
                      v-model="passChangeForm.current_password"
                      name="current-password"
                      label="Current Password"
                      id="password"
                      :rules="rule2"
                      clearable
                      prepend-icon="mdi-lock"

                    ></v-text-field>

                    <div>
                      Type your account password to change your account name.
                    </div>
                    <v-text-field
                      type="password"
                      v-model="passChangeForm.new_password"
                      name="Password"
                      label="Password"
                      id="password"
                      clearable
                      :rules="rule2"
                      prepend-icon="mdi-lock"
                    ></v-text-field>

                    <div>
                      Confirm your new password 
                    </div>
                    <v-text-field
                      type="password"
                      v-model="passChangeForm.confirm_password"
                      name="Confirm_Password"
                      label="Confirm Password"
                      id="confirm-password"
                      clearable
                      
                      :rules="confirmPasswordRules"
                      prepend-icon="mdi-lock"
                    ></v-text-field>
                  </v-card-text>
                  <v-divider></v-divider>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text color="green " @click="ChangePassword">Change</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>

              <BlockList :blocklist="blocklist" /> 
            </v-list>
            <v-divider></v-divider>
          </v-card-text>

          <div style="flex: 1 1 auto;"></div>
        <v-btn text block color="red" @click="Logout">Singout <v-icon>mdi-account-arrow-right</v-icon></v-btn>
        </v-card>
</template>


<script>
import BlockList from '../../User/BlockList'
export default {
    data(){
        return {
          token:localStorage.getItem('token'),
          user:localStorage.getItem('user'),
          user_id:localStorage.getItem('user_id'),
          namec_dialog:false,
          blocklist:[],
          nameChangeForm:{
            id:localStorage.getItem('user_id'),
            email:localStorage.getItem('user_email'),
            name:'',
            password:''
          },
          passChangeForm:{
            current_password:'',
            new_password:'',
            confirm_password:''
          },
          rules: [
            value => !!value || 'Required.',
            value => (value || '').length <= 20 || 'Max 20 characters',
          ],
          rule2: [
            value => !!value || 'Required.',
            value => (value || '').length >= 6 || 'Max 6 characters',
          ],
          confirmPasswordRules: [
            (value) => !!value || 'Type confirm password',
            (value) =>
              value === this.passChangeForm.new_password || 'The password confirmation does not match.',
              value => (value || '').length >= 6 || 'Max 6 characters',
          ],
          passc_dialog:false,
        }
    },
    methods:{
      ChangeName(){
        var data = this.nameChangeForm;
        axios.post(`/api/user/name_update`,this.nameChangeForm).then((res) => {
          if(res.data == true){
            this.$message.success('Name Change Success!');
          }else {
             this.$message.error('Password is wrong!');
          }
        })
      },
      ChangePassword(){
        var data = this.passChangeForm;
        axios.post(`/api/user/password_update`,data).then((res) => {
          if(res.data == true){
            this.$message.success('Password changed!')
          }else {
            this.$message.error('Your password is wrong!')
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
      },
      Logout(){
          this.token = null;
          localStorage.removeItem('token');
          localStorage.removeItem('user');
          localStorage.removeItem('user_email');
          localStorage.removeItem('user_name');
          localStorage.removeItem('user_profile_phato');
          localStorage.removeItem('user_id');
          this.$router.push(`/`)
      },
    },
    created(){
      if(this.token != null){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            axios.post(`/api/user`).then((response) => {
              this.user =  response.data;
            });
            this.BlockList()
      }
    },
    components:{BlockList}
}
</script>