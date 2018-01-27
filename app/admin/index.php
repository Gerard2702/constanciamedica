
<?php
    $title = "HOME";

    include("../core/header.php");

    include("../core/aside.php");

    include("../core/home.php");

    include("../core/footer.php");
 ?>
 <script>
 	$('#mimenu li').removeClass('active');
 	$('#mimenu li ul').removeClass('nav-sub--open');
 	$('#mimenu li ul li').removeClass('active');
 	$('#inicio').addClass('active');
 </script>