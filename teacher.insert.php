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
    if($body->fn=="Insert") {
        $query='INSERT Into teachers(TeacherName, Username, Password, isAdmin) Value (:TeacherName, :Username, md5(:Password), :isAdmin)';
        $teacherInsert = $conn->prepare($query);
        $teacherInsert->execute(array(
            ':TeacherName'=>$body->TeacherName,
            ':Username'=>$body->Username,
            ':Password'=>$body->Password,
            ':isAdmin'=>$body->isAdmin
        ));
        if($teacherInsert->rowCount()>0) {
            $teacherFetch = array(
                'Status'=>true,
                'Data'=>$conn->lastInsertId()
            );
        }
    }
}
echo json_encode($teacherFetch);
?>