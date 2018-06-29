<?php  

require "layout/config.php";

if (!empty($_POST["id"])) {

    $friend_id = $_POST['id'];
    $user_id   = $_SESSION['id'];
    //  ok kdodge this is  my take on it if you can make tables or modify  my query / statement here ??
    $value = $pdo->prepare('SELECT * FROM user_friends WHERE friend_id= ? and user_id = ?');
    $value->bindParam(1, $friend_id, PDO::PARAM_INT);
    $value->bindParam(2, $user_id, PDO::PARAM_INT);
    $value->execute();
    $result = $value->fetch();

    if ($result > 0) {
        echo 'Already friends';
    } else {
        if ($_SESSION['id'] != $_POST['id']) {
            $friend_id = $_POST['id'];
            $user_id   = $_SESSION['id'];

            $query = $pdo->prepare("INSERT INTO user_friends (friend_id, user_id, friendsSince)
                                  VALUES (:friend_id, :user_id, NOW())");
            $query->execute(array(
                    ":friend_id" => $friend_id,
                    ":user_id" => $user_id
            ));

            echo 'Added as friend';
        } else {
            echo 'Trying to add themselves';
        }
    }
}

?>

<?php require "layout/header.php"; ?>

<script>
    $('.newFriend, .buttons').click(function() {
    $.post('misc/add_friend.php',
            {
                "id": $(this).attr('id')
            },
            function (response) {

                switch (response) {
                    case 'Already friends':
                        $('#message_newfriend').html('<div id="alertFadeOut" style="color: green">Already friends!</div>');
                        $('#alertFadeOut').fadeOut(3000, function () {
                            $('#alertFadeOut').text('');
                        });
                        break;
                    case 'Trying to add themselves':
                        $('#message_newfriend').html('<div id="alertFadeOut" style="color: red">You\'re trying to add yourself</div>');
                        $('#alertFadeOut').fadeOut(3000, function () {
                            $('#alertFadeOut').text('');
                        });
                        break;
                    case 'Added as friend':
                        $('#message_newfriend').html('<div id="alertFadeOut" style="color: red">You\'re now friends!</div>');
                        $('#alertFadeOut').fadeOut(3000, function () {
                            $('#alertFadeOut').text('');
                        });
                        break;
                }
            });
});


</script>

<?php require "layout/footer.php"; ?>