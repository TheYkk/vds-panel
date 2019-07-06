<?php


session_start();
ob_start();
if(isset($_SESSION['user_id']) ){
	header("Location: index.php");
	exit();
}

require 'baglanti/database.php';
$cfg = include('baglanti/ayar.php');

if(!empty($_POST['email']) && !empty($_POST['password'])):
	
	$records = $conn->prepare('SELECT * FROM users WHERE email = :email');
	$records->bindParam(':email', $_POST['email']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$message = '';
function password_verify2($p1,$p2){
 if($p1==$p2){ return true;}else{ return false;}
}
	if(count($results) > 0 && password_verify2($_POST['password'], $results['password']) ){

		$_SESSION['user_id'] = $results['id'];
		header("Location: index.php");

	} else {
		$message = '<center><h4>Yazdıgınız Bilgiler Malesef Uyuşmuyor!!</center></h4>';
		echo $results;
	}

endif;

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>VDSPANEL.COM</title>
	<link rel="stylesheet" href="giriscss/stil.css">
	<link rel="shortcut icon" href="images/ts.ico" />
</head>
<body>
<?php if(!empty($message)): ?>
		<p><?= $message ?></p>
	<?php endif; ?>
	<div class="form">
		<form action="" method="POST">
			<ul>
				<li><input placeholder="Kullanıcı Adı:" type="text" maxlength="40" class="input" name="email"></li>
				<li><input placeholder="Şifre:" type="password" maxlength="16" class="input" name="password"></li>
				<li>
							<center><button class="button"><i class="ion-plus">Giriş Yap</button></center>
				</li>
			</ul>
		</form>
	</div>
	<script src="giriscss/jquery.js"></script>
</body>
</html>
