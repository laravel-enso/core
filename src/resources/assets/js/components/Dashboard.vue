<template>
    <div class="row">
        <draggable class="col-md-6"
            v-for="(charts, column) in configuration.charts"
            :list="charts"
            :ref="'column_' + column"
            :options="{ handle: '.draggable', group: 'dashboard' }"
            @update="updateContent(column)"
            @add="updateContent(column)"
            @remove="updateContent(column)"
            v-if="isVisible">
            <div v-for="(chart, index) in charts"
                :key="index">
                <chart :type="chart.type"
                    :source="chart.source"
                    :params="params"
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
            preferences: {
                type: String,
                required: true
            },
            params: {
                type: Object
            }
        },
        watch: {
            configuration: {
                handler: 'updatePreferences',
                deep: true
            }
        },
        data: function() {
            return {
                configuration: JSON.parse(this.preferences),
                isVisible: true
            }
        },
        methods: {
            updateContent: function(column) {
                this.$nextTick(function() {
                        this.$refs['column_' + column][0].$children.forEach(function(child) {

                        child.getData();
                    });
                });
            },
            updatePreferences: function() {
                if (!this.settingPreferences) {
                    this.settingPreferences = true

                    axios.patch('/core/preferences/setPreferences', {key: 'dashboard', value: JSON.stringify(this.configuration)}).then(() => {
                        this.settingPreferences = false;
                    });
                }
            },
            resetToDefault: function() {
                this.isVisible = false;

                axios.post('/core/preferences/resetToDefaut', { key: 'dashboard' }).then((response) => {
                    this.configuration = response.data;
                    this.isVisible = true;
                });
            }
        }
    }

</script>