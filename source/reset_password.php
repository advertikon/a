<!doctype html>
<html>
  <head>
  <title>Arbole</title>
  <?php include_once( 'partial/meta.php' ); ?>
  </head>
  <body>
    <div class="header">
      <a href="index.php" class="logo">
        <i><img src="<?php includeImg('logo-icon.svg'); ?>"/></i>
        <span><img src="<?php includeImg('logo-text.svg'); ?>"/></span>
      </a>
    </div>
    <form class="reset-wrapper">
      <div class="col">
        <p><strong>RESET PASSWORD</strong></p>
        <p>Enter the email address associated with your account, and we’ll email you a link to reset your password.</p>
        <div class="form">
          <div class="field">
            <label>E-mail</label>
            <input type="text"/>
            <p class="error-text">*error</p>
          </div>
          <button><span></span>Send reset link</button>
          <button class="light"><span></span>BACK to login</button>
        </div>
      </div>
    </form>
    <?php include_once( 'partial/scripts.php' ); ?>
  </body>
</html>