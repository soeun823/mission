<?php
    $conn = mysqli_connect('localhost', 'root', '', 'talk_on');
    if (mysqli_connect_errno()) {
        echo 'MySQL 접속 실패 : ' . mysqli_connect_error();
        exit();
    }
    if($_GET['ok']==1){
        echo "<script>alert('이미 진행중인 게임이 있습니다.');</script>";
        echo "<script>location.href = 'setting.php?id=".$_GET['id']."'</script>";
    }
    $query = "select group_id from user where id='".$_GET['id']."';";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $team = $row['group_id'];
    

    $query = "insert into game(famliy_id, startdate, deadline, mission_count, winner, loser) values(".$team.",'".$_POST['date1']."', '".$_POST['date2']."', ".$_POST['value'].", '".$_POST['win']."', '".$_POST['lose']."');";
    $result = mysqli_query($conn, $query);
    if($result){
        echo "<script>alert('게임을 생성하였습니다.');</script>";
        echo "<script>location.href = 'setting.php?id=".$_GET['id']."'</script>";
    }
?>