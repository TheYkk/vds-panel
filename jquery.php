<?php

session_start();
ob_start();
include("includes.php"); 

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


			$records = $conn->prepare('SELECT * from servers WHERE alanid = :id');
			$records->bindParam(':id', $_SESSION['user_id']);
			$records->execute();
			$getir = $records->fetch(PDO::FETCH_ASSOC);
//ftp ile bağlanılıp ram çekiliyor

            $connection = ssh2_connect($getir["ip"], 22);
			ssh2_auth_password($connection, "root", $getir["sifre"]);
			$sftp = ssh2_sftp($connection);
            $fh = fopen("ssh2.sftp://".intval($sftp)."/proc/meminfo", 'r');
            
			$mem = 0;
			while ($line = fgets($fh)) {
                $pieces = array();
                if (preg_match('/^MemTotal:\s+(\d+)\skB$/', $line, $pieces)) {
                $mem = $pieces[1];
                break;
                }
            }
            
			while ($line = fgets($fh)) {
                $pieces = array();
                if (preg_match('/^MemFree:\s+(\d+)\skB$/', $line, $pieces)) {
                $mem2 = $pieces[1];
                break;
                }
            }
            
            fclose($fh);
            
			function ff($path)
			{
                $units = array('KB', 'MB', 'GB', 'TB');
                $power = $path > 0 ? floor(log($path, 1024)) : 0;
                return number_format($path / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
            }
            
			$kul=$mem-$mem2;
			$top=$mem;
			$kull=$kul*100/$top;
			$yuzde=round($kull,2);
//Disk Usage
			$df=ssh2_exec($connection,"df");
			stream_set_blocking($df, true);
			$stream_out = ssh2_fetch_stream($df, SSH2_STREAM_STDIO);
			$cikti=stream_get_contents($stream_out);
			$parts = preg_split('/\s+/', $cikti);
			$disk=rtrim($parts[11],'%');
// CPU ALL
			$df2=ssh2_exec($connection," ps -Ao  pcpu --sort=-pcpu | head -n 25");
			
			stream_set_blocking($df2, true);
			$stream_out2 = ssh2_fetch_stream($df2, SSH2_STREAM_STDIO);
			$cikti2=stream_get_contents($stream_out2);
			$parts2 = preg_split('/\s+/', $cikti2);
			$toplam="";
			for($i=1;$i<25;$i++){
				$toplam=$parts2[$i]+$toplam;
			}

			echo json_encode(array('cpu' => $toplam,
									'ram' => $yuzde,
									'disk' => intval($disk)));

	?>