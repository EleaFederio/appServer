<?php

if ($_SERVER['REQUEST_METHOD']=='POST') {

    $studentId = $_POST['studentId'];
    $password = $_POST['password'];

    echo $studentId.' '.$password;

    require_once 'connect.php';

    $sql = "SELECT * FROM students WHERE studentId='$studentId' ";

    $response = mysqli_query($conn, $sql);

    $result = array();
    $result['login'] = array();
    
    if ( mysqli_num_rows($response) === 1 ) {
        
        $row = mysqli_fetch_assoc($response);

        if ( password_verify($password, $row['appPassword']) ) {
            
            $index['name'] = $row['firstName'].' '.$row['lastName'];
            $index['email'] = $row['email'];
            $index['studentId'] = $row['studentId'];

            array_push($result['login'], $index);

            $result['success'] = "1";
            $result['message'] = "success";
            echo json_encode($result);

            mysqli_close($conn);

        } else {

            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);

            mysqli_close($conn);

        }

    }

}

?>