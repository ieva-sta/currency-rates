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
                width: this.showLabels ? '900' : '80'
            }
        },
        mounted() {
            console.log(this.graphId)
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
                console.log(this.graphId)
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
                    options: {
                        legend: {
                            display: false
                        },
                        responsive: false,
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
                    }
                });
            }
        }
    }
</script>
