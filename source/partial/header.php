<!doctype html>
<html>
  <head>
  <title>Arbole</title>
  <?php include_once( 'meta.php' ); ?>
  </head>
  <body class="">
    <?php include_once( 'size-guide.php' ); ?>
  	<div class="header">
  		<a href="index.php" class="logo">
        <i><img src="<?php includeImg('logo-icon.svg'); ?>"/></i>
        <span><img src="<?php includeImg('logo-text.svg'); ?>"/></span>
      </a>
      <div class="menu-wrapper">
        <ul>
          <li class="active"><a href="constructor_step_1.php">design your own</a></li>
          <li><a href="gallery.php">gallery store</a></li>
          <li><a href="about.php">About Us</a></li>
          <li><a href="faq.php">faq</a></li>
          <li class="mobile-link"><a href="account_details.php">My account</a></li>
          <li class="mobile-link search-link"><a href="#">Search</a></li>
        </ul>
        <div class="currency-toggler">
          <a href="#" class="current">$ USD</a>
          <div class="dropdown">
            <a href="#" class="active">$ USD</a>
            <a href="#">$ UAH</a>
            <a href="#">$ USD</a>
            <a href="#">$ USD</a>
          </div>
          <select>
            <option>$ USD</option>
            <option>$ UAH</option>
            <option>$ USD</option>
            <option>$ USD</option>
          </select>
        </div>
        <div class="login-toggler">
          <!-- <a href="log_in.php">LOGIN</a> -->
          <a href="account_details.php"><img src="<?php includeImg('user2.png'); ?>"/><span>Hi, </span>Oleksii</a>
        </div>
      </div>
      <div class="menu-toggler"><img src="<?php includeImg('ham.png'); ?>"/><img src="<?php includeImg('cross.png'); ?>"/></div>
  	</div>
    <div class="search-wrapper">
      <div class="close"></div>
      <div class="title">Start searching</div>
      <form>
        <div class="field">
          <input type="text" placeholder="Find jewellery"/>
          <button><img src="<?php includeImg('search.png'); ?>"/></button>
        </div>
      </form>
    </div>
    <div class="filters-mobile">
      <div class="close"></div>
      <div class="title">FILTERS</div>
      <form>
        <div class="filters-mobile-block">
          <div class="user-designs-toggler">
            <input type="checkbox" name="show-designs" checked id="show-designs"><label for="show-designs">Users Designs</label>
          </div>
        </div>
        <div class="filters-mobile-block">
          <label>Jewerlly type</label>
          <select>
            <option>All</option>
            <option>Rings</option>
            <option>Bracelets</option>
          </select>
        </div>
        <div class="filters-mobile-block">
          <label>Material</label>
          <select>
            <option>All</option>
            <option>Gold</option>
            <option>Wood</option>
          </select>
        </div>
        <button>Apply filters</button>
      </form>
    </div>
    <div class="cart-sidebar">
      <div class="cart-sidebar-inner">
        <div class="checkout-block">
          <div class="checkout-body">
            <div class="title">you cart is empty</div>
            <div class="subtitle">Find awesome jewellery on ARBOLE’!</div>
            <div class="btns">
              <button class="light" onclick="window.location = 'gallery.php'">continue shopping</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="right-sidebar">
      <ul class="user-menu">
        <li class="cart-toggler"><a href="checkout.php"><img src="<?php includeImg('cart.png'); ?>"/><span>33</span></a></li>
        <!-- <li class="user-toggler active"><a href="account_details.php"><img src="<?php includeImg('user-h.png'); ?>"/></a></li> -->
        <li class="favorites-toggler"><a href="my_favorites.php"><img src="<?php includeImg('heart.png'); ?>"/></a></li>
        <li class="search-toggler"><a href="#"><img src="<?php includeImg('search.png'); ?>"/><img src="<?php includeImg('cross.png'); ?>"/></a></li>
      </ul>
    </div>


