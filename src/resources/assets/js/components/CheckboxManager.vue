<template>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" :id="'heading-' + permissionsGroupName">
            <h4 class="panel-title">
                <a class="collapsed" role="button"
                    data-toggle="collapse"
                    :href="'#component-' + permissionsGroupName"
                    aria-expanded="false">
                    {{ permissionsGroupName }}
                </a>
                <div class="pull-right" style="margin-bottom: 0; margin-top: -3px;">
                    <input type="checkbox"
                        :data-group-id="_uid"
                        :data-parent-group-id="$parent._uid"
                        @change="updateChildGroups">
                </div>
            </h4>
        </div>
        <div :id="'component-' + permissionsGroupName"
            class="panel-collapse collapse"
            role="tabpanel">
            <div class="panel-group"
                :id="'accordion-permissions-group-' + _uid"
                role="tablist" aria-multiselectable="false"
                style="margin-left: 25px;margin-right:25px;margin-top:10px; padding-bottom: 10px"
                v-if="!(permissionsGroupData.length)">
                <checkbox-manager ref="children"
                    :parent-accordion="'#accordion-permissions-group-' + _uid"
                    :permissions-group-name="index"
                    :permissions-group-data="group"
                    :role-permissions-list="rolePermissionsList"
                    v-for="(group, index) in permissionsGroupData"
                    :key="index"
                    @state-updated="updateGroupState">
                </checkbox-manager>
            </div>
            <div class="panel-body" v-if="permissionsGroupData.length">
                <div class="row">
                    <div class="col-xs-6" v-for="permission in permissionsGroupData">
                        <div class="form-group">
                            <input type="checkbox"
                                :key="permission.id"
                                :value="permission.id"
                                v-model="selectedPermissionsIds"
                                @change="updatePermissionGroupData">
                            <label>{{ permission.description ? permission.description : permission.name }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {

        name: 'checkboxManager',
        props: {
            parentAccordion: {
                default: null
            },
            permissionsGroupName: {
                default: null
            },
            permissionsGroupData: {
                default: null
            },
            rolePermissionsList: {
                type: Array,
                required: true,
                default: []
            }
        },
        computed: {
            permissionsIds: function() {

                let ids = [];

                if (this.permissionsGroupData.length) {

                    this.permissionsGroupData.forEach(function(permission) {

                        ids.push(permission.id);
                    });
                }

                return ids;
            },
            groupsNo: function() {

                return typeof this.permissionsGroupData.length === 'undefined' ? Object.keys(this.permissionsGroupData).length : 0;
            }
        },
        data: function() {
            return {
                selectedPermissionsIds: []
            };
        },
        methods: {
            getSelectedPermissionsIds: function() {

                let self = this,
                    ids = [];

                this.permissionsIds.forEach(function(id) {

                    if (self.rolePermissionsList.indexOf(id) > -1) {

                        ids.push(id);
                    }
                });

                return ids;
            },
            updateGroupState: function() {

                if (this.groupsNo) {

                    let checkedLength = $('[data-parent-group-id="' + this._uid + '"]:checkbox:checked').length;

                    if (checkedLength === this.groupsNo) {

                        this.setCheckedState('[data-group-id="' + this._uid + '"]');
                    } else if (checkedLength) {

                        this.setIndeterminateState('[data-group-id="' + this._uid + '"]');
                    } else {

                        let indeterminateLengh = 0;

                        $('[data-parent-group-id="' + this._uid + '"]').each(function() {

                            if ($(this).prop('indeterminate')) {

                                indeterminateLengh++;
                            }
                        });

                        if (indeterminateLengh) {

                            this.setIndeterminateState('[data-group-id="' + this._uid + '"]');
                        } else {

                            this.setUncheckedState('[data-group-id="' + this._uid + '"]');
                        }

                    }

                } else if (this.selectedPermissionsIds.length === this.permissionsIds.length) {

                    this.setCheckedState('[data-group-id="' + this._uid + '"]');
                } else if (this.selectedPermissionsIds.length) {

                    this.setIndeterminateState('[data-group-id="' + this._uid + '"]');
                } else {

                    this.setUncheckedState('[data-group-id="' + this._uid + '"]');
                }

                this.$emit('state-updated');
            },
            updatePermissionGroupData: function() {

                let self = this;
                let idx = null;

                this.permissionsIds.forEach(function(id) {

                    idx = self.rolePermissionsList.indexOf(id);

                    if (idx !== -1) {

                        self.rolePermissionsList.splice(idx, 1);
                    }
                });

                this.selectedPermissionsIds.forEach(function(id) {

                    self.rolePermissionsList.push(id);
                });

                this.updateGroupState();
            },
            updateChildGroups: function() {

                let state = $('[data-group-id="' + this._uid + '"]').prop('checked') ? true : false;

                if (typeof this.permissionsGroupData.length === 'undefined') {

                    this.$refs.children.forEach(function(ref) {
                        ref.selectGroup(state);
                    });
                }

                this.selectGroup(state);
            },
            selectGroup: function(state) {

                if (this.permissionsGroupData.length) {

                    if (state) {

                        this.selectedPermissionsIds = this.permissionsIds;
                    } else {

                        this.selectedPermissionsIds = [];
                    }

                    this.updatePermissionGroupData();
                }
            },
            setCheckedState: function(checkbox) {

                $(checkbox).prop('checked', true);
                $(checkbox).prop('indeterminate', false);
            },
            setUncheckedState: function(checkbox) {

                $(checkbox).prop('checked', false);
                $(checkbox).prop('indeterminate', false);
            },
            setIndeterminateState: function(checkbox) {

                $(checkbox).prop('checked', false);
                $(checkbox).prop('indeterminate', true);
            },
        },
        mounted: function() {

            this.selectedPermissionsIds = this.getSelectedPermissionsIds();
            this.updateGroupState();
        }
    }
</script>