<template>

	<section class="hero login is-fullheight is-primary is-bold">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-mobile is-centered">
                	<router></router>
                </div>
            </div>
        </div>
    </section>

</template>

<script>

	import Router from '../layout/Router.vue';

	export default {
		name: 'Auth',

		components: { Router },

		beforeCreate() {
			this.$router.push({ name: 'login' });
		}
	};

</script>

<style>

	.box.login {
		 max-width: 400px;
	}

	figure.logo {
	    display: inline-block;
	}

</style>