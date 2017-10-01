<template>

	<div id="app">
		<transition
			leave-active-class="fadeOut">
			<auth v-if="!auth"
				class="animated"
				:class="{ 'fadeIn': !auth }">
			</auth>
		</transition>

		<transition
			leave-active-class="fadeOut">
			<home class="animated"
				:class="{ 'fadeIn': showHome }"
				v-if="showHome"
				@enter-app="showHome=false">
			</home>
		</transition>

		<app-main v-if="auth && !showHome">
		</app-main>
	</div>

</template>

<script>

	import Auth from './layout/Auth.vue';
	import Home from'./layout/Home.vue';
	import AppMain from'./layout/AppMain.vue';
	import { mapState } from 'vuex';

	export default {
		name: 'App',

		components: { Auth, Home, AppMain },

		computed: {
			...mapState('tokens', ['auth']),
		},

		data() {
			return {
                showHome: false
			}
		},

		watch: {
			auth: {
				handler() {
					if (this.auth) {
						this.showHome = true;
					}
				}
			}
		}
	};

</script>