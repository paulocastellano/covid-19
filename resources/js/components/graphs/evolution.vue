<script>
import { Line } from 'vue-chartjs'
export default {
    name: 'GraphEvolution',
    extends: Line,
    props: {
        evolution: {
            required: true
        }
    },
    data: () => ({
        labels: [],
        totalConfirmed: [],
        totalDeaths: []

    }),
    mounted () {
        this.organizeData()
        this.render();
    },

    methods: {

        organizeData () {

            // organize data in Chart.js format
             this.evolution.forEach(element => {
                this.labels.push(element.date);
                this.totalConfirmed.push(element.totalConfirmed);
                this.totalDeaths.push(element.totalDeaths);
            });
        },

        render() {

            // renderChart is property of Chart.js
            this.renderChart(
                {
                    labels: this.labels,
                    datasets: [
                        {
                            label: 'Confirmados',
                            backgroundColor: '#5eba00',
                            data: this.totalConfirmed
                        },
                        {
                            label: 'Óbitos',
                            backgroundColor: '#cd201f',
                            data: this.totalDeaths
                        }
                    ]
                },
                {
                    responsive: true,
                    maintainAspectRatio: false
                }
            )
        }
    },
}
</script>
