<template>

    <div class="columns is-centered">
        <div class="column is-three-quarters animated fadeIn"
            v-if="form && owner">
            <vue-form class="box"
                :data="form">
            </vue-form>
            <contacts :id="owner.id"
                type="owner">
            </contacts>
            <comments :id="owner.id"
                type="owner">
            </comments>
            <documents :id="owner.id"
                type="owner">
            </documents>
            <addresses :id="owner.id"
                type="owner">
            </addresses>
        </div>
    </div>

</template>

<script>

import Documents from '../../../components/enso/documents/Documents.vue';
import Comments from '../../../components/enso/comments/Comments.vue';
import Contacts from '../../../components/enso/contacts/Contacts.vue';
import Addresses from '../../../components/enso/addresses/Addresses.vue';
import VueForm from '../../../components/enso/vueforms/VueForm.vue';

export default {
    components: {
        Comments, Contacts, Documents, Addresses, VueForm,
    },

    data() {
        return {
            form: null,
            owner: null,
        };
    },

    created() {
        axios.get(route(this.$route.name, this.$route.params.id, false)).then(({ data }) => {
            this.form = data.form;
            this.owner = data.owner;
        }).catch(error => this.handleError(error));
    },
};

</script>
