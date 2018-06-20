<?php
session_start();

var_dump($_POST);
echo "<br>";
var_dump($_GET);


if (!empty($_GET['TestName']) and !isset($_GET["Delete"])) {
    $_SESSION['NameGuest'] = $_GET["NameGuest"];
    $_SESSION['load'] = true;
}
if (isset ($_POST['Delete'])) {
    if(unlink("test/" . $_POST['TestName']))
      echo "Удаляем";
    else
        echo "Неправильное имя";
    $_GET['Delete'] = NULL;
}


if (isset ($_POST['Select'])) {
    $_SESSION['TestName'] = $_POST['TestName'];
    header("Location:test.php");

}



if (empty($_SESSION['Autorized']) and empty($_SESSION['Guest'])){
    header('HTTP/1.0 403 Forbidden');
    exit();
}





if (!empty($_FILES)) // Подгружаем файл
    load();

function load()
{

    if (isset($_FILES) && $_FILES['inputfile']['error'] == 0) { // Проверяем, загрузил ли пользователь файл
        $name=basename($_FILES['inputfile']['name']);
        if (move_uploaded_file($_FILES['inputfile']['tmp_name'],"test/".$name)==true) {
            echo 'File Uploaded'; // Оповещаем пользователя об успешной загрузке файла

        }
        else
            echo 'File Not uploaded';
    } else {
        echo 'No File Uploaded'; // Оповещаем пользователя о том, что файл не был загружен
    }
}

?>



<!DOCTYPE HTML>
<html>
<head>
</head>
<body>
<p><?php
    if ($_SESSION['Guest']==true)
    {
        echo "Здравствуйте! ".$_SESSION['NameGuest']. " Вы вошли как гость";
    }elseif($_SESSION['Autorized']){
        echo "Здравствуйте! ".$_SESSION['login']." . Вы вошли как авторизованный пользователь";
    }
    ?>
</p>

<?php
if ($_SESSION['Autorized'])
{ ?>
    <form enctype="multipart/form-data"  method="POST">
        Выберите файл: <input name="inputfile" type="file" /><br />
        <input type="submit" value="Upload File" />
    </form>
<?php }
?>




<?php
if ($handle = opendir('test/')) {
    while (false !== ($file = readdir($handle))) {
        if (strpos($file, ".") != 0) {
            $Testes[] = $file;
        }

    }
    closedir($handle);
}
?>


<!--ОТРИСОВЫВАЕМ ТЕСТЫ-->
<form enctype="multipart/form-data"  method="post">
    <p><input type=text placeholder="Введите Ваше имя" name="NameGuest"></p>
    <?php
    foreach ($Testes as $key=>$value){
        ?>
        <label><input type="radio" name='TestName' value=<?= $value; ?>><?=$value?></label><br/>
        <?php
    }
    ?>
    <input type="submit" value="Выбрать" name ='Select'>
    <br/>
    <br/>
    <?php if ($_SESSION['Autorized']) { ?>
        <input type="submit" value="Удалить" name="Delete">
    <?php } ?>
</form >
</body>
</html>
