<template>
	<div>
		<v-btn @click="dialog = true">
			Login
            <i class="el-icon-d-arrow-right"></i>
		</v-btn>
		<v-dialog
		v-model='dialog'
		max-width="600px"
		>
			<v-card>
				<v-card-title>Login </v-card-title>
				<v-card-text>
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
					<v-btn @click='dialog = true'>Close</v-btn>
					<v-spacer></v-spacer>
					<v-btn class='bg-primary btn-lg' @click="Submit">Login</v-btn>
				</v-card-actions>
			</v-card>
		</v-dialog>
	</div>
</template>
<script type="text/javascript">
	export default {
		data(){
			return {
				dialog:false,
				form:{
					email:"",
					password:""
				},
				pass_rule: [
        			value => !!value || 'Required.',
        			value => (value && value.length >= 6) || 'Min 6 characters',
      			],
      			email_rule: [
        			value => !!value || 'Required.',
        			value => (value && value.length >= 8) || 'Min 8 characters',
      			]
			}
		},
		methods:{
			Submit(){
				axios.post(`/api/login`,this.form).then((response) => {
				  if(response.data != 'fail'){
				  	localStorage.setItem('token',response.data);
				  this.token = localStorage.getItem('token');
				  window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
				  this.dialog = false;
				  this.$emit('logined','done');
				  this.$message.success('Login Success!')
				}else {
					this.$message.error('Email Or Password Is Incorrect!')
				}
				});
			}
		}
	};
</script>