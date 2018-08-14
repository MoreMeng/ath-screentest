<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monitor Calibration Graphic V1.0</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/3.3.7/flatly/bootstrap.min.css" rel="stylesheet" integrity="sha384-+ENW/yibaokMnme+vBLnHMphUYxHs34h9lpdbSLuAwGkOKFRl4C34WkjazBtb7eT"
        crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <style>
        #q1 {
            width: 100%;
            height: 450px;
            background: rgb(0, 0, 0);
            background: radial-gradient(circle, rgba(0, 0, 0, 1) 0%, rgba(0, 0, 0, 1) 5%, rgba(13, 13, 13, 1) 5%, rgba(13, 13, 13, 1) 10%, rgba(26, 26, 26, 1) 10%, rgba(26, 26, 26, 1) 20%, rgba(38, 38, 38, 1) 20%, rgba(38, 38, 38, 1) 30%, rgba(64, 64, 64, 1) 30%, rgba(64, 64, 64, 1) 100%);
        }
        #q2 {
            width: 100%;
            height: 450px;
            background: rgb(255, 255, 255);
            background: radial-gradient(circle, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 1) 5%, rgba(242, 242, 242, 1) 5%, rgba(242, 242, 242, 1) 10%, rgba(230, 230, 230, 1) 10%, rgba(230, 230, 230, 1) 20%, rgba(217, 217, 217, 1) 20%, rgba(217, 217, 217, 1) 30%, rgba(230, 230, 230, 1) 30%, rgba(220, 220, 220, 1) 100%);
        }
        #q3 {
            width: 100%;
            height: 450px;
            background: rgb(0, 0, 0);
            background: linear-gradient(90deg, rgba(0, 0, 0, 1) 0%, rgba(255, 255, 255, 1) 100%);
        }
        #q4 {
            width: 100%;
            height: 450px;
            background: rgb(0, 0, 0);
            background: linear-gradient(90deg,
            rgba(0, 0, 0, 1) 0%, rgba(0, 0, 0, 1) 4.76%, rgba(13, 13, 13, 1) 4.76%, rgba(13, 13, 13, 1) 9.52%, rgba(26, 26, 26, 1) 9.52%, rgba(26, 26, 26, 1) 14.29%, rgba(38, 38, 38, 1) 14.29%, rgba(38, 38, 38, 1) 19.05%, rgba(51, 51, 51, 1) 19.05%, rgba(51, 51, 51, 1) 23.81%, rgba(64, 64, 64, 1) 23.81%, rgba(64, 64, 64, 1) 28.57%, rgba(77, 77, 77, 1) 28.57%, rgba(77, 77, 77, 1) 33.33%, rgba(89, 89, 89, 1) 33.33%, rgba(89, 89, 89, 1) 38.10%, rgba(102, 102, 102, 1) 38.10%, rgba(102, 102, 102, 1) 42.86%, rgba(115, 115, 115, 1) 42.86%, rgba(115, 115, 115, 1) 47.62%, rgba(128, 128, 128, 1) 47.62%, rgba(128, 128, 128, 1) 52.38%, rgba(140, 140, 140, 1) 52.38%, rgba(140, 140, 140, 1) 57.14%, rgba(153, 153, 153, 1) 57.14%, rgba(153, 153, 153, 1) 61.90%, rgba(166, 166, 166, 1) 61.90%, rgba(166, 166, 166, 1) 66.67%, rgba(179, 179, 179, 1) 66.67%, rgba(179, 179, 179, 1) 71.43%, rgba(191, 191, 191, 1) 71.43%, rgba(191, 191, 191, 1) 76.19%, rgba(204, 204, 204, 1) 76.19%, rgba(204, 204, 204, 1) 80.95%, rgba(217, 217, 217, 1) 80.95%, rgba(217, 217, 217, 1) 85.71%, rgba(230, 230, 230, 1) 85.71%, rgba(230, 230, 230, 1) 90.48%, rgba(242, 242, 242, 1) 90.48%, rgba(242, 242, 242, 1) 95.24%, rgba(255, 255, 255, 1) 95.24%, rgba(255, 255, 255, 1) 100.00%);
        }
        #quiz {
            text-align: center;
            display: none;
        }
        #prev,
        #start {
            display: none;
        }
        .stick {
            position: absolute;
            left: 1%;
            top: 0;
        }
        label.btn {
            padding: 8px 40px;
        }
        th{
            text-align:center;
        }
    </style>
</head>
<body>
    <?php include 'connect.php'; ?>
    <div id="wrapper">
        <div id='quiz'></div>
        
        <nav>
            <ul class="pager">
                <li>
                    <a id="prev" href='#'>Prev</a>
                </li>
                <div id="send" class="container">
                        <table class="table table-hover" >
                            <tr>
                                <th>Name : </th><td><input class="form-control"  type="text" id="namee" name="namee" autocomplete="off"></td>
                            </tr>
                            <tr>
                                <th>Monitor :</th><td><input class="form-control"  type="text" id="monitor" name="monitor" autocomplete="off"></td>
                            </tr>
                            <tr>
                                <th>Section :</th><td>
                                        <select class="js-example-basic-single" name="section" id="section" style="width: 100%" >
                                                <?php
                                                    $sql = "SELECT sec_id,sec_code,sec_name FROM ath_department_section";
                                                    $result3=mysqli_query($conn,$sql);
                                        
                                                    if ($result3->num_rows > 0) {
                                                        
                                                        while($row1 = $result3->fetch_assoc()) {
                                                            echo " <option value='".$row1['sec_id']."'>".$row1['sec_code']." - ".$row1['sec_name']."</option>";
                                            
                                                        }
                                                    } else {
                                                        echo "0 results";
                                                    }   
                                                ?>
                                                </select>
                                </td>
                            </tr>
                        </table>
                        <ul class="pager">
                                    <li>
                                        <a id="Enter"  href='#'>Send</a>
                                    </li>
                                    <li>
                                        <a id="start" href='#'>Start Over</a>
                                    </li>
                            </ul>
                    </div>
                    <div id="sent">
                        <h2>ส่งข้อมูลแล้ว</h2>
                    </div>
                <li>
                    <a id="next" href='#'>Next</a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.1/js/select2.full.min.js"></script>
        <script>
        $(document).ready(function() {
            $(".js-example-basic-single").select2();
        });
        </script>

    <!-- Bootstrap JavaScript -->
    <script>
        (function () {
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
                    alert('Please make a selection!');
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
                url: "insert1.php?score="+numCorrect+"&name="+namee.value+"&monitor="+monitor.value+"&section="+section.value,
                type: 'post',
                dataType: 'html'
                });
                $('#send').hide();
                $('#quiz').hide();
                $('#start').hide();
                

                $('#start').hide();
                $('#sent').show();

                setTimeout(window.open("http://ath4/","_self"),3000);
                
                
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
                score.append('You got ' + numCorrect + ' questions out of ' +
                    questions.length + ' right!!!');
                return score;
            }
        })();
    </script>
</body>
</html>