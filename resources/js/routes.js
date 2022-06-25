import Test from './components/Test';
import Profile from './components/User/Profile';
import ProfileView from './components/User/ProfileView';
export default {
	mode:'history',
	routes:[
		{
			path:'/',
			component:Test
		},
		{
			path:'/profile',
			component:Profile
		},
		{
			path:'/profile/user/:id',
			name:'profile',
			component:ProfileView
		}
	]
}