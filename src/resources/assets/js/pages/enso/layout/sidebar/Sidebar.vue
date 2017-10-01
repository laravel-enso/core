<template>

	<vue-aside class="menu aside">
        <p class="menu-label has-text-centered">
            {{ __("Main Menu") }}
        </p>
        <menus class="menu-list"
            :menus="menus">
        </menus>
    </vue-aside>

</template>

<script>

    import VueAside from '../VueAside.vue';
    import Menus from './Menus.vue';
    import { mapGetters } from 'vuex';

	export default {
		name: 'Sidebar',

        components: { VueAside, Menus },

        computed: {
            ...mapGetters('locale', ['__']),
            menus() {
                return this.$store.state.menus.list;
            },
        }
	};

</script>

<style>

    .aside.menu {
        left: 0;
    }

</style>