import Test from './components/Test';
import Profile from './components/User/Profile';
import ProfileView from './components/User/ProfileView';
import Friends from './components/User/Friends';
import NewFeed from './components/Layouts/NewFeed/NewFeed';
export default {
	mode:'history',
	routes:[
		{
			path:'/',
			component:NewFeed
		},
		{
			path:'/profile',
			component:Profile
		},
		{
			path:'/profile/user/:id',
			name:'profile',
			component:ProfileView
		},
		{
			path:'/friend',
			name:'friend',
			component:Friends
		},
		{
			path:'/newfeed',
			name:'newfeed',
			component:NewFeed
		}
	]
}