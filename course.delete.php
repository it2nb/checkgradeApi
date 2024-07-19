<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'connection.php';

$postData = file_get_contents("php://input");
$param = json_decode($postData);

if(isset($_POST['CourseID'])) {
    $query = 'DELETE From course Where CourseID=:CourseID';
    $courseDelete = $conn->prepare($query);
    $courseDelete->execute(array(
        ':CourseID' => $_POST['CourseID']
    ));

    if($courseDelete->rowCount() > 0) {
        echo json_encode(array('Status'=>true));
    } else {
        echo json_encode(array('Status'=>false));
    }
} else {
    echo json_encode(array('Status'=>false));
}
?>