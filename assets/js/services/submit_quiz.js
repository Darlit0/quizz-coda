document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('resultsChart').getContext('2d');

    const data = {
        labels: ['Bonnes réponses', 'Mauvaises réponses'],
        datasets: [{
            label: 'Résultats du Quiz',
            data: [correctAnswers, wrongAnswers],
            backgroundColor: ['#28a745', '#dc3545'],
            borderColor: ['#28a745', '#dc3545'],
            borderWidth: 1
        }]
    };

    const config = {
        type: 'doughnut',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Chart.js Doughnut Chart'
                }
            }
        }
    };

    const resultsChart = new Chart(ctx, config);
});