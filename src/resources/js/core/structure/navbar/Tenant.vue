<template>
    <div class="navbar-item tenant"
        v-if="canAccess('administration.companies.tenants')">
        <span :class="[
                'tag is-bold is-clickable',
                tenant === null ? 'is-info' : 'is-danger'
            ]"
            @click="modal = true">
            <span class="name">
                {{ tenant ? tenant.name : __('System') }}
            </span>
            <a class="delete is-small"
                v-if="tenant !== null"
                @click.stop="setTenant(null)"/>
        </span>
        <modal v-if="modal"
            container="tenant-container"
            :show="modal"
            @close="modal = false">
            <div class="box tenant">
                <label class="is-bold">
                    {{ __('Select Tenant') }}
                </label>
                <vue-select v-model="tenantId"
                    source="administration.companies.tenants"
                    :params="{ is_tenant: true }"
                    ref="select"/>
            </div>
        </modal>
    </div>
</template>

<script>

import { mapState, mapMutations } from 'vuex';
import Modal from '../../../components/enso/bulma/Modal.vue';
import VueSelect from '../../../components/enso/select/VueSelect.vue';

export default {
    name: 'Tenant',

    components: { Modal, VueSelect },

    data: () => ({
        modal: false,
    }),

    computed: {
        ...mapState(['visibleTenants', 'tenant']),
        tenantId: {
            get() {
                return this.tenant !== null
                    ? this.tenant.id
                    : null;
            },
            set(value) {
                const tenant = value !== null
                    ? this.$refs.select.optionList
                        .find(({ id }) => id === value)
                    : null;
                this.setTenant(tenant);
            },
        },
    },


    methods: {
        ...mapMutations(['setTenant']),
    },
};

</script>

<style lang="scss">
    .navbar-item.tenant .tag .name {
        max-width: 100px;
        overflow-x: hidden;
        text-overflow: ellipsis;
    }

    .tenant-container > .modal > .modal-content {
        overflow: unset;
    }

    .box.tenant {
        width: 400px;
        margin: auto;
    }
</style>
