<template>
	<div class="px-2  my-2 ">
	<div class="card ">
		<div class="card-header">Comments </div>
		<div class="card-body">
			<!-- Looping The Comments -->
			 <Comment :comment="comment" v-for="(comment,id) in comments" :key="id" />
		</div>
	</div>
	</div>
</template>
<script type="text/javascript">
import Comment from './Comment';
	export default {
		props:['post','comments','user'],
		data(){
			return {
			}
		},
		methods:{
			
		},
		mounted(){
			
		},
		components:{Comment}
	};
</script>