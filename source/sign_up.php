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
        <p><strong>SIGN UP</strong></p>
        <div class="form">
          <div class="field">
            <label>E-mail</label>
            <input type="text"/>
            <p class="error-text">*error</p>
          </div>
          <div class="field">
            <label>First name</label>
            <input type="text"/>
            <p class="error-text">*error</p>
          </div>
          <div class="field">
            <label>Last name</label>
            <input type="text"/>
            <p class="error-text">*error</p>
          </div>
          <div class="field">
            <label>Password</label>
            <input type="password"/>
            <p class="error-text">*error</p>
          </div>
          <div class="field">
            <label>Confirm password</label>
            <input type="password"/>
            <p class="error-text">*error</p>
          </div>
          <button><span></span>SIGN UP</button>
        </div>
      </div>
    </form>
    <?php include_once( 'partial/scripts.php' ); ?>
  </body>
</html>