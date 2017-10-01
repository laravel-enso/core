<template>

	<transition
        mode="out-in"
        enter-active-class="fadeIn"
        leave-active-class="fadeOut">
        <router-view :class="{ 'animated': !$route.meta.notAnimated }"
            :key="$route.fullPath">
    	</router-view>
    </transition>

</template>

<script>

	export default {
		name: 'Router'
	}

</script>