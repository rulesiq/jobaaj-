<?php
require '../config.php';


if (isset($_POST['quesId'])) {


    $quesId = $_POST['quesId'];
    $programId = $_POST['programId'];
    $type = $_POST['type'];
    $reportId = $_POST['reportId'];



    if ($type == "next") {

        $sql = mysqli_query($db, "select id,question,options from mcqquiz where id > '$quesId' and program='$programId' order by id asc limit 1");
        if (mysqli_num_rows($sql) > 0) {

            $data = mysqli_fetch_assoc($sql);

            $sql_check = mysqli_query($db, "select id,question,options from mcqquiz where id > '$data[id]' and program='$programId' order by id asc limit 1");
            $data['next'] = mysqli_num_rows($sql_check) > 0 ? true : false;
            $data['prev'] = true;
            $ans = 0;
            if (isset($_POST['saveQuiz']) and $_POST['saveQuiz'] != "false") {

                $report = mysqli_fetch_assoc(mysqli_query($db, "select quiz_report from student_quiz_ans where id = '$reportId'"))['quiz_report'];
                $correct_ans = mysqli_fetch_assoc(mysqli_query($db, "select correct_answer from mcqquiz where id = '$quesId'"))['correct_answer'];
                $report = json_decode($report, true) ?? array();

                $add = true;
                foreach ($report as $key => $sub_report) {
                    if ($sub_report['quesId'] == $data['id']) {
                        $ans = $sub_report['ans'];
                    }

                    if ($sub_report['quesId'] == $quesId) {
                        $sub_report['ans']  = $_POST['saveQuiz'];
                        $sub_report['isCorrect']  =  $_POST['saveQuiz'] == $correct_ans ? true : false;
                        $report[$key] = $sub_report;
                        $add = false;
                    }
                }
                if ($add)
                    $report[] = array(
                        "quesId" => $quesId,
                        "ans" => $_POST['saveQuiz'],
                        "isCorrect" => $_POST['saveQuiz'] == $correct_ans ? true : false
                    );
                $report = json_encode($report);

                mysqli_query($db, "UPDATE `student_quiz_ans` SET `quiz_report` = '$report' where id = '$reportId'");
            }
            $data['prevAns'] = $ans;

            echo json_encode(
                $data
            );
        } else {
            echo http_response_code(500);
        }
    } else if ($type == "prev") {
        $sql = mysqli_query($db, "select id,question,options from mcqquiz where id < '$quesId' and program='$programId' order by id desc  limit 1");
        if (mysqli_num_rows($sql) > 0) {

            $data = mysqli_fetch_assoc($sql);

            $sql_check = mysqli_query($db, "select id,question,options from mcqquiz where id < '$data[id]' and program='$programId' order by id asc limit 1");
            $data['prev'] = mysqli_num_rows($sql_check) > 0 ? true : false;
            $data['next'] = true;

            $report = mysqli_fetch_assoc(mysqli_query($db, "select quiz_report from student_quiz_ans where id = '$reportId'"))['quiz_report'];
            $report = json_decode($report, true) ?? array();
            $ans = 0;
            foreach ($report as $key => $sub_report) {
                if ($sub_report['quesId'] == $data['id']) {
                    $ans = $sub_report['ans'];
                    break;
                }
            }
            $data['prevAns'] = $ans;
            echo json_encode(
                $data
            );
        } else {
            echo "select id,question,options from mcqquiz where id < '$quesId' and program='$programId' order by id desc  limit 1";
            // echo http_response_code(500);
        }
    }
}


if (isset($_POST['getMarks'])) {
    $reportId = $_POST['getMarks'];
    $sql = mysqli_fetch_assoc(mysqli_query($db, "SELECT quiz_report FROM `student_quiz_ans` where id= '$reportId' limit 1 "));
    $dataArray = json_decode($sql['quiz_report'], true);

    $trueCount = 0;
    foreach ($dataArray as $item) {
        if (isset($item['isCorrect']) && $item['isCorrect'] === true) {
            $trueCount++;
        }
    }
    echo json_encode([
        "crtAnswer" => $trueCount
    ]);
}
