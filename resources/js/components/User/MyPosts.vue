<template>
	<div>
		<div class="card px-2 py-2 ">
			
		</div>
	</div>
</template>
<script type="text/javascript">
	export default{
		props:['post'],
		data(){
			return {
				token:localStorage.getItem('token'),
				user:null
			}
		},
		methods:{

		},
		mounted(){
			// Getting User 
			axios.post('api/user').then((response) => {
			  // User Data
			  this.user = response.data;
			});
			console.log(this.post)
		}
	};
</script>