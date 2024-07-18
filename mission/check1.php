<?php
    $conn = mysqli_connect('localhost', 'root', '', 'talk_on');
    if(mysqli_connect_errno()){
        echo 'MySQL 접속 실패 : '.mysqli_connect_error();
        exit();
    }
    if($_GET['ok']==1){
        $query = "update mission set isComplete='1' where mission_id=".$_GET['check'].";";
        $result = mysqli_query($conn, $query);
        $query = "update user set point=point+1 where id = '".$_GET['id']."';";
        $result = mysqli_query($conn, $query);
        echo "<script>alert('미션완료');</script>";
    }
    else{
        $query = "update mission set isComplete='0' where mission_id=".$_GET['check'].";";
        $result = mysqli_query($conn, $query);
        $query = "update user set point=point-1 where id = '".$_GET['id']."';";
        $result = mysqli_query($conn, $query);
        echo "<script>alert('미션취소');</script>";
    }
    
    echo "<script>location.href = 'mission.php?id=".$_GET['id']."'</script>";
?>