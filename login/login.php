<?php
    $conn = mysqli_connect('localhost', 'root', '', 'talk_on');
    if(mysqli_connect_errno()){
        echo 'MySQL 접속 실패 : '.mysqli_connect_error();
        exit();
    }

    $query = "select name, id, password from user where id='".$_POST['id']."' and password='".$_POST['password']."';";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if($row['name']){
        echo "<script>alert('로그인 성공');</script>";
        echo "<script>location.href='../homepage/homepage.php?id=".$row['id']."'</script>";
    }
    else{
        echo "<script>alert('아이디나 비밀번호가 잘못되었습니다.')</script>";
        echo "<script>history.back();</script>";
    }
?>