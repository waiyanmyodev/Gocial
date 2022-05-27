<template>
	<div>	
	  <v-app>
	  <Navbar/>
	  
	  <div class="container">
		<div class="card">
			<div class="card-body">
				<router-view></router-view>
			</div>
		</div>
	  </div>
	</v-app>
	</div>
</template>
<script type="text/javascript">
import Navbar from './Layouts/Navbar';
	export default {
		data(){
			return {
				token:localStorage.getItem('token')
			}
		},
		methods:{

		},
		mounted(){
			
		},
		components:{Navbar}
	};
</script>