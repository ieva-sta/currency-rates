<template>
    <div class="container">
        <canvas :id="graphId" :width="this.width"></canvas>
    </div>
</template>

<script>
    export default {
        props: ['currency', 'showLabels', 'days', 'graphId'],
        data() {
            return {
                labels: [],
                rates: [],
                width: this.showLabels ? '900' : '120'
            }
        },
        mounted() {
            axios.get('/valuta/' + this.currency.code + '/graph/' + this.days)
                .then(response => {
                    this.labels = response.data.labels
                    this.rates = response.data.rates

                    this.getGraph()
                })
                .catch(response => console.log(response.data));
        },
        methods: {
            getGraph() {
                let currencyGraph = document.getElementById(this.graphId).getContext('2d');
                let smallGraphOptions = {
                    elements: {
                        point: {
                            radius: 0
                        }
                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                display: this.showLabels,
                            },
                            gridLines: {
                                display: false,
                            },
                        }],
                        yAxes: [{
                            ticks: {
                                display: this.showLabels,
                            },
                            gridLines: {
                                display: this.showLabels,
                            }
                        }]
                    }
                };

                let largeGraphOptions = {
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: false,
                            },
                        }],
                    }
                };

                let options = {
                    legend: {
                        display: false
                    },
                    responsive: false
                };

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

                    },
                    options: {...options, ...(this.showLabels) && largeGraphOptions, ...(!this.showLabels) && smallGraphOptions}
                });
            }
        }
    }
</script>
