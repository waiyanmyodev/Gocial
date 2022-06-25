<template>
	<div class="px-2 ">
		<v-text-field
        label="Something Write Here..."
        solo
        v-model='content'
    >
    	<v-icon
    	fab
    	@click="Submit"
      	slot="append"
      	color="blue"
    	>
      		mdi-send
    	</v-icon>

    </v-text-field>

	</div>
</template>
<script type="text/javascript">
	export default {
		props:['post_id'],
		data(){
			return {
				content:null,
				user:null
			}
		},
		methods:{
			Submit(){
				var form = {
					post_id:this.post_id,
					user_id:this.user.id,
					content:this.content
				};
				axios.post('/api/comment/create',form).then((res) => {
					if(res.data == 1){
						this.content = null;
					}
				});


			}
		},
		mounted(){
			axios.post('/api/user').then((res) => {
				this.user = res.data;
			})
		}
	};
</script>