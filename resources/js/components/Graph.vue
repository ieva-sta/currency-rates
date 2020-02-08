<template>
    <div class="d-flex justify-content-center">
        <canvas :id="graphId" :height="this.height" :width="this.width"></canvas>
    </div>
</template>

<script>
    export default {
        props: ['currency', 'showLabels', 'days', 'graphId'],
        data() {
            return {
                labels: [],
                rates: [],
                height: this.showLabels ? '400' : '50',
                width: this.showLabels ? '900' : '150'
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
                                display: this.showLabels,
                                maxRotation: 45,
                                minRotation: 45
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

                let backgroundGradient = currencyGraph.createLinearGradient(0, 0, 0, 450);
                backgroundGradient.addColorStop(0, 'rgba(97, 123, 227, 0.1)');
                backgroundGradient.addColorStop(0.5, 'rgba(97, 123, 227, 0.05)');
                backgroundGradient.addColorStop(1, 'rgba(97, 123, 227, 0)');

                let lineGradient = currencyGraph.createLinearGradient(0, 0, 0, 450);
                lineGradient.addColorStop(0, 'rgba(97, 123, 227, 0.8)');
                lineGradient.addColorStop(0.5, 'rgba(97, 184, 227, 0.8)');
                lineGradient.addColorStop(1, 'rgba(97, 223, 227, 0.8)');

                let graph = new Chart(currencyGraph, {
                    type: 'line',
                    data: {
                        labels: this.labels,
                        datasets: [{
                            label: 'rate',
                            data: this.rates,
                            lineTension: .4,
                            backgroundColor: backgroundGradient,
                            borderColor: lineGradient,
                            borderWidth: this.showLabels ? 3 : 2
                        }],

                    },
                    options: {...options, ...(this.showLabels) && largeGraphOptions, ...(!this.showLabels) && smallGraphOptions}
                });
            }
        }
    }
</script>
