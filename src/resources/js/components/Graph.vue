<template>
    <div class="d-flex justify-content-center">
        <canvas :id="graphId" :height="this.showLabels ? '300' : '50'"></canvas>
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

                let smallChartBackgroundGradient = currencyGraph.createLinearGradient(0, 0, 0, 450);
                smallChartBackgroundGradient.addColorStop(0, 'rgba(136, 147, 175, .5)');
                smallChartBackgroundGradient.addColorStop(0.1, 'rgba(136, 147, 175, 0.1)');
                smallChartBackgroundGradient.addColorStop(0.2, 'rgba(136, 147, 175, 0.02)');
                smallChartBackgroundGradient.addColorStop(1, 'rgba(136, 147, 175, 0)');

                let largeChartBackgroundGradient = currencyGraph.createLinearGradient(0, 0, 0, 450);
                largeChartBackgroundGradient.addColorStop(0, 'rgba(136, 147, 175, 1)');
                largeChartBackgroundGradient.addColorStop(0.5, 'rgba(136, 147, 175, 0.5)');
                largeChartBackgroundGradient.addColorStop(1, 'rgba(136, 147, 175, .2)');

                let lineGradient = currencyGraph.createLinearGradient(0, 0, 0, 450);
                lineGradient.addColorStop(0, 'rgba(136, 147, 175, 0.5)');
                lineGradient.addColorStop(0.5, 'rgba(136, 147, 175, 0.5)');
                lineGradient.addColorStop(1, 'rgba(136, 147, 175, 0.5)');

                let datasetsOptions = {
                    label: 'rate',
                    data: this.rates,
                    lineTension: .4,
                    backgroundColor: this.showLabels ? largeChartBackgroundGradient : smallChartBackgroundGradient,
                    borderColor: lineGradient,
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
