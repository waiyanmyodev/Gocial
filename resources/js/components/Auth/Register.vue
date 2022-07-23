<template>
	<div>
		<v-btn @click="dialog = true" text block>
		  Register
          <i class="el-icon-user-solid"></i>
        </v-btn>
        <v-dialog
        v-model="dialog"
        max-width="600px"
      >
        <v-card  class="">
          <v-card-title>
            <span>Register  </span>
   
          </v-card-title>
          

          <v-card-text  >
          <div class="header d-flex flex-column align-items-center justify-content-center">Profile Phato </div>
          <el-upload
			class="avatar-uploader  d-flex flex-column align-items-center justify-content-center"
            :action='`/api/image-uploader`'
            :before-upload="beforeUpload"
			:on-success="handleAvatarSuccess"
			>
			<img v-if="form.Image" :src="imageUrl" class="avatar">
			<i v-else class="el-icon-plus avatar-uploader-icon"></i>
  		  </el-upload>


          	<v-text-field
          		v-model='form.name'
      			label="Name"
      			:rules="rules"
      			hide-details="auto"
      			clearable
      			prepend-icon='el-icon-user-solid'
    		></v-text-field>

    	<v-menu
      			ref="menu"
      			v-model="menu"
      			:close-on-content-click="false"
      			transition="scale-transition"
      			offset-y
      			min-width="auto"
    		>
      	<template v-slot:activator="{ on, attrs }">
        	<v-text-field
          	v-model="form.birthday"
          	label="Birthday date"
          	prepend-icon="mdi-calendar"
          	readonly
          	v-bind="attrs"
          	v-on="on"
          	:rules='rules'
        	></v-text-field>
      	</template>
      		<v-date-picker
        		v-model="form.birthday"
        		:active-picker.sync="activePicker"
        		:max="(new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)"
        		min="1950-01-01"
      		></v-date-picker>
    	</v-menu>

    	<v-select
    	v-model="form.gender"
        :items="['male','female']"
        :menu-props="{ top: true, offsetY: true }"
        label="Gender"
        prepend-icon='el-icon-s-check'
      	></v-select>

      	<v-text-field
      		v-model="form.email"
      		type="email"
      		label="email"
      		:rules="email_rule"
      		hide-details="auto"
      		clearable
      		prepend-icon='mdi-email'
    	></v-text-field>

    	<v-text-field
    		v-model="form.password"
      		type="password"
      		label="password"
      		:rules="pass_rule"
      		hide-details="auto"
      		clearable
      		prepend-icon='mdi-lock'
    	></v-text-field>

          </v-card-text>
          <v-card-actions>
            <v-btn
              @click="dialog = false"
            >
              Close
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn
            dark
              @click="Submit"
            >
              Submit
            </v-btn>

          </v-card-actions>
        </v-card>
      </v-dialog>

	</div>
</template>
<script type="text/javascript">
	export default{
		data(){
			return {
				    // DATA IN COMPONENT
				    dialog:false,
				    rules: [
        			value => !!value || 'Required.',
        			value => (value && value.length >= 3) || 'Min 3 characters',
      			],
      			pass_rule: [
        			value => !!value || 'Required.',
        			value => (value && value.length >= 6) || 'Min 6 characters',
      			],
      			email_rule: [
        			value => !!value || 'Required.',
        			value => (value && value.length >= 8) || 'Min 8 characters',
      			],
      			date: null,
      			menu: false,
      			activePicker:null,
      			gender:'',
      			imageUrl:'',
      			form:{
      				Image:null,
      				name:'',
      				email:'',
      				gender:'',
      				birthday:'',
      				password:''
      			},
			}
		},
		// METHODS 
		methods:{
			// BEFORE UPLOAD IMAGE 
			beforeUpload(file) {
        	  const isLt2M = file.size / 1024 / 1024 < 2;
        	  if (!isLt2M) {
          		this.$message.error(' picture size can not exceed 2MB!');
        		}
        	  this.form.Image = file;
      		},
			 handleRemove(file, fileList) {
				console.log(file, fileList);
			},
			// Profile Image Success 
			handleAvatarSuccess(res, file) {
				this.imageUrl = URL.createObjectURL(file.raw);
			},
      		// REGISTER FROM SUBMIT FUNCTION 
      		Submit(){
          // create form data 
      		var form = new FormData();
      		form.append('name',this.form.name);
      		form.append('image',this.form.Image);
      		form.append('gender',this.form.gender);
      		form.append('birthday',this.form.birthday);
      		form.append('email',this.form.email);
      		form.append('password',this.form.password);
          this.from = form;
          // Register
          var auth = axios.post(`/api/register`,form);
          auth.then((response) => {
            if(response.data != 'fail'){
              // setting LocalStorage Item
                localStorage.setItem('token',response.data);
                this.token = localStorage.getItem('token');
                // Setting Axios Header
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                // Getting The User 
                axios.post('api/user').then((response) => {
                  this.user =  response.data;
                  // Setting LocalStorage Item
                  localStorage.setItem('user',response.data)
                  // Sending User Id For Details Row 
                  axios.post('api/detail-add', {
                    user_id: this.user.id,
                  });
                  this.$emit('logined','done');
				  this.$message.success('Register Success!');
				  this.$message.success('Login Success!');

                })
            }
          })
      		

      		}
		}
	};
</script>
<style>
  .avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 50%;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }
  .avatar-uploader .el-upload:hover {
    border-color: #409EFF;
  }
  .avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 178px;
    height: 178px;
    line-height: 178px;
    text-align: center;
  }
  .avatar {
    width: 178px;
    height: 178px;
    display: block;
  }
</style>