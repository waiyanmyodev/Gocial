<template>
    <div>
        <v-card class="my-2">
            <v-card-title>
                <div class="row">
                    <!-- User Image  -->
                    <div class="col-2 col-md-1 mr-lg-3 mr-sm-4">
                        <v-avatar color="grey darken-3">
                            <v-img
                                class="elevation-6 "
                                alt=""
                                :src="UserData.image"
                            ></v-img>
                        </v-avatar>
                    </div>
                    <!--  User Name  -->
                    <div class="col-8 d-flex flex-column">
                        <div>
                            
                            <router-link :to='profile' class='name black--text' >
                                {{ UserData.name  }}
                            </router-link>
                        </div>
                        <!-- Date Time  -->
                        <div>
                            <b class='text-muted font-weight-regular subtitle-1'>
                                {{date.years }} {{ date.months }}  {{ date.days }}
                            </b>
                        </div>
                    </div>

                </div>

                    <v-spacer></v-spacer>
            </v-card-title>

            <!-- Comment Content  -->
            <v-card-text>
                {{ comment.content }}
            </v-card-text>
        </v-card>
    </div>
</template>
<script>
export default {
    props:['comment'],
    data(){
        return { 
            // Date Time Of Comment 
            date:{
					days:null,
					months:null,
					years:null,
				},
            // Data Of Commenter
            UserData:{
                name:null,
                image:null
            },
            profile:'/profile/user/'+this.comment.user_id
        }
    },
    methods:{
        // Get Date Data From Comment 
        DatePicker(){
            const months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
            const d = new Date(this.comment.created_at);
            this.date.months = months[d.getMonth()];
            this.date.days = d.getDate();
            this.date.years = d.getFullYear();
        },
        // Get User Data
        GetUserData(){
            axios.post(`/api/comment/user/${this.comment.user_id}`).then((res) => {
                this.UserData.name = res.data.name;
                this.UserData.image = "/ProfilePhato/"+res.data.profile_phato;
            })
        }
    },
    mounted(){
        this.DatePicker();
        this.GetUserData();
    }
}
</script>



<style>
	.name {
		text-decoration: none;
		color: black;
	}
</style>