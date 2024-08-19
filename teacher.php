<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'connection.php';

$teacherFetch = array('Status'=>false);

if(isset($_GET['fn'])) {
    if($_GET['fn']=="All") {
        $query = 'SELECT * From teachers';
        $teacherQuery = $conn->prepare($query);
        $teacherQuery->execute();
        $teacherFetch = array(
            'Status'=>true,
            'Data'=>$teacherQuery->fetchAll()
        );
    } else if($_GET['fn']=="Login") {
        if(isset($_GET['Username']) && isset($_GET['Password'])) {
            //Password MD5
            $query = 'SELECT * FROM teachers WHERE Username=:Username AND Password=MD5(:Password)';
            $teacherQuery = $conn->prepare($query);
            $teacherQuery->execute(array(
                ':Username'=>$_GET['Username'],
                ':Password'=>$_GET['Password']
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
} else if(isset($_GET['TeacherID'])) {
    $query = 'SELECT * From teachers Where TeacherID=:TeacherID';
    $teacherQuery = $conn->prepare($query);
    $teacherQuery->execute(array(
        ':TeacherID'=>$_GET['TeacherID']
    ));
    $teacherFetch = array(
        'Status'=>true,
        'Data'=>$teacherQuery->fetch(PDO::FETCH_ASSOC)
    );
}
echo json_encode($teacherFetch);
?>