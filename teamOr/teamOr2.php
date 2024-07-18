<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>팀 구성 페이지2</title>
    <link rel="stylesheet" href="./css/teamOr2.css" />
    <style>
        .fem{
            margin-bottom: 10px;
        }
        .make{
            margin-top: 20px;
        }
        .container {
            height: auto;
            min-height: 408px;
        }
    </style>
</head>
<body>
    <div class="container">
        <form name="in_id" id="in_id" action="made.php" method="post">
            <div id="add">
                <input
                    type="text"
                    name="fem_id"
                    id="fem_id"
                    class="fem"
                    placeholder="구성원 아이디 입력"
                />
            </div>
            <input
                type="button"
                class="add"
                name="fem_add"
                id="fem_add"
                value="+구성원 추가하기"
                onclick="addMember();"/>

            <input
                type="submit"
                class="make"
                name="fem_make"
                id="fem_make"
                value="만들기"
            />
            <input type="hidden" name="name" value="<?php echo $_POST['name']; ?>">
            <input type="hidden" name="count" value="0" id="count">
        </form>
    </div>
    <script>
        let i = 1;
        let first = document.getElementById("fem_add");
        first.tagName="fem_add0";
        function addMember() {
            const add = document.getElementById("add");
            const newInput = document.createElement("input");
            newInput.type = "text";
            newInput.name = "fem_id" + i;
            newInput.id = "fem_id" + i;
            newInput.className = "fem";
            newInput.placeholder = "구성원 아이디 입력";
            add.appendChild(newInput);
            i++;
            document.getElementById("count").value = i;
        }
    </script>
</body>
</html>
