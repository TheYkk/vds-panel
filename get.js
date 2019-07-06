$(function() {
	function getir(){
			$.post('jquery.php', function(r){
				r = JSON.parse(r);
				if(cpu > 50 && cpu < 70){crenk="resYellow";}else if(cpu > 70){crenk="resRed";}else{ crenk="resGreen";}
				if(ram > 50 && ram < 70){rrenk="resYellow";}else if(ram > 70){rrenk="resRed";}else{ rrenk="resGreen";}
				if(disk > 50 && disk < 70){drenk="resYellow";}else if(disk > 70){drenk="resRed";}else{ drenk="resGreen";}
				
				$("#resCpu").width(cpu+"%");
				$("#resMem").width(ram+"%");
				$("#resDisk").width(disk+"%");

				$("#resCpu").removeClass('resGreen');
				$("#resMem").removeClass('resGreen');
				$("#resDisk").removeClass('resGreen');

				$("#resCpu").addClass(crenk);
				$("#resMem").addClass(rrenk);
				$("#resDisk").addClass(drenk);
			});
    };
    getir();
	setInterval(getir,5000);
});