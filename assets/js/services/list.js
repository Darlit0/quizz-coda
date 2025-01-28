document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggle-status').forEach(function(button) {
        button.addEventListener('click', function() {
            var quizId = this.getAttribute('data-id');
            var currentStatus = this.getAttribute('data-status');
            var newStatus = currentStatus == 1 ? 0 : 1;

            fetch('../controller/list.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'action=toggle_status&quiz_id=' + quizId + '&status=' + newStatus
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload(); // Recharge la page après la mise à jour réussie
                } else {
                    alert('Failed to update status');
                }
            });
        });
    });

    document.querySelectorAll('.edit-quiz').forEach(function(button) {
        button.addEventListener('click', function() {
            var quizId = this.getAttribute('data-id');
            window.location.href = '../view/modified_quiz.php?quiz_id=' + quizId;
        });
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
            fetch('../controller/list.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'action=delete&quiz_id=' + deleteQuizId
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