<div class="tab-pane fade" id="mcq-tab" role="tabpanel">
    <h1 class="h2 pt-xl-1 mb-4 pb-2 border-bottom" style="color:#3e4265;">MCQ <span class="text-primary">Questions</span></h1>
    <div class="mb-4 card card-body">
        <style>
            .none {
                display: none;
            }
        </style>

        <div id="questions"></div>
        <div class="d-flex justify-content-between">
            <button class="btn btn-danger btn-sm prev-quiz" type="button" disabled> Prev </button>
            <button class="btn btn-success btn-sm next-quiz" type="button"> Next </button>
        </div>
    </div>

</div>

<script>
    let quesCount = 0;
    async function manageQuestions(payload) {
        try {
            const res = await $.post('manageQuiz.php', payload);
            return (res);
        } catch (error) {
            console.log(error, "quiz error");
            return false;
        }
    }
    const makeQuestion = (question, quesNo) => {
        return ` <div class="d-flex flex-row align-items-center question-title mb-3">
          
            <h5 class="mt-1 ml-2"><span class="text-danger">Q. ${quesNo} </span>&nbsp; ${question}</h5>
        </div>`;
    }

    const makeOptions = (options, parent, prevAns) => {
        options = JSON.parse(options) ?? {};
        const ansDiv = document.createElement('div');
        ansDiv.classList.add('ms-auto', 'mb-3');

        Array.from(Object.values(options)).map((option, index) => {
            if (!option.trim()) return;

            const radioValue = ++index;
            const label = document.createElement('label');
            label.classList.add('radio', 'w-100');
            if (prevAns && prevAns == radioValue)
                label.innerHTML = ` <input type="radio" name="quizAns" class="ans" checked value="${radioValue}"> <span class="option">${option}</span>`;
            else
                label.innerHTML = ` <input type="radio" name="quizAns" class="ans" value="${radioValue}"> <span class="option">${option}</span>`;
            ansDiv.append(label);
        })
        parent.append(ansDiv);
    }
    async function loadQuest(quesId, programId, type, saveQuiz = false) {
        const mainDiv = document.querySelector('#questions');
        // fuzzyLoading(true);


        if (saveQuiz) {
            const radio = document.querySelector('input[name="quizAns"]:checked');
            if (radio == null) {
                alert('Please select ans');
                return;
            }
            saveQuiz = radio.value;
        }
        mainDiv.innerHTML = '';
        if (type == 'next') quesCount++;
        else quesCount--;

        const data = await manageQuestions({
            quesId,
            programId,
            type,
            saveQuiz,
            reportId
        });
        console.log(data);
        if (!data) {
            alert('No quiz found\nThanks for participating');
            return;
        }
        // fuzzyLoading(false);
        const jsonData = JSON.parse(data);
        console.log(jsonData, jsonData.question);
        mainDiv.innerHTML = makeQuestion(jsonData.question, quesCount);

        makeOptions(jsonData.options, mainDiv, jsonData.prevAns);


        console.log("quizId", jsonData.id);

        mainDiv.setAttribute('data-quiz-id', jsonData.id);
        if (type == 'next' && !jsonData.next) {
            document.querySelector('.next-quiz').innerText = "Submit";
        }
        if ((type == 'prev' && !jsonData.prev) || quesCount == 1) {
            document.querySelector('.prev-quiz').disabled = true;
        }
        if (jsonData.prev && quesCount > 1)
            document.querySelector('.prev-quiz').disabled = false;
    }
    document.addEventListener('DOMContentLoaded', () => {
        loadQuest(0, '<?php echo 1 ?>', 'next');
    })
    document.querySelector('.next-quiz').addEventListener('click', function() {
        const mainDiv = document.querySelector('#questions');
        const quizId = mainDiv.dataset.quizId;
        if (this.innerText == 'Submit') {

            submitQuiz();


        } else {
            loadQuest(quizId, '<?php echo 1 ?>', 'next', true);
        }


    })
    document.querySelector('.prev-quiz').addEventListener('click', () => {
        const mainDiv = document.querySelector('#questions');
        const quizId = mainDiv.dataset.quizId;
        console.log(quizId, "adsa");
        loadQuest(quizId, '<?php echo 1 ?>', 'prev');

    });

    async function submitQuiz() {
        const data = await manageQuestions({
            getMarks: reportId
        });
        console.log(data);
        if (!data) {
            alert('No Result Found\nThanks for participating');
            return;
        }
        const jsonData = JSON.parse(data);
        console.log(jsonData);

        document.getElementById('mcq-tab').classList.remove('show', 'active');
        document.getElementById('studentResult-tab').classList.add('show', 'active');
        document.getElementById('student_marks').innerText = jsonData.crtAnswer
        if (jsonData.crtAnswer > 12) {
            document.getElementById('student_result').innerText = 'Pass'
            document.getElementById('student_result').classList.add('text-success');
            document.getElementById('join_discord').innerText = 'For the further assignment you can reach out to us over discord & training@jobaaj.com'

        } else {
            document.getElementById('student_result').innerText = 'Fail'
            document.getElementById('student_result').classList.add('text-danger');
        }
    }
</script>