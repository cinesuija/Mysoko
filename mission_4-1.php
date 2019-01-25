<?php
//3-2テーブル作成
$dsn = 'データベース名';
$user ='ユーザー名';
$password='パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
$sql = "CREATE TABLE IF NOT EXISTS `mission_4-1`"
."("
."id INT auto_increment,"
."name char(32),"
."comment TEXT,"
."dt datetime,"
."pass TEXT,"
."primary key(id)"
.");";
$stmt = $pdo->query($sql);
//3-5新規挿入
if(!empty($_POST['namae']) && !empty($_POST['come']) && !empty($_POST['pass'])&&empty($_POST['hensyunum'])){
$sql = $pdo -> prepare("INSERT INTO `mission_4-1`(name,comment,dt,pass) VALUES (:name,:comment,:dt,:pass)");
$sql -> bindParam(':name', $name, PDO::PARAM_STR);
$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
$sql -> bindParam(':dt', $date, PDO::PARAM_STR);
$sql -> bindParam(':pass', $pass3, PDO::PARAM_STR);
$name = (string)filter_input(INPUT_POST, 'namae');
$comment = (string)filter_input(INPUT_POST, 'come');
$date = date("Y/m/d H:i:s");
$pass3 = (string)filter_input(INPUT_POST, 'pass');
$sql -> execute();
}

//削除エラー表示
header('Content-Type: text/html; charset=UTF-8');
if(!empty($_POST['sakujopass'])){
$sql = 'SELECT * FROM `mission_4-1` where id=:id';
$id = (string)filter_input(INPUT_POST, 'sakujo');
$stmt = $pdo->prepare($sql); 
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row['pass'] != $_POST['sakujopass'])
{$error="パスワードが違います。";}
}

//編集エラー表示
if(!empty($_POST['hensyupass'])){
$sql = 'SELECT * FROM `mission_4-1` where id=:id';
$id = (string)filter_input(INPUT_POST, 'hensyu');
$stmt = $pdo->prepare($sql); 
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row['pass'] != $_POST['hensyupass'])
{$error="パスワードが違います。";}
}

//削除機能　
if(!empty($_POST['sakujo'])){
$id = (string)filter_input(INPUT_POST, 'sakujo');
$pass = (string)filter_input(INPUT_POST, 'sakujopass');
$sql = 'delete from `mission_4-1` where id=:id AND pass=:pass' ;
$stmt = $pdo->prepare($sql); 
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->bindParam(':pass', $pass, PDO::PARAM_INT);  
$stmt->execute();
}

//編集機能　表示編　
 if(!empty($_POST['hensyu'])){
$id = (string)filter_input(INPUT_POST, 'hensyu');
$pass = (string)filter_input(INPUT_POST, 'hensyupass');
$sql = 'select * FROM `mission_4-1` where id=:id AND pass=:pass';
$stmt = $pdo->prepare($sql); 
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->bindParam(':pass', $pass, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$hensyuname= $row['name'];
$hensyucome= $row['comment'];
$pass2 = $row['pass'];
$hensyunum = $row['id'];
}

//編集機能 上書き編
if(!empty($_POST['hensyunum']) && !empty($_POST['namae']) && !empty($_POST['come']) && !empty($_POST['pass'])){
$id = (string)filter_input(INPUT_POST, 'hensyunum');
$name = (string)filter_input(INPUT_POST, 'namae'); 
$comment = (string)filter_input(INPUT_POST, 'come'); 
$sql = 'update `mission_4-1` set name=:name,comment=:comment where id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':name', $name, PDO::PARAM_STR);
$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();}

?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>mission_4-1</title>
  </head>
<body>
<meta charset = "utf-8">
<?php echo $error ?>
中学の部活動は何ですか？
<form method = "POST" action = "mission_4-1.php">
<input type="text"  value="<?php echo $hensyuname; ?>" placeholder="名前" name="namae"/><br>
<input type="text"  value="<?php echo $hensyucome; ?>" placeholder="コメント" name="come"/><br>
<input type="text" value="<?php echo $pass2; ?>" placeholder="パスワード" name="pass"/>
<input type="hidden" value="<?php echo $hensyunum; ?>" name="hensyunum"/>
<input type="submit" value="送信"/><br><br>
<input type="text" value=""placeholder ="削除対象番号" name="sakujo"><br>
<input type="text" placeholder="パスワード" name="sakujopass"/>
<input type="submit" value="削除"><br><br>
<input type="text" value=""placeholder ="編集対象番号" name="hensyu"><br>
<input type="text" placeholder="パスワード" name="hensyupass"/>
<input type="submit" value="編集">
</form>
</body>
</html>


<?php
//3-6表示
header('Content-Type: text/html; charset=UTF-8');
$sql = 'SELECT * FROM `mission_4-1` order by id asc';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row){
echo $row['id'].',';
echo $row['name'].',';
echo $row['comment'].',';
echo $row['dt'].'<br>';  }
?>

