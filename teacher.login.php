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
    if($body->fn=="Login") {
        if(isset($body->Username) && isset($body->Password)) {
            //Password MD5
            $query = 'SELECT * FROM teachers WHERE Username=:Username AND Password=MD5(:Password)';
            $teacherQuery = $conn->prepare($query);
            $teacherQuery->execute(array(
                ':Username'=>@$body->Username,
                ':Password'=>@$body->Password
            ));
            if($teacherQuery->rowCount()>0) {
                $teacherFetch = array(
                    'Status'=>true,
                    'Data'=>$teacherQuery->fetch(PDO::FETCH_ASSOC)
                );
            } else {
                $teacherFetch = array(
                    'Status'=>false
                );
            }
        }
    }
}
echo json_encode($teacherFetch);
?>