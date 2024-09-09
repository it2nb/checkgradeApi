<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'connection.php';

$postData = file_get_contents("php://input");
$body = json_decode($postData);

$teacherFetch = array('Status'=>false);

if(isset($body->fn)) {
    if($body->fn=="Delete") {
        $query='';
        $teacherDelete = $conn->prepare($query);
        $teacherDelete->execute(array(
            ':TeacherID'=>$body->TeacherID
        ));
        if($teacherDelete->rowCount()>0) {
            $teacherFetch = array(
                'Status'=>true
            );
        }
    }
}
echo json_encode($teacherFetch);
?>