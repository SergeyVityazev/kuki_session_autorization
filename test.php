<?php
/*session_start();
if ($_SESSION['ready']==true)
    header("Location:Result.php");
*/
?>

<!DOCTYPE HTML>
<html>
<head>
</head>
<body>

<?php
$NumberTest=$_SESSION['count'];
echo $_SESSION['NameGuest']." Вы выбрали тест ".$NumberTest;
$TestText=file_get_contents("test./".$NumberTest);
$DecodeTestText=json_decode($TestText,true);
$stop=false;
$N=1;
$M=0;
?>
<form  method="GET">
    <?php
    foreach ($DecodeTestText as $test) {
        foreach ($test as $inner_key => $questions) {
            if (is_string($questions))
                continue;
            foreach ($questions as $InInner_key => $question) {
                if ($InInner_key == "content") {
                    echo "<br/>";
                    echo $question ;
                    echo "<br/>";
                } elseif ($InInner_key !== "nameQ") {
                    ?>
                    <label><input type="checkbox" name=<?= (string)$N ?>> <?= $question ?></label>
                    <?php
                    $massivAnswer[] = $InInner_key;
                    $N = $N + 1;
                }
            }
        }break;
    }
    ?>

    <br/>
    <input type="submit" value="Отправить" />

</form >


<?php
$right=0;
$Noright=0;
if (!empty($_GET)) {
    echo "<br/>";
    $N = $N - 2;
    for ($i = 0; $i <= $N; $i++) {
        if (!empty($_GET[$i+1])) {
            if ($massivAnswer[$i] == "yes")
                $right = $right + 1;
            else
                $Noright = $Noright + 1;
        }
    }
    echo "<br/>";
    echo "Ваш результат:";
    echo "<br/>";
    echo $right . " Верных ответов";
    echo "<br/>";
    echo $Noright ." Неверных ответов";
    $_SESSION['right']=$right;
    $_SESSION['Noright']=$Noright;
    $_SESSION['ready']=true;
}
?>

</body>
</html>
