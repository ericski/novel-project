<div>
    <canvas id="{{ $id }}"></canvas>
</div>

<script>
    const ctx_{{ $id }} = document.getElementById('{{ $id }}');
    const labels_{{ $id }} = @json($chart_data['labels']);
    const counts_{{ $id }} = @json($chart_data['progress']);

    let pchart_{{ $id }} = new Chart(ctx_{{ $id }}, {
        type: 'line',
        data: {
            labels: labels_{{ $id }},
            datasets: [{
                label: 'Progress',
                data: counts_{{ $id }},
                fill: false,
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
