<?php
date_default_timezone_set('Asia/Jakarta');
$title           = "Sanggar Kicau | ";
$nama_perusahaan = "Sanggar Kicau";
?>
<script type="text/javascript">
    var txt="<?php echo $title; ?>";
    var speed=150;
    var SULE_SS=null;
    function move() { 
    	document.title=txt;
    	txt=txt.substring(1,txt.length)+txt.charAt(0);
    	fresh=setTimeout("move()",speed);
    }
    move();
</script>