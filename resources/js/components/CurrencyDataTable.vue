<template>
    <div class="d-flex justify-content-center">
        <div class="currency-data-table col-7 py-2">
            <div class="bg-white shadow-sm m-2 rounded d-flex justify-content-between p-3" v-for="rate in tableData"
                 :key="rate.id">
                <div>{{ rate.date }}</div>
                <div>{{ rate.price }}</div>
            </div>
            <nav v-if="pagination && tableData.length > 0" class="d-flex flex-column align-items-center">
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
    </div>
</template>

<script>
    export default {
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
                perPage: 7
            }
        },
        watch: {
            fetchUrl: {
                handler: function (fetchUrl) {
                    this.url = fetchUrl
                },
                immediate: true
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
                let dataFetchUrl = `${this.url}?page=${this.currentPage}`
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
            }
        }
    }
</script>
