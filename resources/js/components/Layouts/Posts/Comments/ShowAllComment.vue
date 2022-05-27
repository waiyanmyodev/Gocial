<template>
 <div class="col-4">	

	<div class="card">
		<div class="card-header">Comments </div>
		<div class="card-body">
		 {{ comments }}
		</div>
	</div>
 </div>
</template>
<script type="text/javascript">
	export default {
		props:['post','comments','user'],
		data(){
			return {
			}
		},
		methods:{
			
		},
		mounted(){
			
		}
	};
</script>