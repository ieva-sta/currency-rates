<template>
    <div class="d-flex justify-content-center">
        <canvas :id="graphId" :height="this.showLabels ? '300' : '60'"></canvas>
    </div>
</template>

<script>
    export default {
        props: ['currency', 'showLabels', 'days', 'graphId'],
        data() {
            return {
                labels: [],
                rates: []
            }
        },
        mounted() {
            axios.get('/currency/' + this.currency.code + '/graph/' + this.days)
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
                                display: this.showLabels
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
                            ticks: {
                                fontColor: 'rgba(255, 255, 255, .6)'
                            }
                        }],
                        yAxes: [{
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                display: false
                            }
                        }]
                    }
                };

                let options = {
                    legend: {
                        display: false
                    },
                    responsive: false
                };

                let blueBackgroundGradient = currencyGraph.createLinearGradient(0, 0, 0, 450);
                blueBackgroundGradient.addColorStop(0, 'rgba(97, 123, 227, .1)');
                blueBackgroundGradient.addColorStop(0.1, 'rgba(97, 123, 227, 0.1)');
                blueBackgroundGradient.addColorStop(0.2, 'rgba(97, 123, 227, 0.02)');
                blueBackgroundGradient.addColorStop(1, 'rgba(97, 123, 227, 0)');

                let whiteBackgroundGradient = currencyGraph.createLinearGradient(0, 0, 0, 450);
                whiteBackgroundGradient.addColorStop(0, 'rgba(255, 255, 255, 0.3)');
                whiteBackgroundGradient.addColorStop(0.4, 'rgba(255, 255, 255, 0.05)');
                whiteBackgroundGradient.addColorStop(0.5, 'rgba(255, 255, 255, 0.02)');
                whiteBackgroundGradient.addColorStop(1, 'rgba(255, 255, 255, 0)');

                let lineGradient = currencyGraph.createLinearGradient(0, 0, 0, 450);
                lineGradient.addColorStop(0, 'rgba(97, 123, 227, 0.5)');
                lineGradient.addColorStop(0.5, 'rgba(97, 184, 227, 0.5)');
                lineGradient.addColorStop(1, 'rgba(97, 223, 227, 0.5)');

                let datasetsOptions = {
                    label: 'rate',
                    data: this.rates,
                    lineTension: .4,
                    backgroundColor: this.showLabels ? whiteBackgroundGradient : blueBackgroundGradient,
                    borderColor: this.showLabels ? 'rgba(255,255,255, .2)' : lineGradient,
                    borderWidth: this.showLabels ? 3 : 2,
                    pointBorderWidth: 1,
                    pointBackgroundColor: 'rgba(255, 255, 255, .7)'
                };

                let graph = new Chart(currencyGraph, {
                    type: 'line',
                    data: {
                        labels: this.labels,
                        datasets: [datasetsOptions]
                    },
                    options: {...options, ...(this.showLabels) && largeGraphOptions, ...(!this.showLabels) && smallGraphOptions}
                });
            }
        }
    }
</script>
