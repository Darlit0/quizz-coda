document.addEventListener('DOMContentLoaded', function() {
    const questionsList = document.getElementById('questions');

    function updateQuestionNumbers() {
        const questionItems = questionsList.children;
        for (let i = 0; i < questionItems.length; i++) {
            const questionHeader = questionItems[i].querySelector('.question-header');
            if (questionHeader) {
                questionHeader.textContent = 'Question N°' + (i + 1);
            }
        }
    }

    document.getElementById('add-question').addEventListener('click', function() {
        var newQuestionItem = document.createElement('li');
        newQuestionItem.className = 'list-group-item mb-3';

        var questionHeader = document.createElement('div');
        questionHeader.className = 'question-header mb-3';
        questionHeader.textContent = 'Question N°' + (questionsList.children.length + 1);

        var questionInput = document.createElement('div');
        questionInput.className = 'mb-3';
        questionInput.innerHTML = '<label class="form-label">Question</label>' +
                                  '<input type="text" class="form-control" name="questions[new_' + questionsList.children.length + '][question]" required>';

        var goodResponseInput = document.createElement('div');
        goodResponseInput.className = 'mb-3';
        goodResponseInput.innerHTML = '<label class="form-label">Bonne réponse</label>' +
                                      '<input type="text" class="form-control" name="questions[new_' + questionsList.children.length + '][good_response]" required>';

        var badResponsesInput = document.createElement('div');
        badResponsesInput.className = 'mb-3';
        badResponsesInput.innerHTML = '<label class="form-label">Mauvaises réponses (séparées par des virgules)</label>' +
                                      '<input type="text" class="form-control" name="questions[new_' + questionsList.children.length + '][bad_responses]" required>';

        var pointsInput = document.createElement('div');
        pointsInput.className = 'mb-3';
        pointsInput.innerHTML = '<label class="form-label">Points</label>' +
                                '<input type="number" class="form-control" name="questions[new_' + questionsList.children.length + '][point]" required>';

        var categoryInput = document.createElement('div');
        categoryInput.className = 'mb-3';
        categoryInput.innerHTML = '<label class="form-label">Catégorie</label>' +
                                  '<select class="form-control" name="questions[new_' + questionsList.children.length + '][category_id]" required>' +
                                  categoriesOptionsHtml + '</select>';

        newQuestionItem.appendChild(questionHeader);
        newQuestionItem.appendChild(questionInput);
        newQuestionItem.appendChild(goodResponseInput);
        newQuestionItem.appendChild(badResponsesInput);
        newQuestionItem.appendChild(pointsInput);
        newQuestionItem.appendChild(categoryInput);

        questionsList.appendChild(newQuestionItem);
        updateQuestionNumbers();
    });

    updateQuestionNumbers();
});