document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('add-question').addEventListener('click', function() {
        var questionList = document.getElementById('questions');
        var newQuestionItem = document.createElement('div');
        newQuestionItem.className = 'mb-3';

        var questionHeader = document.createElement('div');
        questionHeader.className = 'mb-3';
        questionHeader.innerHTML = '<label class="form-label">Question</label>' +
                                   '<input type="text" class="form-control" name="questions[new_' + questionList.children.length + '][question]" required>';

        var goodResponseInput = document.createElement('div');
        goodResponseInput.className = 'mb-3';
        goodResponseInput.innerHTML = '<label class="form-label">Bonne réponse</label>' +
                                      '<input type="text" class="form-control" name="questions[new_' + questionList.children.length + '][good_response]" required>';

        var badResponsesInput = document.createElement('div');
        badResponsesInput.className = 'mb-3';
        badResponsesInput.innerHTML = '<label class="form-label">Mauvaises réponses (séparées par des virgules)</label>' +
                                      '<input type="text" class="form-control" name="questions[new_' + questionList.children.length + '][bad_responses]" required>';

        var pointInput = document.createElement('div');
        pointInput.className = 'mb-3';
        pointInput.innerHTML = '<label class="form-label">Points</label>' +
                               '<input type="number" class="form-control" name="questions[new_' + questionList.children.length + '][point]" value="1" required>';

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
    });
});