<?php

session_start();
ob_start();
include("includes.php"); 

if( isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) ){

	$records = $conn->prepare('SELECT id,email,password,token,port,credits FROM users WHERE id = :id');
	$records->bindParam(':id', $_SESSION['user_id']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$user = NULL;

	if( count($results) > 0){
		$user = $results;
	}

}
else
{
	header("Location: giris.php");
	exit();
}

$records = $conn->prepare('SELECT * from servers WHERE alanid = :id');
$records->bindParam(':id', $_SESSION['user_id']);
$records->execute();
$getir = $records->fetch(PDO::FETCH_ASSOC);

?>




<!DOCTYPE html>
<html lang="en">
<head>
<title>VdsPanel.com</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="VdsPanel.com ile vds ni daha kolay yonet!" />
<meta name="keywords" content="vds,panel,kolay,yonetim,profesyonel,vdspanel" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<script src="s/js/jquery-3.1.1.min.js"></script>
<link href="s/css/bootstrap-3.1.1.min.css" rel="stylesheet">
<script src="s/js/bootstrap-3.1.1.min.js"></script>
<link href="s/font-awesome-4.4.0/css/font-awesome.min.css" rel="stylesheet">
<link href="s/css/style.css" rel="stylesheet">
</head>
<body>

<div id="all">
<div id="top" style="left:0;top:0;position:fixed;">
<div style="margin:0 auto;padding:0 10px;max-width:1170px;overflow:visible;">
<div class="fl"><a class="topLogo" href="/"><img src="s/img/logo.png" style="width:180px;height:44px;padding-top:2px;"></a></div>
<div class="fl topNav">
	<a href="/">Anasayfa</a>
	<a href="/al/">SatınAl!</a>
	<a href="/destek/">Destek</a>
</div>
<div class="fr topNav">
<div class="dropdown fr">
	<a data-toggle="dropdown" href="#" style="margin-right:0;">Hesabım<i class="fa fa-angle-down"></i></a>
	<ul id="userNav" class="dropdown-menu" role="menu">
	<li><a href="/settings/"><i class="fa fa-wrench"></i> Ayarlar</a></li>
	<li><a href="/logout/"><i class="fa fa-sign-out"></i> Çıkış</a></li>
	</ul>
</div>
</div>
</div>
</div>
<div style="margin:100px auto 30px auto;overflow:hidden;">
  

  <style>
#hStatus {
  margin:-20px 0 30px 0; border-top:1px solid #d5d5d5 !important;border-bottom:1px solid #d5d5d5 !important;height:50px;transition:all 0.3s ease 0s; background-color:#fafafa;
  -webkit-touch-callout: none; -webkit-user-select: none; -khtml-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none;
   }
#nameTop {
  margin:0 170px;line-height:32px;color:#333 !important;font-weight:500;font-size:17px;overflow:hidden;text-overflow:ellipsis;
  -webkit-touch-callout: initial; -webkit-user-select: initial; -khtml-user-select: initial; -moz-user-select: initial; -ms-user-select: initial; user-select: initial;
}

#cpMenu { -webkit-touch-callout: none; -webkit-user-select: none; -khtml-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; }
#cpMenu a { color:#555; text-decoration: none; display:block; }
#cpMenu .menuEntry { cursor:pointer; margin:2px 0; border-bottom:1px solid transparent; border-top:1px solid transparent;  }
.menuIcon { padding:11px 10px 11px 18px; float:left; text-align:center; margin-right:6px; border-top:1px solid transparent; border-bottom:1px solid transparent; border-right:1px solid transparent; transition:padding 0.3s ease 0s; }
.menuIcon i { position:relative; z-index:2; width:19px; }
#cpMenu .menuIcon:hover { padding-left:8px; }
#cpMenu .active { padding-left:18px !important; background-color:#fff !important; border-top:1px solid #d5d5d5; border-bottom:1px solid #d5d5d5; border-right:none !important; }
#cpMenu .activeHover { padding-left:8px; background-color:#fff !important; border-top:1px solid #d5d5d5; border-bottom:1px solid #d5d5d5; border-right:1px solid #d5d5d5; border-radius:0 4px 4px 0; }
.menuText { position:relative; z-index:2; padding:11px 3px 11px 54px; }
#cpMenu .spacer { position:absolute; z-index:1; background-color:#fff;  height:44px; transition:width 0.3s ease 0s; width:0px; border-top:1px solid #d5d5d5; border-bottom:1px solid #d5d5d5; }
#cpMenu .activeSpacer { margin-left:36px; width:118px; border-right:1px solid #d5d5d5; border-top:1px solid #d5d5d5; border-bottom:1px solid #d5d5d5; }
</style>

<h1 id="control-panelH1" style="margin-bottom:5px;" class="control-panel">VdsPanel.com</h1>
</div>
<div id="hStatus" class="control-panel">
  <div class="c940" style="padding:8px 15px;overflow:hidden;border:none !important">
    <div class="fl" style="line-height:32px;font-size:16x;font-weight:500;"><span id="state"></span>&nbsp;</div>
    
    <div class="c" id="nameTop"><?php echo $getir["ip"]; ?></div>
  </div>
</div>

<div class="c940 control-panel">

<?php 

include("menu.php"); 

$sayfa = rtrim(get("sayfa"),"/");
  if(isset($sayfa)){
switch ($sayfa) {
  case 'kontrol':
    	include('home.php');
    	break;
  case 'ftp':
    	include('ftp.php');
    	break;
 case 'ssh':
        include('webconsole.php');
        break;
  case 'sunucuyuac':
        include('inc/ac.php');
        break; 
  case 'yetkikodu':
        include('inc/yetki.php');
        break;
  default:
        include('home.php');
        break;

    }

  }else{

	include("home.php"); 
   

  }

?>


</div>
<style>
.botBox { float:left; margin:60px 40px 20px 31px; color:#fff; }
.botBox a { line-height:23px; }
.botBox h4 { margin-bottom:8px; }
</style>

<div id="bot" style="height:230px;">
<div style="width:940px;margin:0 auto;overflow:hidden;">

  <div class="botBox">
  <div style="margin-bottom:12px;"><a href="/"><img src="s/img/logo.png" style="width:230px;height:56px;" alt="VdsPanel.com Logo"></a></div>
  <div class="c">Copyright &copy; 2017 VdsPanel.com</div>
  </div>

  <div class="botBox">
  <h4>Hesap</h4>
  <a href="/my-servers/">Giris</a><br>  <a href="/create-server/">Create Server</a><br>
  <a href="/pricing/">Pricing</a>
  </div>
</div>

<?php include("foter.php"); ?>



</div>
</body>
</html>