document.addEventListener('DOMContentLoaded', function() {
    const accordion = document.getElementById('accordionExample');
    const progressBar = document.getElementById('progressBar');
    const totalQuestions = document.querySelectorAll('.accordion-item').length;
    let answeredQuestions = 0;

    accordion.addEventListener('change', function(event) {
        if (event.target.type === 'radio') {
            const currentItem = event.target.closest('.accordion-item');
            const currentCollapse = currentItem.querySelector('.accordion-collapse');
            const nextItem = currentItem.nextElementSibling;
            if (nextItem) {
                const nextButton = nextItem.querySelector('.accordion-button');
                const nextCollapse = nextItem.querySelector('.accordion-collapse');
                nextCollapse.classList.add('show');
                nextButton.classList.remove('collapsed');
                nextButton.setAttribute('aria-expanded', 'true');
            }
            currentCollapse.classList.remove('show');

            answeredQuestions++;
            const progress = (answeredQuestions / totalQuestions) * 100;
            progressBar.style.width = progress + '%';
            progressBar.textContent = Math.round(progress) + '%';
        }
    });

    document.getElementById('submit-quiz').addEventListener('click', function(event) {
        event.preventDefault();

        const formData = new FormData(document.getElementById('quiz-form'));
        formData.append('quiz_id', new URLSearchParams(window.location.search).get('quiz_id'));

        fetch('../view/submit_quiz.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const resultDiv = document.getElementById('result');
            if (data.success) {
                resultDiv.innerHTML = `<div class="alert alert-success">Votre score est de ${data.score} / ${data.total}</div>`;
            } else {
                resultDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            const resultDiv = document.getElementById('result');
            resultDiv.innerHTML = `<div class="alert alert-danger">Erreur lors de la soumission du quiz.</div>`;
        });
    });
});