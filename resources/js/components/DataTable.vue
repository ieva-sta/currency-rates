<template>
    <div class="data-table">
        <table class="table table-hover">
            <tbody>
            <tr class="" v-if="tableData.length === 0">
                <td class="lead text-center" :colspan="columns.length + 1">No data found.</td>
            </tr>
            <tr v-for="(currency, key1) in tableData" :key="currency.id" class="m-datatable__row" v-else>
                <td>
                    <a href="#" class="d-flex">
                        <div
                            class="currency-logo d-flex align-items-center justify-content-center font-weight-bold">
                            {{ currency.symbol }}
                        </div>
                        <div class="d-flex flex-column justify-content-center ml-3">
                            <h5 class="m-0 font-weight-bold">
                                {{ currency.code }}
                            </h5>
                            <p class="m-0">
                                {{ currency.title }}
                            </p>
                        </div>
                    </a>
                </td>
                <td>
                    <a href="#"
                       class="d-flex align-items-center">
                        <h5 class="m-0">{{ currency.rate }}</h5>
                    </a>
                </td>
                <td>
                    <a href="#"
                       class="d-flex align-items-center justify-content-center">
                        <div>
                            <graph :currency="currency" :graph-id="currency.id"
                                   :show-labels="false" :days="7"></graph>
                        </div>
                        <div class="d-flex">
                            <i class="mr-1 fas" :class="currency.trend.trend ? 'fa-caret-up' : 'fa-caret-down'"></i>
                            <h6>{{ currency.trend.percentage }} %</h6>
                        </div>
                    </a>
                </td>
            </tr>
            </tbody>

        </table>
    </div>
</template>

<script>
    import Graph from './Graph.vue'

    export default {
        components: {Graph},
        props: {
            fetchUrl: {
                type: String,
                required: true
            },
            columns: {
                type: Array,
                required: true
            },
        },
        data() {
            return {
                tableData: []
            }
        },
        created() {
            return this.fetchData(this.fetchUrl)
        },
        methods: {
            fetchData(url) {
                axios.get(url)
                    .then(data => {
                        this.tableData = data.data.data
                    })
            },

        }
    }
</script>

<style scoped>

</style>
