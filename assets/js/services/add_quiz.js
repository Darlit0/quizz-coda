document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('add-question').addEventListener('click', function() {
        var questionInput = document.getElementById('question');
        var questionText = questionInput.value.trim();

        if (questionText !== '') {
            var questionList = document.getElementById('question-list');
            var newQuestionItem = document.createElement('li');
            newQuestionItem.className = 'list-group-item';

            var questionHeader = document.createElement('div');
            questionHeader.className = 'mb-3';
            questionHeader.innerHTML = '<label for="new_question_' + questionList.children.length + '" class="form-label">Question</label>' +
                                       '<input type="text" class="form-control" id="new_question_' + questionList.children.length + '" name="questions[new_' + questionList.children.length + '][question]" value="' + questionText + '" required>';

            var goodResponseInput = document.createElement('div');
            goodResponseInput.className = 'mb-3';
            goodResponseInput.innerHTML = '<label for="new_good_response_' + questionList.children.length + '" class="form-label">Bonne réponse</label>' +
                                          '<input type="text" class="form-control" id="new_good_response_' + questionList.children.length + '" name="questions[new_' + questionList.children.length + '][good_response]" required>';

            var badResponsesInput = document.createElement('div');
            badResponsesInput.className = 'mb-3';
            badResponsesInput.innerHTML = '<label for="new_bad_responses_' + questionList.children.length + '" class="form-label">Mauvaises réponses (séparées par des virgules)</label>' +
                                          '<input type="text" class="form-control" id="new_bad_responses_' + questionList.children.length + '" name="questions[new_' + questionList.children.length + '][bad_responses]" required>';

            var pointInput = document.createElement('div');
            pointInput.className = 'mb-3';
            pointInput.innerHTML = '<label for="new_point_' + questionList.children.length + '" class="form-label">Points</label>' +
                                   '<input type="number" class="form-control" id="new_point_' + questionList.children.length + '" name="questions[new_' + questionList.children.length + '][point]" value="1" required>';

            var removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-danger btn-sm';
            removeButton.textContent = 'Supprimer la question';
            removeButton.addEventListener('click', function() {
                questionList.removeChild(newQuestionItem);
            });

            newQuestionItem.appendChild(questionHeader);
            newQuestionItem.appendChild(goodResponseInput);
            newQuestionItem.appendChild(badResponsesInput);
            newQuestionItem.appendChild(pointInput);
            newQuestionItem.appendChild(removeButton);

            questionList.appendChild(newQuestionItem);

            // Effacer le champ de saisie après l'ajout
            questionInput.value = '';
        }
    });
});