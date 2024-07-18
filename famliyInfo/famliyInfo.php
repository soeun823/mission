<?php
    $importId=$_GET['id'];
    $conn = mysqli_connect('localhost', 'root', '', 'talk_on');
    if(mysqli_connect_errno()){
        echo 'MySQL 접속 실패 : '.mysqli_connect_error();
        exit();
    }
    //이름 및 주소 변수 
    $query = "select name,address from famliy where id = (select group_id from user where id='".$_GET['id']."');";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $name=$row['name'];
    $address=$row['address'];

    $query = "select group_id from user where id='".$_GET['id']."';";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $f_id=$row['group_id'];

    $query = "select id, point from famliy order by point desc";
    $result = mysqli_query($conn, $query);
    $i = 0;
    while($row = mysqli_fetch_assoc($result)){
        $i += 1;
        if($f_id==$row['id']){
            $rank = $i;
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Document</title>
        <link rel="stylesheet" href="./css/famliyInfo.css" />
    </head>
    <body>
        <aside>
            <ul class="side">
                <li id="img">
                    <a href="#"><img src="./image/toggle.png" /></a>
                </li>
                <li><a href="../homepage/homepage.php?id=<?php $_GET['id']?>" id="locate">홈페이지</a></li>
                <li><a href="../mission/mission.php?id=<?php $_GET['id']?>">미션</a></li>
                <li><a href="./famliyInfo.php?id=<?php $_GET['id']?>">가족정보</a></li>
                <li><a href="../setting/setting.php?id=<?php $_GET['id']?>">마니또 게임 설정 페이지</a></li>
                <li><a href="../myInfo/myInfo.php?id=<?php $_GET['id']?>">개인정보</a></li>
            </ul>

            <div id="logOut">
                <img src="./image/logOut.png" alt="로그아웃아이콘" />
                <a href="../login/login.html">로그아웃</a>
            </div>
        </aside>

        <main>
            <p id="text">가족정보</p>
            <div class="content">
                <div class="famliyInfo">
                    <div class="profile">
                        <img src="image/profile.png" alt="프로필" />
                        <button>사진변경하기</button>
                    </div>
                    <div class="info">
                        <p>가족이름: <?php echo htmlspecialchars($name); ?></p>
                        <p>가족랭킹: <?php echo htmlspecialchars($rank); ?></p>
                        <p>주소: <?php echo htmlspecialchars($address); ?></p>
                    </div>
                </div>

                <div class="famliy">
                    <p id="famliyMember">가족 구성원</p>
                    <ul class="member">
                        <?php
                            $conn = mysqli_connect('localhost', 'root', '', 'talk_on');
                            if(mysqli_connect_errno()){
                                echo 'MySQL 접속 실패 : '.mysqli_connect_error();
                                exit();
                            }
                            $query = "select u.name from user u join famliy f on u.group_id=f.id where group_id=(select group_id from user where id='".$_GET['id']."');";
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<li>".$row['name']."</li>";
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </main>
    </body>
</html>
