<template>
    <div class="container">
        <canvas id="currencyGraph"></canvas>
    </div>
</template>

<script>
    export default {
        props: ['currency'],
        data() {
            return {
                labels: [],
                rates: []
            }
        },
        mounted() {
            axios.get('/valuta/' + this.currency.code + '/graph')
                .then(response => {
                    this.labels = response.data.labels
                    this.rates = response.data.rates

                    this.getGraph()
                })
                .catch(response => console.log(response.data));
        },
        methods: {
            getGraph() {
                console.log(this.labels)

                let currencyGraph = document.getElementById('currencyGraph').getContext('2d');
                let graph = new Chart(currencyGraph, {
                    type: 'line',
                    data: {
                        labels: this.labels,
                        datasets: [{
                            label: 'rate',
                            data: this.rates,
                            lineTension: .4,
                            backgroundColor: 'rgba(97, 123, 227, .1)',
                            borderColor: 'rgba(97, 123, 227, .6)'
                        }],

                    }
                });
            }
        }
    }
</script>
