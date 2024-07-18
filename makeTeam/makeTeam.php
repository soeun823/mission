<?php
    $conn = mysqli_connect('localhost', 'root', '', 'talk_on');
    if(mysqli_connect_errno()){
        echo 'MySQL 접속 실패 : '.mysqli_connect_error();
        exit();
    }

    $query = "update user set group_id where id = '".$_POST['id']."'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    if($row['group_id']!=NULL)
        echo "<script>alert('가족 추가가 되었습니다!');</script>";
    else 
        echo "<script>alert('가족 추가에 실패하였습니다!);</script>";
?>