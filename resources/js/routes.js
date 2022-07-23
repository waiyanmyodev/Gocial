import Test from './components/Test';
import Profile from './components/User/Profile';
import ProfileView from './components/User/ProfileView';
import Friends from './components/User/Friends';
import NewFeed from './components/Layouts/NewFeed/NewFeed';
import SaveItemFeed from './components/Layouts/Save/SaveItemFeed';
import Setting from './components/Layouts/Setting/Setting';
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
		},

		{
			path:'/save',
			name:'save',
			component:SaveItemFeed
		},
		{
			path:'/setting',
			name:'setting',
			component:Setting
		},
	]
}