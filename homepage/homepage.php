<?php
    $importId=$_GET['id'];
    $conn = mysqli_connect('localhost', 'root', '', 'talk_on');
    if(mysqli_connect_errno()){
        echo 'MySQL 접속 실패 : '.mysqli_connect_error();
        exit();
    }
    //이름 변수
    $query = "select name from user where id='".$_GET['id']."'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $name=$row['name'];

    //점수 변수
    $query = "select point from user where id='".$_GET['id']."';";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
    $point = $user['point'];

    //마니또 변수
    $time = date('Y-m-d h:i:s');
    $query = "select deadline, u.name as other from mission m join user u on other_id = u.id where user_id='".$_GET['id']."' and deadline > '".$time."';";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $other = $row['other'];

    //미션 리스트
    $time = date('Y-m-d h:i:s');
    $query = "select content, isComplete, deadline, u.name as other from mission m join user u on other_id = u.id where user_id='".$_GET['id']."' and deadline > '".$time."';";
    $result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Document</title>
        <link rel="stylesheet" href="./css/homePage.css" />
    </head>
    <body>
        <aside>
            <ul class="side">
                <li id="img">
                    <a href="#"><img src="./img/toggle.png" /></a>
                </li>
                <li><a href="./homepage.php?id=<?php $_GET['id']?>" id="locate">홈페이지</a></li>
                <li><a href="../mission/mission.php?id=<?php $_GET['id']?>">미션</a></li>
                <li><a href="../famliyInfo/famliyInfo.php?<?php $_GET['id']?>">가족정보</a></li>
                <li><a href="../setting/setting.php?id=<?php $_GET['id']?>">마니또 게임 설정 페이지</a></li>
                <li><a href="../myInfo/myInfo.php?id=<?php $_GET['id']?>">개인정보</a></li>
            </ul>

            <div id="logOut">
                <img src="./img/logOut.png" alt="로그아웃아이콘" />
                <a href="../login/login.html">로그아웃</a>
            </div>
        </aside>
        <main>
            <p id="text">홈</p>
            <div id="content">
                <div id="myInfo">
                    <p id="name"><?php echo htmlspecialchars($name); ?>님</p>
                    <p id="point">점수 : <?php echo htmlspecialchars($point); ?>점</p>
                    <p id="maniddo">당신의 마니또는 “<?php echo htmlspecialchars($other); ?>"입니다</p>
                </div>
                <div class="mainInfo">
                    <p id="continue">진행중인 미션</p>
                    <div>
                        <?php
                            function gap_time($start_time, $end_time) {
        
                                $start_time = strtotime($start_time);
                                $end_time = strtotime($end_time);
                            
                                $diff = $end_time - $start_time;
                                
                                $day = floor($diff/86400);
                                
                                $diff = $diff-($day*86400);
                            
                                $hours = floor($diff/3600);
                            
                                $diff = $diff-($hours*3600);
                            
                                $min = floor($diff/60);
                            
                                $sec = $diff - ($min*60);
                                
                                if($day!=0)
                                    return sprintf("%d일 %d시간 %d분", $day, $hours, $min); 
                                else if($hours!=0)
                                    return sprintf("%d시간 %d분", $hours, $min);
                                else if($min!=0)
                                    return sprintf("%d분", $min); 
                            }
                            $conn = mysqli_connect('localhost', 'root', '', 'talk_on');
                            if(mysqli_connect_errno()){
                                echo 'MySQL 접속 실패 : '.mysqli_connect_error();
                                exit();
                            }
                            
                            $query = "select deadline, u.name as other from mission m join user u on other_id = u.id where user_id='".$_GET['id']."' and deadline > '".$time."';";
                            $result = mysqli_query($conn, $query);
                            $row = mysqli_fetch_assoc($result);
                            $other = $row['other'];

                            $time = date('Y-m-d h:i:s');
                            $query = "select mission_id, content, isComplete, deadline, u.name as other from mission m join user u on other_id = u.id where user_id='".$_GET['id']."' and deadline > '".$time."';";
                            $result = mysqli_query($conn, $query);
                            
                            while($row = mysqli_fetch_assoc($result)){
                                $gap = gap_time($time,$row['deadline']);
                                if($row['isComplete']=='1')
                                    echo "<ul class='mission'>
                                    <li><p>".$other."에게 ".$row['content']."(".$row['isComplete']."/1) • ".$gap." 남음</p></li>
                                    <li><input type='checkbox' data-id='".$row['mission_id']."' checked></li>
                                    </ul>";
                                else
                                    echo "<ul class='mission'>
                                    <li><p>".$other."에게 ".$row['content']."(".$row['isComplete']."/1) • ".$gap." 남음</p></li>
                                    <li><input type='checkbox' data-id='".$row['mission_id']."'></li>
                                    </ul>";
                            }
                        ?>
                    </div>
                </div>

                <div class="famliy">
                    <p id="famliyRank">가족 내 랭킹</p>
                    <ul class="ranking">
                        <?php
                            $conn = mysqli_connect('localhost', 'root', '', 'talk_on');
                            if(mysqli_connect_errno()){
                                echo 'MySQL 접속 실패 : '.mysqli_connect_error();
                                exit();
                            }
                            $query = "select name,point from user where group_id=(select group_id from user where id='".$_GET['id']."') order by point desc;";
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<li>".$row['name']." • 점수 : ".$row['point']."점";
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </main>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
                    checkbox.addEventListener('change', function() {
                        const missionId = this.getAttribute('data-id');
                        const isChecked = this.checked ? 1 : 0;
                        location.href = 'check.php?id=<?php echo htmlspecialchars($importId); ?>&check=' + missionId + '&ok=' + isChecked;
                    });
                });
            });
        </script>
    </body>
</html>
