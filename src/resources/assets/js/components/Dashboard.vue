<template>
    <div class="row">
        <draggable class="col-md-6"
            v-for="(charts, column) in preferences.charts"
            :list="charts"
            :options="{ handle: '.draggable', group: 'dashboard' }"
            @update="updateContent(column)"
            @add="updateContent(column)"
            @remove="updateContent(column)"
            v-if="isVisible"
            :key="column">
            <div v-for="(chart, index) in charts"
                :key="index">
                <chart :type="chart.type"
                    :source="chart.source"
                    :params="params"
                    :ref="chart.title"
                    draggable
                    :collapsed="chart.collapsed"
                    @changed-state="updateState($event, chart.source)">
                    <span slot="chart-title">{{ chart.title }}</span>
                </chart>
            </div>
        </draggable>
    </div>
</template>

<script>

    export default {
        props: {
            params: {
                type: Object
            }
        },
        watch: {
            // preferences: {
            //     handler: 'updatePreferences',
            //     deep: true
            // }
        },
        data() {
            return {
                isVisible: true,
                preferences: Store.user.preferences.local.dashboard
            }
        },
        methods: {
            updateContent(column) {
                for (let child in this.$refs) {
                    this.$refs[child][0].getData();
                }
            },
            updatePreferences() {
                if (!this.settingPreferences) {
                    this.settingPreferences = true

                    axios.patch('/core/preferences/setPreferences/dashboard', this.preferences).then(() => {
                        this.settingPreferences = false;
                    }).catch(error => {
                        this.reportEnsoException(error);
                    });
                }
            },
            resetToDefault() {
                this.isVisible = false;

                axios.post('/core/preferences/resetToDefaut', { page: 'dashboard' }).then((response) => {
                    this.preferences = response.data;
                    this.isVisible = true;
                }).catch(error => {
                    this.reportEnsoException(error);
                });
            }
        }
    }

</script>