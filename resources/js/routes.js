import Test from './components/Test';
import Profile from './components/User/Profile';
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
		}
	]
}