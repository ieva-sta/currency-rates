<template>
    <div class="d-flex align-items-center">
        <div>
            <h6 class="mb-0 mr-3">Currency:</h6>
        </div>
        <div>
            <select class="form-control" id="exampleFormControlSelect1" v-model="selected_currency">
                <option v-for="currency in currencies" :value="currency.code"
                        :selected="selected_currency === currency.code">
                    {{ currency.code }}
                </option>
            </select>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['value'],
        data() {
            return {
                currencies: null,
                selected_currency: this.value
            }
        },
        mounted() {
            axios.get('/currencies/all')
                .then(response => {
                    this.currencies = response.data.data
                })
                .catch(response => console.log(response.data));
        },
        watch: {
            selected_currency(value) {
                this.$emit('input', value)
            }
        }
    }
</script>
