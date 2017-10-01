<template>

	<section class="hero is-fullheight is-primary is-bold">
        <div class="hero-body">
            <div class="container has-text-centered">
            	<overlay v-if="loading"
            		:opacity="false"
            		color="#dbdbdb"
            		size="large">
        		</overlay>
	            <div class="title is-1 inspiring animated fadeInDown"
	            	 v-if="!loading">
	            	{{ meta.quote }}
	            </div>

	            <button class="animated fadeInRightBig button is-outlined"
	            	@click="$emit('enter-app')"
	            	v-if="!loading">
	            	Enter the application
            	</button>
       	 	</div>
		</div>
	</section>

</template>

<script>

	import Overlay from '../../../components/enso/bulma/Overlay.vue';
	import { mapState } from 'vuex';
	import { mapActions } from 'vuex';

	export default {
		name: 'Home',

		components: { Overlay },

		computed: {
			...mapState(['meta']),
		},

		data() {
			return {
				loading: false
			}
		},

		beforeMount() {
			this.init()
		},

		methods: {
			...mapActions(['setState']),
			init() {
				this.loading = true;
				this.setState();
				setTimeout(() => this.loading = false, 500);
			}
		}
	};

</script>

<style>

	.title.inspiring {
		font-weight: 200;
	}

</style>