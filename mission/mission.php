<?php
    $importId = $_GET['id'];
    $conn = mysqli_connect('localhost', 'root', '', 'talk_on');
    if (mysqli_connect_errno()) {
        echo 'MySQL 접속 실패 : ' . mysqli_connect_error();
        exit();
    }

    // 마니또 변수
    $time = date('Y-m-d H:i:s'); // 24시간 형식으로 변경
    $query = "SELECT deadline, u.name AS other FROM mission m JOIN user u ON other_id = u.id WHERE user_id='$importId' AND deadline > '$time';";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $other = $row['other'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="./css/mission.css" />
</head>
<body>
    <aside>
        <ul class="side">
            <li id="img">
                    <a href="#"><img src="./image/toggle.png" /></a>
            </li>
            <li><a href="../homepage/homepage.php?id=<?php $_GET['id']?>" id="locate">홈페이지</a></li>
            <li><a href="./mission.php?id=<?php $_GET['id']?>">미션</a></li>
            <li><a href="../famliyInfo/famliyInfo.php?id=<?php $_GET['id']?>">가족정보</a></li>
            <li><a href="../setting/setting.php?id=<?php $_GET['id']?>">마니또 게임 설정 페이지</a></li>
            <li><a href="../myInfo/myInfo.php?id=<?php $_GET['id']?>">개인정보</a></li>
        </ul>

        <div id="logOut">
            <img src="./image/logOut.png" alt="로그아웃아이콘" />
            <a href="../login/login.html">로그아웃</a>
        </div>
    </aside>
    <main>
        <p id="text">미션</p>
        <div id="content">
            <div class="myMission">
                <p class="continue"><?php echo htmlspecialchars($other); ?>에게 해야할 미션</p>
                <div>
                    <?php
                        function gap_time($start_time, $end_time) {
                            $start_time = strtotime($start_time);
                            $end_time = strtotime($end_time);
                            $diff = $end_time - $start_time;
                            
                            $day = floor($diff / 86400);
                            $diff -= $day * 86400;
                            
                            $hours = floor($diff / 3600);
                            $diff -= $hours * 3600;
                            
                            $min = floor($diff / 60);
                            $sec = $diff - $min * 60;
                            
                            if ($day != 0)
                                return sprintf("%d일 %d시간 %d분", $day, $hours, $min);
                            else if ($hours != 0)
                                return sprintf("%d시간 %d분", $hours, $min);
                            else if ($min != 0)
                                return sprintf("%d분", $min);
                        }
                        $conn = mysqli_connect('localhost', 'root', '', 'talk_on');
                        if (mysqli_connect_errno()) {
                            echo 'MySQL 접속 실패 : ' . mysqli_connect_error();
                            exit();
                        }
                        
                        $query = "SELECT mission_id, content, isComplete, deadline FROM mission WHERE user_id='$importId' AND deadline > '$time';";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $gap = gap_time($time, $row['deadline']);
                            if ($row['isComplete'] == '1')
                                echo "<ul class='my'>
                                <li><p>".$other."에게 ".$row['content']."(".$row['isComplete']."/1) • ".$gap." 남음</p></li>
                                <li><input type='checkbox' data-id='".$row['mission_id']."' class='check1' checked></li>
                                </ul>";
                            else
                                echo "<ul class='mission'>
                                <li><p>".$other."에게 ".$row['content']."(".$row['isComplete']."/1) • ".$gap." 남음</p></li>
                                <li><input type='checkbox' data-id='".$row['mission_id']."' class='check1'></li>
                                </ul>";
                        }
                    ?>
                </div>
            </div>

            <div class="famliyMission">
                <p class="continue">가족 미션</p>
                <div>
                    <?php
                        $conn = mysqli_connect('localhost', 'root', '', 'talk_on');
                        if (mysqli_connect_errno()) {
                            echo 'MySQL 접속 실패 : ' . mysqli_connect_error();
                            exit();
                        }
                        
                        $query = "SELECT mission_id, content, isComplete, deadline FROM famliy_mission WHERE famliy_id=(SELECT group_id FROM user WHERE id='$importId');";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $gap = gap_time($time, $row['deadline']);
                            if ($row['isComplete'] == '1')
                                echo "<ul class='my'>
                                <li><p>".$row['content']." • ".$gap." 남음</p></li>
                                <li><input type='checkbox' data-id='".$row['mission_id']."' class='check2' checked></li>
                                </ul>";
                            else
                                echo "<ul class='mission'>
                                <li><p>".$row['content']." • ".$gap." 남음</p></li>
                                <li><input type='checkbox' data-id='".$row['mission_id']."' class='check2'></li>
                                </ul>";
                        }
                    ?>
                </div>
            </div>

            <div class="famliy">
                <p id="famliyRank">가족 랭킹</p>
                <ul class="ranking">
                    <?php
                        $conn = mysqli_connect('localhost', 'root', '', 'talk_on');
                        if(mysqli_connect_errno()){
                            echo 'MySQL 접속 실패 : '.mysqli_connect_error();
                            exit();
                        }
                        $query = "select group_id from user where id='".$_GET['id']."';";
                        $result = mysqli_query($conn, $query);
                        $row = mysqli_fetch_assoc($result);
                        $f_id=$row['group_id'];

                        $query = "select id, name, point from famliy order by point desc";
                        $result = mysqli_query($conn, $query);
                        $rank = 0;
                        while($row = mysqli_fetch_assoc($result)){
                            $rank += 1;
                            if($f_id==$row['id'])
                                echo "<li>".$rank."등 • ".$row['name']."</li>";
                        }

                        $result2 = mysqli_query($conn, $query);
                        $i=0;
                        while($row = mysqli_fetch_assoc($result2)){
                            $i+=1;
                            if($f_id==$row['id'])
                                continue;
                            echo "<li>".$i."등 • ".$row['name']."</li>";
                        }
                    ?>
                </ul>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.check1').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const missionId = this.getAttribute('data-id');
                    const isChecked = this.checked ? 1 : 0;
                    location.href = 'check1.php?id=<?php echo htmlspecialchars($importId); ?>&check=' + missionId + '&ok=' + isChecked;
                });
            });
            
            document.querySelectorAll('.check2').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const missionId = this.getAttribute('data-id');
                    const isChecked = this.checked ? 1 : 0;
                    location.href = 'check2.php?id=<?php echo htmlspecialchars($importId); ?>&check=' + missionId + '&ok=' + isChecked;
                });
            });
        });
    </script>
</body>
</html>
