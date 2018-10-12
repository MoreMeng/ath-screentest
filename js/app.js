'use strict';
const questions = [{
    question: "เห็นวงกลมในรูปกี่วง",
    choices: ["1 วง","2 วง","3 วง", "4 วง","5 วง"],
    correctAnswer: 3
}, {
    question: "เห็นวงกลมในรูปกี่วง",
    choices: ["1 วง","2 วง","3 วง", "4 วง","5 วง"],
    correctAnswer: 3
}, {
    question: "เฉดสีเรียงกันสม่ำเสมอหรือไม่",
    choices: ["ใช่", "ไม่ใช่"],
    correctAnswer: 0
}, {
    question: "มีแท่งสีจำนวนกี่แท่ง เฉดสีดำ-ขาว",
    choices: ["19 แท่ง", "20 แท่ง", "21 แท่ง", "22 แท่ง", "23 แท่ง"],
    correctAnswer: 2
}];
let questionCounter = 0; //Tracks question number
let selections = []; //Array containing user choices
const quiz = $('#quiz'); //Quiz div object
// Display initial question
displayNext();
// Click handler for the 'next' button
$('#next').on('click', function (e) {
    e.preventDefault();
    // Suspend click listener during fade animation
    if (quiz.is(':animated')) {
        return false;
    }
    choose();
    // If no user selection, progress is stopped
    if (isNaN(selections[questionCounter])) {
        swal("อ๊ะ!", "กรุณาเลือกคำตอบก่อนนะครับ", "warning", {
            button: "ปิด",
            dangerMode: true
        });
    } else {
        questionCounter++;
        displayNext();
    }
});
// Click handler for the 'prev' button
$('#prev').on('click', function (e) {
    e.preventDefault();
    if (quiz.is(':animated')) {
        return false;
    }
    choose();
    questionCounter--;
    displayNext();
});
// Click handler for the 'Start Over' button
$('#start').on('click', function (e) {
    e.preventDefault();
    if (quiz.is(':animated')) {
        return false;
    }
    questionCounter = 0;
    selections = [];
    displayNext();
    $('#start').hide();
});

$('#submit').on('click', function (e) {
    e.preventDefault();

    let numCorrect = 0;

    for (let i = 0; i < selections.length; i++) {
        if (selections[i] === questions[i].correctAnswer) {
            numCorrect++;
        }
    }

    var jqxhr = $.post('insert.php', {
        score: numCorrect,
        name: $('#name').val(),
        monitor: $('#monitor').val(),
        section: $('#section').val()
    }, function () {

        // console.log(">"+id+':'+fid+':'+fname+':'+note);
    }).done(function () {

        swal({
                title: "All done!",
                icon: "success",
                // text: "บันทึกสำเร็จ",
                text: jqxhr.responseText,
                timer: 2000,
                button: false
            })
            .then(() => {
                window.location.href = "../";
            });

    }).fail(function (data) {
        if (data.responseText !== '') {
            swal({
                title: jqxhr.responseText,
                icon: 'warning',
                buttons: {
                    cancel: true
                }
            });
        } else {
            swal("Oops!", 'Oops! Something went wrong and we couldn\'t send your message', 'error');
        }
    });

    $('#quiz,#start,#start').hide();

    // $('#sent').show();

    // setTimeout(window.open("http://ath4/", "_self"), 3000);


});

$('.select2').select2({
    theme: 'bootstrap'
});
// Creates and returns the div that contains the questions and
// the answer selections
function createQuestionElement(index) {
    var qElement = $('<div>', {
        id: 'question'
    });
    var header = $('<div class="stick"><span class="label label-default">Question ' + (index + 1) +
        ':</span></div>');
    qElement.append(header);
    var header = $('<div id="q' + (index + 1) + '"></div>');
    qElement.append(header);
    var question = $('<h2>').append(questions[index].question);
    qElement.append(question);
    var radioButtons = createRadios(index);
    qElement.append(radioButtons);
    return qElement;
}
// Creates a list of the answer choices as radio inputs
function createRadios(index) {
    var radioList = $('<div class="btn-group btn-group-md" data-toggle="buttons">');
    var item;
    var input = '';
    for (var i = 0; i < questions[index].choices.length; i++) {
        item = $('<label class="btn btn-danger">');
        input = '<input type="radio" name="answer" value=' + i + ' />';
        input += questions[index].choices[i];
        item.append(input);
        radioList.append(item);
    }
    return radioList;
}
// Reads the user selection and pushes the value to an array
function choose() {
    selections[questionCounter] = +$('input[name="answer"]:checked').val();
}
// Displays next requested element
function displayNext() {
    quiz.fadeOut(function () {
        $('#question').remove();
        $('#send').hide();
        $('#sent').hide();
        if (questionCounter < questions.length) {
            var nextQuestion = createQuestionElement(questionCounter);
            quiz.append(nextQuestion).fadeIn();
            if (!(isNaN(selections[questionCounter]))) {
                $('input[value=' + selections[questionCounter] + ']').prop('checked', true);
            }
            // Controls display of 'prev' button
            if (questionCounter === 1) {
                $('#prev').show();
            } else if (questionCounter === 0) {
                $('#prev').hide();
                $('#next').show();
            }
        } else {
            var scoreElem = displayScore();
            quiz.append(scoreElem).fadeIn();
            $('#send,#start').show();
            $('#name').focus();
            $('#next,#prev').hide();
            getBackground(el);
        }
    });
}
// Computes score and returns a paragraph element to be displayed
function displayScore() {
    let score = $('<h1>', {
        id: 'question'
    });
    let numCorrect = 0;
    for (let i = 0; i < selections.length; i++) {
        if (selections[i] === questions[i].correctAnswer) {
            numCorrect++;
        }
    }
    // score.append('You got ' + numCorrect + ' questions out of ' + questions.length + ' right!!!');
    score.addClass('white').append('ขอบคุณสำหรับการทำแบบทดสอบ');
    return score;
}