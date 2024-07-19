<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'connection.php';

$courseFetch = array('Status'=>false);

if(isset($_GET['fn'])) {
    if($_GET['fn']=="All") {
        $query = 'SELECT * From course';
        //$courseQuery = $conn->query($query);
        $courseQuery = $conn->prepare($query);
        $courseQuery->execute();
        $courseFetch = array(
            'Status'=>true,
            'Data'=>$courseQuery->fetchAll()
        );
    }
} else if(isset($_GET['CourseID'])) {
    $query = 'SELECT * From course Where CourseID=:CourseID';
    $courseQuery = $conn->prepare($query);
    $courseQuery->execute(array(
        ':CourseID'=>$_GET['CourseID']
    ));
    $courseFetch = array(
        'Status'=>true,
        'Data'=>$courseQuery->fetch(PDO::FETCH_ASSOC)
    );
} else if(isset($_GET['CourseName'])) {
    $query = 'SELECT * From course Where CourseName like :CourseName';
    $courseQuery = $conn->prepare($query);
    $courseQuery->execute(array(
        ':CourseName'=>'%'.$_GET['CourseName'].'%'
    ));
    $courseFetch = array(
        'Status'=>true,
        'Data'=>$courseQuery->fetch(PDO::FETCH_ASSOC)
    );
}
echo json_encode($courseFetch);
?>