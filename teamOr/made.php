<?php
    $conn = mysqli_connect('localhost', 'root', '', 'talk_on');
    if (mysqli_connect_errno()) {
        echo 'MySQL 접속 실패 : ' . mysqli_connect_error();
        exit();
    }
    
    $str='["';
    for($i=0;$i<$_POST['count'];$i++){
        echo $_POST['fem_id'.$i.''];
        $str= $str.$_POST['fem_id'.$i.''];
        if($i+1>=$_POST['count'])
            continue;
        $str+=',"';
    }
    $str+=']';

    $query = "insert into famliy(user_id, mission, point) values('".$str."', NULL, 0);";
    $result = mysqli_query($conn, $query);
    if($result)
        echo "<script>alert('그룹 만들기에 성공하였습니다.');</script>";
?>