<?php require_once( 'inc/classes/RST.class.php' ); ?>
<?php 
  function includeImg($img){
  	$pathinfo = pathinfo($img);
	$ext = $pathinfo['extension'];
    if($ext == 'svg'){
      echo 'assets/build/svg/'.$img;
    }else{
      echo 'assets/build/img/'.$img;
    }
  }
?>

<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<!-- Chrome, Firefox OS and Opera -->
<meta name="theme-color" content="#4285f4">
<!-- Windows Phone -->
<meta name="msapplication-navbutton-color" content="#4285f4">
<!-- iOS Safari -->
<meta name="apple-mobile-web-app-status-bar-style" content="#4285f4">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no" />
<link rel="icon" type="image/x-icon" href="assets/build/img/fav.png" />
<link rel="icon" style="@media only screen and (-webkit-min-device-pixel-ratio: 1.5), only screen and (min-resolution: 144dpi)" type="image/png" href="assets/build/imh/fav@2x.png" />
<link type="text/css" rel="stylesheet" media="screen" href="assets/build/css/main.min.css" />