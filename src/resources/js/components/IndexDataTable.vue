<template>
    <div class="data-table d-flex flex-column p-5">
        <div class="d-flex justify-content-end pb-2">
            <div class="col-3">
                <currency-select v-model="selected_currency"></currency-select>
            </div>
        </div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col" @click="sortByColumn('code')">
                    <i class="fas" :class="order === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down'"></i>
                    Currency
                </th>
                <th scope="col" @click="sortByColumn('rate')">
                    <i class="fas" :class="order === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down'"></i>
                    Rate
                </th>
                <th scope="col" class="text-center">Trend</th>
            </tr>
            </thead>
            <tbody>
            <tr class="" v-if="tableData.length === 0">
                <td class="lead text-center">No data found.</td>
            </tr>
            <tr v-for="currency in tableData" :key="currency.id" v-else class="currency-list">
                <td class="p-0">
                    <a :href="`currency/${currency.code}`" class="d-flex">
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
                    <a :href="`currency/${currency.code}`"
                       class="d-flex align-items-center">
                        <h5 class="m-0">{{ currency.rate }}</h5>
                    </a>
                </td>
                <td>
                    <a :href="`currency/${currency.code}`"
                       class="d-flex align-items-center justify-content-center">
                        <div class="mr-3">
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
        <nav v-if="pagination && tableData.length > 0" class="d-flex flex-column my-auto align-items-center">
            <ul class="pagination mb-1">
                <li class="page-item" :class="{'disabled' : currentPage === 1}">
                    <a class="page-link" href="#" @click.prevent="changePage(currentPage - 1)">Previous</a>
                </li>
                <li v-for="page in pagesNumber" class="page-item"
                    :class="{'active': page == pagination.meta.current_page}">
                    <a href="javascript:void(0)" @click.prevent="changePage(page)" class="page-link">{{ page }}</a>
                </li>
                <li class="page-item" :class="{'disabled': currentPage === pagination.meta.last_page }">
                    <a class="page-link" href="#" @click.prevent="changePage(currentPage + 1)">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    import Graph from './Graph.vue'
    import CurrencySelect from './CurrencySelect.vue'

    export default {
        components: {Graph, CurrencySelect},
        props: {
            fetchUrl: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                tableData: [],
                url: '',
                pagination: {
                    meta: {to: 1, from: 1}
                },
                offset: 4,
                currentPage: 1,
                sortedColumn: 'id',
                order: 'asc',
                selected_currency: 'EUR'
            }
        },
        watch: {
            fetchUrl: {
                handler: function (fetchUrl) {
                    this.url = fetchUrl
                },
                immediate: true
            },
            selected_currency() {
                this.fetchData()
            }
        },
        created() {
            return this.fetchData(this.fetchUrl)
        },
        computed: {
            /**
             * Get the pages number array for displaying in the pagination.
             * */
            pagesNumber() {
                if (!this.pagination.meta.to) {
                    return []
                }
                let from = this.pagination.meta.current_page - this.offset
                if (from < 1) {
                    from = 1
                }
                let to = from + (this.offset * 2)
                if (to >= this.pagination.meta.last_page) {
                    to = this.pagination.meta.last_page
                }
                let pagesArray = []
                for (let page = from; page <= to; page++) {
                    pagesArray.push(page)
                }
                return pagesArray
            },
            /**
             * Get the total data displayed in the current page.
             * */
            totalData() {
                return (this.pagination.meta.to - this.pagination.meta.from) + 1
            }
        },
        methods: {
            fetchData() {
                let dataFetchUrl = `${this.url}?page=${this.currentPage}&column=${this.sortedColumn}&order=${this.order}&per_page=${this.perPage}&currency=${this.selected_currency}`
                axios.get(dataFetchUrl)
                    .then(({data}) => {
                        this.pagination = data
                        this.tableData = data.data
                    }).catch(error => this.tableData = [])
            },
            /**
             * Change the page.
             * @param pageNumber
             */
            changePage(pageNumber) {
                this.currentPage = pageNumber
                this.fetchData()
            },
            /**
             * Sort the data by column.
             * */
            sortByColumn(column) {
                if (column === this.sortedColumn) {
                    this.order = (this.order === 'asc') ? 'desc' : 'asc'
                } else {
                    this.sortedColumn = column
                    this.order = 'asc'
                }
                this.fetchData()
            }
        }
    }
</script>
