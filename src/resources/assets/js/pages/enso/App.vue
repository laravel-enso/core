<template>

	<div id="app">
		<transition
			enter-active-class="fadeIn"
			leave-active-class="fadeOut">
			<component :is="component"
				class="animated"
				@enter-app="showHome=false">
			</component>
		</transition>
	</div>

</template>

<script>

	import Auth from './layout/Auth.vue';
	import Home from'./layout/Home.vue';
	import AppMain from'./layout/AppMain.vue';
	import { mapGetters } from 'vuex';

	export default {
		name: 'App',

		components: { Auth, Home, AppMain },

		computed: {
			...mapGetters('auth', ['isAuth']),
			component() {
				return !this.isAuth
					? 'auth'
					: (this.showHome
						? 'home'
						: 'app-main');
			}
		},

		data() {
			return {
                showHome: false
			}
		},

		watch: {
			isAuth: {
				handler() {
					if (this.isAuth) {
						this.showHome = true;
					}
				}
			}
		}
	};

</script>