<!doctype html>
<html>
  <head>
  <title>Arbole</title>
  <?php include_once( 'partial/meta.php' ); ?>
  </head>
  <body class="checkout">
    <div class="header">
      <a href="index.php" class="logo">
        <i><img src="<?php includeImg('logo-icon.svg'); ?>"/></i>
        <span><img src="<?php includeImg('logo-text.svg'); ?>"/></span>
      </a>
    </div>
    <div class="checkout-wrapper">
      <div class="success">
        <img src="<?php includeImg('logo-icon-2.svg'); ?>">
        <p><strong>THANK YOU!</strong></p>
        <p>Now you can see your order in your account.</p>
        <a href="purchases.php" class="view-order">VIEW ORDER</a>
        <a href="gallery.php"><span></span>Continue shopping</a>
      </div>
    </div>
    <?php include_once( 'partial/scripts.php' ); ?>
  </body>
</html>