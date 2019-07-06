<?php

session_start();
ob_start();
require 'baglanti/database.php';

if( isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) ){

	$records = $conn->prepare('SELECT * FROM users WHERE id = :id');
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

?>
<script src="get.js" type="text/javascript"></script>
<div id="cpContent" class="srv-panel">
<style>
.form-readonly { cursor:text !important; background-color:#fff !important; }
label { padding:9px 0 0 8px !important; font-weight:500 !important; font-size:14px; }
.fl label { padding-left:15px !important; }



h3 { font-size:28px !important; font-weight:300 !important; margin-bottom:10px; }

#hostnameFeedback { font-size:13px;padding-top:8px; }
.resWrap { overflow:hidden; margin-bottom:15px; }
.resBox { margin-left:67px; border:1px solid #ccc; border-radius:10px; }
.resOuter { background-color:#fafafa; border-radius:0 10px 10px 0; height:28px; padding:8px 7px 8px 7px; margin-left:37px; box-shadow:0 0 3px rgba(0, 0, 0, 0.08); }
.resWhite { background-color:#fff; border-radius:10px; height:12px; border:1px solid #d5d5d5; overflow:hidden; }
.resProgress { height:10px; transition:all 0.4s; }
.resTxt { border-radius:10px 0 0 10px; float:left; width:37px; background-color:#fafafa; line-height:28px; border-right:1px solid #ccc; }
.resDesc { line-height:30px; width:60px; text-align:center; }
.resRed { background-color:#cd5c5c; }
.resYellow { background-color:#f0ad4e; }
.resGreen { background-color:#5cb85c; }

.serverIconSelect { color:transparent; width:120px; height:34px; }
.serverIconSelect::-webkit-file-upload-button { visibility: hidden; }
.serverIconSelect::before { content: 'Select Image'; display: inline-block; border:1px solid #4cae4c; border-radius: 4px; padding: 5px 18px; outline: none; color:#4cae4c; white-space: nowrap; font-size:14px; font-weight:400; -webkit-user-select: none; cursor: pointer; transition:all 0.3s ease 0s; }
.serverIconSelect:hover::before, .serverIconSelect:active::before { background-color:#47a447; border-color: #398439; color:#fff; }


</style>

<div style="overflow:hidden;margin:40px auto 40px auto;width:700px;">
  <div class="fl c" style="margin:0 auto;width:335px;">
    <h3 style="margin-top:25px;">İp Adresi</h3>
    <input class="form-control form-readonly click-focus" style="margin-bottom:30px;" type="text" value="<?php echo $getir["ip"]; ?>" readonly>

  </div>
 
  <div class="fr c" style="width:325px;">
    <h3 style="margin-bottom:26px;">Özellikler</h3>
   <div style="font-weight:300;margin-bottom:30px;">

    <div class="resWrap">
    <div class="fl resDesc text-muted">CPU</div>
    <div class="resBox">
    <div class="resTxt"><img src="s/img/icon/cpu.png" style="margin-top:-3px;"></div>
    <div class="resOuter"><div class="resWhite"><div id="resCpu" class="resProgress resGreen" style="width:0%;"></div></div></div>
    </div>
    </div>
	
    <div class="resWrap">
    <div class="fl resDesc text-muted">Ram</div>
    <div class="resBox">
    <div class="resTxt"><img src="s/img/icon/ram.png" style="margin-top:-1px;"></div>
    <div class="resOuter"><div class="resWhite"><div id="resMem" class="resProgress resGreen" style="width: 0%"></div></div></div>
    </div>
    </div>

    <div class="resWrap">
    <div class="fl resDesc text-muted">Disk</div>
    <div class="resBox">
    <div class="resTxt"><i class="fa fa-hdd-o"></i></div>
    <div class="resOuter"><div class="resWhite"><div id="resDisk" class="resProgress resGreen" style="width: 0;"></div></div></div>
    </div>
    </div>

    </div>

  </div>

</div>
<h3 class="c">Sunucu Durumu</h3>
<div class="abox" style="overflow:hidden;margin:0 auto;font-weight:300;margin-bottom:10px;width:700px;">


<div id="configBox" style="padding: 20px; opacity: 1;">
<h3>Şu anki Durum: 
<?php
	$bak =ping2($getir["ip"],22,5);
	if($bak){ echo '<b class="text-success">Aktif</b>';}
	else{echo '<b class="text-danger">Pasif</b>';}
?>
</h3>
<h3>Ping: <?php echo $bak;?></h3>
 <button id="btnRestart" style="display;" class="btn btn-warning" type="button"><i class="fa fa-repeat"></i> Restart</button>
 <button id="btnStop" style="display;" class="btn btn-danger" type="button"><i class="fa fa-power-off"></i> Stop</button>  
</div></div>

</div>

</div>