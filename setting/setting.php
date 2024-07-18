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
    if (mysqli_connect_errno()) {
        echo 'MySQL 접속 실패 : ' . mysqli_connect_error();
        exit();
    }
    
    $time = date('Y-m-d H:i:s'); // 24시간 형식으로 변경
    $query = "select * from game where startdate<'".$time."' and  deadline > '".$time."' ORDER BY startdate DESC LIMIT 1;";
    $result = mysqli_query($conn, $query);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $gap=gap_time($time, $row['deadline']);
            $now = "마니또게임이 진행중입니다 다음게임까지 ".$gap." 남음";
            $ok=1;
        }
    } else {
        $now = "아직 진행중인 마니또게임이 없습니다.";
        $ok=0;
    }
    
        
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Document</title>
        <link rel="stylesheet" href="css/setting.css"/>
        <style>
            #sub{
                border: none;
                background-color: white;
            }
        </style>
    </head>
    <body>
        <section class="sec1">
            <aside>
                <ul class="side">
                    <li id="img">
                        <a href="#"><img src="./image/toggle.png" /></a>
                    </li>
                    <li><a href="../homepage/homepage.php?id=<?php $_GET['id']?>" id="locate">홈페이지</a></li>
                    <li><a href="../mission/mission.php?id=<?php $_GET['id']?>">미션</a></li>
                    <li><a href="../famliyInfo/famliyInfo.php?id=<?php $_GET['id']?>">가족정보</a></li>
                    <li><a href="./setting.php?id=<?php $_GET['id']?>">마니또 게임 설정 페이지</a></li>
                    <li><a href="../myInfo/myInfo.php?id=<?php $_GET['id']?>">개인정보</a></li>
                </ul>

                <div id="logOut">
                    <img src="./image/logOut.png" alt="로그아웃아이콘" />
                    <a href="../login/login.html">로그아웃</a>
                </div>
            </aside>
            <div class="left-div">
                <div class="inner-div">
                    <p class="letter1">마니또 게임 설정</p>
                    <div class="inner-inner-div">
                        <div class="class-div">
                            <p class="letter2">마니또 게임 진행 상태</p>
                            <p class="letter3">
                                <?php echo htmlspecialchars($now); ?>
                            </p>
                        </div>
                    </div>
                    <form action="setting_post.php?id=<?php echo $_GET['id']; ?>&ok=<?php echo htmlspecialchars($ok); ?>" method="post">
                    <div class="inner-inner-div">
                        <div style="padding: 24px 24px">
                            <div class="setting">
                                <div class="data">
                                    <p class="bigletter">기한설정</p>
                                    <div class="data1">
                                            <input type="date" name="date1"/>
                                            <p class="smallletter">~</p>
                                            <input type="date" name="date2"/>
                                    </div>
                                </div>

                                <div class="data">
                                    <p class="bigletter">
                                        일일 미션 갯수 설정(최대10개)
                                    </p>
                                    <div class="data1">
                                        <select name="value" id="value">
                                            <option value="1">1개</option>
                                            <option value="2">2개</option>
                                            <option value="3">3개</option>
                                            <option value="4">4개</option>
                                            <option value="5">5개</option>
                                            <option value="6">6개</option>
                                            <option value="7">7개</option>
                                            <option value="8">8개</option>
                                            <option value="9">9개</option>
                                            <option value="10">10개</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="data">
                                    <p class="bigletter">1등보상 설정</p>
                                    <div class="data1">
                                        <p class="smallletter">
                                            <textarea name="win" id="win"></textarea>
                                        </p>
                                    </div>
                                </div>

                                <div class="data">
                                    <p class="bigletter">꼴등 페널티 설정</p>
                                    <div class="data1">
                                        <p class="smallletter">
                                            <textarea name="lose" id="lose"></textarea>
                                        </p>
                                    </div>
                                </div>
                                <div
                                    style="
                                        padding: 12px;
                                        border: black 1px solid;
                                        border-radius: 16px;
                                        width: 170px;
                                    "
                                >
                                    <input type="submit" value="마니또 게임 시작하기" id="sub">
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </section>
    </body>
</html>