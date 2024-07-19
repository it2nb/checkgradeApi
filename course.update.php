<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'connection.php';

$postData = file_get_contents("php://input");
$param = json_decode($postData);

$n = 0;
$bind = array();

$query = 'UPDATE course Set ';

if(isset($_POST['CourseName'])) {
    $query .= 'CourseName=:CourseName';
    $bind[':CourseName'] = $_POST['CourseName'];
    $n = 1;
}

if(isset($_POST['Credits'])) {
    if($n==1)
        $query .= ',';
    $query .= 'Credits=:Credits';
    $bind[':Credits'] = $_POST['Credits'];
    $n = 1;
}

if(isset($_POST['newCourseID'])) {
    if($n==1)
        $query .= ',';
    $query .= 'CourseID=:newCourseID';
    $bind[':newCourseID'] = $_POST['newCourseID'];
    $n = 1;
}

$query .=' Where CourseID=:CourseID';
$bind[':CourseID'] = @$_POST['CourseID'];

$courseUpdate = $conn->prepare($query);
$courseUpdate->execute($bind);

if($courseUpdate->rowCount() > 0) {
    echo json_encode(array('Status'=>true));
} else {
    echo json_encode(array('Status'=>false));
}
?>