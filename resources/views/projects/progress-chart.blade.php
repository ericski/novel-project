<div>
    <canvas id="{{ $id }}"></canvas>
</div>

<script>
    (function() {
        const ctx_{{ $id }} = document.getElementById('{{ $id }}');

        // Get existing chart instance from Chart.js registry and destroy it
        const existingChart = Chart.getChart(ctx_{{ $id }});
        if (existingChart) {
            existingChart.destroy();
        }

        const labels_{{ $id }} = @json($chart_data['labels']);
        const counts_{{ $id }} = @json($chart_data['progress']);
        const chartType_{{ $id }} = @json($chart_type ?? 'line');

        new Chart(ctx_{{ $id }}, {
            type: chartType_{{ $id }},
            data: {
                labels: labels_{{ $id }},
                datasets: [{
                    label: 'Progress',
                    data: counts_{{ $id }},
                    fill: false,
                    backgroundColor: 'rgba(75, 192, 192, 0.8)',
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    })();
</script>
