<?php
session_start();
// error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require realpath('../dv-config.php');
require DEV_PATH . '/classes/db.class.v2.php';
require DEV_PATH . '/functions/global.php';


// define("starttime", getmicrotime());
$GET_DEV = (empty($_GET['dev'])) ? null : $_GET['dev'];
// $GET_NUMBER = (isset($_GET['number'])) ? $_GET['number'] : '';
// $GET_MODE = (isset($_GET['mode'])) ? $_GET['mode'] : null;
// $GET_ID = (isset($_GET['id'])) ? $_GET['id'] : null;

define('Q_VERSION', '1.0.0');

$dept = CON::selectArrayDB(array(),"SELECT sec_id,sec_code,sec_name FROM ath_department_section ORDER BY sec_name");
?>

<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monitor Calibration Graphic</title>
    <!-- CORE CSS -->
    <link rel="stylesheet" href="<?php echo ASSET_PATH; ?>/bootswatch/flatly/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo ASSET_PATH; ?>/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo ASSET_PATH; ?>/fonts/maledpan/maledpan.css">
    <link rel="stylesheet" href="<?php echo ASSET_PATH; ?>/fonts/chatthai/chatthai.css">
    <link rel="stylesheet" href="<?php echo ASSET_PATH; ?>/sweetalert-lastest/dist/sweetalert.css">
    <link rel="stylesheet" href="<?php echo ASSET_PATH; ?>/select2/dist/css/select2.css">
    <link rel="stylesheet" href="<?php echo ASSET_PATH; ?>/select2-bootstrap-theme/dist/select2-bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/screentest.css?v=<?php echo filemtime('css/screentest.css'); ?>">
    <?php if (!in_array($GET_DEV, array('','view','report'))) : ?>
    <link rel="stylesheet" href="<?php echo ASSET_PATH; ?>/datatables/media/css/dataTables.bootstrap.min.css">
    <?php elseif ($GET_DEV == 'report') : ?>
    <!-- <link rel="stylesheet" href="<?php echo ASSET_PATH; ?>/morris.js/morris.css"> -->
    <?php endif; ?>
</head>

<body>
    <div id="wrapper">
        <div id='quiz'></div>

        <nav>
            <ul class="pager">
                <li> <a id="prev" href='#'>Prev</a> </li>
                <li> <a id="next" href='#'>Next</a> </li>
            </ul>
        </nav>

        <div id="send" class="container-fluid">
            <div class="col-xs-4 col-xs-offset-4 well well-lg">

                <form action="" method="POST" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input class="form-control" type="text" id="name" name="name" placeholder="ชื่อ-นามสกุล ผู้ทำการทดสอบ">
                    </div>
                    <div class="form-group">
                        <label for="monitor">Monitor:</label>
                        <input class="form-control" type="text" id="monitor" name="monitor" placeholder="ยี่ห้อ รุ่น ของหน้าจอ ตัวอย่าง: Acer X193HQ A">
                    </div>
                    <div class="form-group">
                        <label for="section">Section:</label>
                        <select class="form-control select2" name="section" id="section">
                            <?php echo dropdown( $dept, null, 'sec_id', 'sec_name'); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <button id="Enter" type="button" class="btn btn-primary">บันทึกผลการทดสอบ</button>
                        </div>
                    </div>
                </form>
                <!-- <ul class="pager">
                <li><a id="start" href='#'>Start Over</a></li>
            </ul> -->
            </div>
        </div>
        <div id="sent">
            <h2>ส่งข้อมูลแล้ว</h2>
        </div>
    </div>

    <script src="<?php echo ASSET_PATH; ?>/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo ASSET_PATH; ?>/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo ASSET_PATH; ?>/select2/dist/js/select2.min.js"></script>
    <script src="<?php echo ASSET_PATH; ?>/sweetalert2/dist/sweetalert.min.js"></script>


    <script>
        $(function () {
            'use strict';
            const questions = [{
                question: "เห็นวงกลมในรูปกี่วง",
                choices: ["3 วง", "4 วง"],
                correctAnswer: 1
            }, {
                question: "เห็นวงกลมในรูปกี่วง",
                choices: ["3 วง", "4 วง"],
                correctAnswer: 1
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
                    swal("อ๊ะ!", "กรุณาเลือกคำตอบก่อนนะครับ", "warning",{button: "ปิด", dangerMode: true});
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

            $('#Enter').on('click', function () {
                var numCorrect = 0;
                for (var i = 0; i < selections.length; i++) {
                    if (selections[i] === questions[i].correctAnswer) {
                        numCorrect++;
                    }
                }


                $.ajax({
                    url: "insert.php?score=" + numCorrect + "&name=" + name.value + "&monitor=" +
                        monitor.value + "&section=" + section.value,
                    type: 'post',
                    dataType: 'html'
                });
                $('#send,#quiz,#start,#start').hide();

                $('#sent').show();

                setTimeout(window.open("http://ath4/", "_self"), 3000);


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
                        $('#send').show();
                        $('#name').focus();
                        $('#next').hide();
                        $('#prev').hide();
                        $('#start').show();
                    }
                });
            }
            // Computes score and returns a paragraph element to be displayed
            function displayScore() {
                var score = $('<h1>', {
                    id: 'question'
                });
                var numCorrect = 0;
                for (var i = 0; i < selections.length; i++) {
                    if (selections[i] === questions[i].correctAnswer) {
                        numCorrect++;
                    }
                }
                // score.append('You got ' + numCorrect + ' questions out of ' + questions.length + ' right!!!');
                score.append('ขอบคุณสำหรับการทำแบบทดสอบ');
                return score;
            }
        });
    </script>
</body>

</html>