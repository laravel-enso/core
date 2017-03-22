<template>
    <div class="row">
        <div class="col-xs-12" v-if="roleMenusList">
            <center>
                <h5>
                    <slot name="role-configurator-menus-title"></slot>
                </h5>
            </center>
            <div class="panel-group" id="accordion-menus" role="tablist" aria-multiselectable="false">
                <checkbox-manager v-for="(groupData, groupName) in menusList"
                    parent="#accordion-menus"
                    :key="groupName"
                    :permissions-group-name="groupName"
                    :role-permissions-list="roleMenusList"
                    :permissions-group-data="groupData">
                </checkbox-manager>
            </div>
        </div>
        <div class="col-xs-12"  v-if="rolePermissionsList">
            <center>
                <h5>
                    <slot name="role-configurator-permissions-title"></slot>
                </h5>
            </center>
            <div class="panel-group" id="accordion-permissions-groups" role="tablist" aria-multiselectable="false">
                <checkbox-manager v-for="(groupData, groupName) in permissionsList"
                    :key="groupName"
                    parent-accordion="#accordion-permissions-groups"
                    :permissions-group-name="groupName"
                    :role-permissions-list="rolePermissionsList"
                    :permissions-group-data="groupData">
                </checkbox-manager>
            </div>
        </div>
        <center>
            <button class="btn btn-primary" @click="setPermissions">
                <slot name="role-configurator-update-button"></slot>
            </button>
        </center>
    </div>
</template>

<script>

    export default {

        props: {

            roleId: {
                type: Number,
                required: true
            }
        },
        data: function() {

            return {

                menusList: [],
                roleMenusList: [],
                rolePermissionsList: [],
                permissionsList: []
            };
        },
        methods: {

            getPermissions: function() {

                axios.get('/system/roles/getPermissions/' + this.roleId).then((response) => {

                    this.menusList = response.data.menusList;
                    this.permissionsGroupsList = response.data.permissionsGroupsList;
                    this.roleMenusList = response.data.roleMenusList;
                    this.rolePermissionsList = response.data.rolePermissionsList;
                    this.permissionsList = response.data.permissionsList;
                });
            },
            setPermissions: function() {

                var params = {
                    role_id: this.roleId,
                    roleMenusList: this.roleMenusList,
                    rolePermissionsList: this.rolePermissionsList,
                };

                axios.post('/system/roles/setPermissions', params).then((response) => {

                    toastr[response.data.level](response.data.message);
                });
            }
        },
        mounted: function() {

            this.getPermissions();
        }
    }
</script>