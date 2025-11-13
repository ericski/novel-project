<div>
    <canvas id="{{ $id }}"></canvas>
</div>

<script>
    const ctx_{{ $id }} = document.getElementById('{{ $id }}');
    const labels_{{ $id }} = @json($chart_data['labels']);
    const counts_{{ $id }} = @json($chart_data['progress']);
    const chartType_{{ $id }} = @json($chart_type ?? 'line');

    let pchart_{{ $id }} = new Chart(ctx_{{ $id }}, {
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
</script>
