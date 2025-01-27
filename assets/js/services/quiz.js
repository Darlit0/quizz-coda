document.addEventListener('DOMContentLoaded', () => {
    const accordion = document.getElementById('accordionExample');
    accordion.addEventListener('change', (event) => {
        if (event.target.type === 'radio') {
            const currentItem = event.target.closest('.accordion-item');
            const nextItem = currentItem.nextElementSibling;
            if (nextItem) {
                const nextButton = nextItem.querySelector('.accordion-button');
                nextButton.click();
            }
        }
    });

    var deleteQuizId = null;

    document.querySelectorAll('.delete-quiz').forEach(function(button) {
        button.addEventListener('click', function() {
            deleteQuizId = this.getAttribute('data-id');
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        });
    });

    document.getElementById('confirmDelete').addEventListener('click', function() {
        if (deleteQuizId) {
            fetch('list.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: deleteQuizId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Erreur lors de la suppression du quiz.');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la suppression du quiz.');
            });
        }
    });
});