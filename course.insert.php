<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'connection.php';

$postData = file_get_contents("php://input");
$param = json_decode($postData);

$query = 'INSERT Into course(CourseID, CourseName, Credits) Values (:CourseID, :CourseName, :Credits)';
$courseInsert = $conn->prepare($query);
$courseInsert->execute(array(
    ':CourseID' => $_POST['CourseID'],
    ':CourseName' => $_POST['CourseName'],
    ':Credits' => $_POST['Credits']
));

if($courseInsert->rowCount() > 0) {
    $respond = array(
        'Status' => true,
        'Id'=> $_POST['CourseID']
    );
} else {
    $respond = array('Status' => false);
}
echo json_encode($respond);
?>