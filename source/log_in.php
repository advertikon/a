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
    <form class="login-wrapper">
      <div class="col">
        <p><strong>CONTINUE WITH E-MAIL</strong></p>
        <div class="form">
          <div class="field">
            <label>E-mail</label>
            <input type="text"/>
            <p class="error-text">*error</p>
          </div>
          <div class="field">
            <label>Password</label>
            <input type="pasword"/>
            <p class="error-text">*error</p>
          </div>
          <a href="reset_password.php" class="forgot">forgot a password?</a>
          <button><span></span>LOG IN</button>
        </div>
      </div>
      <div class="col">
        <p><strong>CONTINUE...</strong></p>
        <a href="#" class="fb">FACEBOOK</a>
        <a href="#" class="gp">GOOGLE</a>
        <button class="light"><span></span>AS A GUEST</button>
      </div>
    </form>
    <?php include_once( 'partial/scripts.php' ); ?>
  </body>
</html>