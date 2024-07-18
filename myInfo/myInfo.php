<?php
    $importId=$_GET['id'];
    $conn = mysqli_connect('localhost', 'root', '', 'talk_on');
    if(mysqli_connect_errno()){
        echo 'MySQL 접속 실패 : '.mysqli_connect_error();
        exit();
    }
    //이름 변수 
    $query = "select name from user where id='".$_GET['id']."';";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $name=$row['name'];

    //등수 
    $query = "SELECT name, ranking
    FROM (
        SELECT id, 
        name,
        RANK() OVER (PARTITION BY group_id ORDER BY point DESC) AS ranking
        FROM user
        ) AS ranked_team
        WHERE id = '".$_GET['id']."';";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $rank = $row['ranking'];

    //마니또
    $time = date('Y-m-d h:i:s');
    $query = "select deadline, u.name as other from mission m join user u on other_id = u.id where user_id='".$_GET['id']."' and deadline > '".$time."';";
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
        <link rel="stylesheet" href="./css/myInfo.css" />
    </head>
    <body>
        <aside>
        <ul class="side">
                <li id="img">
                    <a href="#"><img src="./image/toggle.png" /></a>
                </li>
                <li><a href="../homepage/homepage.php?id=<?php $_GET['id']?>" id="locate">홈페이지</a></li>
                <li><a href="../mission/mission.php?id=<?php $_GET['id']?>">미션</a></li>
                <li><a href="../famliyInfo/famliyInfo.php?id=<?php $_GET['id']?>">가족정보</a></li>
                <li><a href="../setting/setting.php?id=<?php $_GET['id']?>">마니또 게임 설정 페이지</a></li>
                <li><a href="./myInfo.php?id=<?php $_GET['id']?>">개인정보</a></li>
            </ul>

            <div id="logOut">
                <img src="./image/logOut.png" alt="로그아웃아이콘" />
                <a href="../login/login.html">로그아웃</a>
            </div>
        </aside>

        <main>
            <p id="text">개인정보</p>
            <div class="content">
                <div class="famliyInfo">
                    <div class="profile">
                        <img src="image/profile.png" alt="프로필" />
                        <button>사진변경하기</button>
                    </div>
                    <div class="info">
                        <p>이름: <?php echo htmlspecialchars($name); ?></p>
                        <p>아이디: <?php echo $_GET['id']; ?></p>
                        <p>가족 내 랭킹: <?php echo htmlspecialchars($rank); ?>등</p>
                    </div>
                </div>
                <input type="button" value="탈퇴하기" />

                <div class="maniddo">
                    <p>당신의 마니또는 "<?php echo htmlspecialchars($other); ?>" 입니다</p>
                </div>
            </div>
        </main>
    </body>
</html>
