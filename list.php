<?php
session_start();
if ($_SESSION['load']==true) {
    header("Location:test.php");}
if (empty($_SESSION['Autorized']) and empty($_SESSION['Guest'])){
    header('HTTP/1.0 403 Forbidden');
    exit();
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
    Choose a file to upload: <input name="inputfile" type="file" /><br />
    <input type="submit" value="Upload File" />
</form>
    <?php }
?>

<?php
if (!empty($_FILES))
    load();
function load()
{
    if (isset($_FILES) && $_FILES['inputfile']['error'] == 0) { // Проверяем, загрузил ли пользователь файл
        echo 'File Uploaded'; // Оповещаем пользователя об успешной загрузке файла
        $OriginalName= $_FILES['inputfile']['name'];
        $NewTest=fopen("test./".$OriginalName,"w");
        $Plus=$_FILES['inputfile']['tmp_name'];
        $NewPlus=file_get_contents($Plus);
        $NewTest=fwrite($NewTest,$NewPlus);
    } else {
        echo 'No File Uploaded'; // Оповещаем пользователя о том, что файл не был загружен
    }
}
?>



<?php
if ($handle = opendir('test./')) {
    while (false !== ($file = readdir($handle))) {
        if(strpos($file,".")!=0)
            $Testes[]= $file;
    }
    closedir($handle);
}
?>
<form enctype="multipart/form-data"  method="GET">
    <p><input type=text placeholder="Введите Ваше имя" name="NameGuest"></p>
    <?php
    $i=0;
    foreach ($Testes as $key=>$value){
        ?>
        <label><input type="radio" name=<?=(string)$key?>><?=$value?></label><br/>
        <?php
        $NewTest[$i]=$value;
        $i=$i+1;
    }
    ?>
    <input type="submit" value="Выбрать" >
    <br/>
    <br/>
    <?php if ($_SESSION['Autorized']) { ?>
    <input type="submit" value="Удалить" name="Delete">
<?php } ?>

 <?php
$N=count($NewTest);
for($i=1;$i<=$N;$i++)
{
    if (!empty($_GET[$i]) and !isset($_GET["Delete"])) {
        $_SESSION['count']=$NewTest[$i];
        $_SESSION['NameGuest']=$_GET["NameGuest"];
        $_SESSION['load']=true;
    }
    if (isset ($_GET['Delete'])){
        $_SESSION['count']=$NewTest[$i];
        unlink("test./".$_SESSION['count']);
        echo "Удаляем";
        $_GET['Delete']=NULL;
        $_Refrech=true; // как страницу обновить?????
    }
}
?>
</form >
</body>
</html>
