<?php
session_start();
$RightAnswer=0;
$NoRightAnswer=0;

foreach ($_POST as $key=>$value){
    if ($value=='right')
        $RightAnswer=$RightAnswer+1;
    if ($value=='Noright')
        $NoRightAnswer=$NoRightAnswer+1;
}
$_SESSION['RightAnswer']=$RightAnswer;
$_SESSION['NoRightAnswer']=$NoRightAnswer;

if(!file_get_contents("test/".$_SESSION['TestName']))
    header('HTTP/1.0 404 Not Found');
if (!empty($_POST))
    header("Location:Result.php?RightAnswer=$_GET[RightAnswer]&NoRightAnswer=$_GET[NoRightAnswer]&UserName=$_GET[UserName]");

?>

<!DOCTYPE HTML>
<html>
<head>
</head>
<body>


<?php

$NumberTest=$_SESSION['TestName'];
$TestText=file_get_contents("test/".$NumberTest);
echo "Здравствуйте! ". $_SESSION['UserName']. " .Вы выбрали тест ".$NumberTest;
$DecodeTestText=json_decode($TestText,true);

$right=0;
$Noright=0;
$N=0;
?>
<form  method="post">
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
                    if ($InInner_key=="yes"){
                        ?> <label><input type="checkbox" name=<?=$right=$right+1 ?> value="right"> <?= $question ?></label>
                    <?php }
                    else{ ?>
                        <label><input type="checkbox" name=<?=$Noright=$Noright+1 ?> value="Noright" > <?= $question ?></label>
                    <?php  }
                }


            }
        }
    }

    ?>

    <br/>
    <input type="submit" value="Отправить" />
</form >

</body>
</html>
