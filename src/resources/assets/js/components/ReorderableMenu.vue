<template>
    <draggable :list="menus"
        element="ul"
        class="sortable-menu"
        :options="{ group: { name:'menus' }}">
        <li v-for="menu in menus"
            :key="menu.unique_id"
            class="sortable-menu">
                <div>{{ menu.name }}</div>
            <reorderable-menu :menus="menu.children">
            </reorderable-menu>
        </li>
    </draggable>
</template>

<script>

    export default {

        props: {

            menus: {
                type: Array,
                required: true
            },
        }
    }

</script>

<style>

    ul.sortable-menu {
        padding-top: 15px;
        background-color: #4c5f67;
        list-style: none;
        min-height: 10px;
    }

    li.sortable-menu {
        margin: 4px 0;
        padding: 0;
    }

    li.sortable-menu div {
        border-radius: 0px;
        border-bottom: 1px solid white;
        padding: 6px;
        margin: 0;
        cursor: move;
        color: #fff;
    }
</style>