<!doctype html>
<html>
  <head>
  <title>Arbole</title>
  <?php include_once( 'meta.php' ); ?>
  </head>
  <body class="constructor-page">
    <?php include_once( 'size-guide.php' ); ?>
  	<div class="header">
      <h1>my jewellery design</h1>
      <a href="index.php" class="logo">
        <i><img src="<?php includeImg('logo-icon.svg'); ?>"/></i>
        <span><img src="<?php includeImg('logo-text.svg'); ?>"/></span>
      </a>
      <div class="menu-wrapper">
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
        <div class="cart-sidebar-toggler"><a href="#"><img src="<?php includeImg('cart.png'); ?>"/><span>33</span></a></div>
        <div class="constructor-sidebar-toggler"><img src="<?php includeImg('ham.png'); ?>"/></div>
      </div>
  	</div>
    <div class="filters-mobile filters-mobile-constructor">
      <div class="close"></div>
      <div class="title">FILTERS</div>
      <form>
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
    <div class="constructor-sidebar">
      <div class="constructor-sidebar-inner">
        <ul class="main-menu">
          <li class="active"><a href="constructor.php">design your own</a></li>
          <li><a href="gallery.php">gallery store</a></li>
          <li><a href="about.php">About Us</a></li>
          <li><a href="faq.php">faq</a></li>
        </ul>
        <ul class="user-menu">
          <li><a href="account_details.php"><img src="<?php includeImg('user.png'); ?>"/></a></li>
          <li><a href="my_favorites.php"><img src="<?php includeImg('heart.png'); ?>"/></a></li>
          <li class="search-toggler"><a href="#"><img src="<?php includeImg('search.png'); ?>"/></a></li>
        </ul>
      </div>
    </div>
    <div class="cart-sidebar">
      <div class="cart-sidebar-inner">
        <div class="checkout-block">
          <div class="checkout-body">
            <div class="title">you added to cart:</div>
            <div class="scrollbar-outer">
              <div class="order-item">
                <div class="img"><img src="<?php includeImg('product-small.png'); ?>"></div>
                <div class="info">
                  <div class="product-name">Jewelry name + Design name</div>
                  <div class="product-options">
                    <div class="option">
                      <label>Quantity:</label>
                      <div class="field field-counter">
                        <div class="minus">-</div>
                        <input type="text" value="1" maxlength="2" class="decimal"/>
                        <div class="plus">+</div>
                      </div>
                    </div>
                  </div>
                  <div class="product-price"><label>Price:</label><span>100 $</span></div>
                </div>
                <a href="#" class="remove"></a>
              </div>
              <div class="order-item">
                <div class="img"><img src="<?php includeImg('product-small.png'); ?>"></div>
                <div class="info">
                  <div class="product-name">Jewelry name + Design name</div>
                  <div class="product-options">
                    <div class="option">
                      <label>Quantity:</label>
                      <div class="field field-counter">
                        <div class="minus">-</div>
                        <input type="text" value="1" maxlength="2" class="decimal"/>
                        <div class="plus">+</div>
                      </div>
                    </div>
                  </div>
                  <div class="product-price"><label>Price:</label><span>100 $</span></div>
                </div>
                <a href="#" class="remove"></a>
              </div>
            </div>
          </div>
          <div class="checkout-footer">
            <div class="total">
              <label>total:</label>
              <span>300 $</span>
            </div>
            <div class="btns">
              <button onclick="window.location = 'checkout.php'">check out</button>
              <button class="light" onclick="window.location = 'gallery.php'">continue shopping</button>
            </div>
          </div>
        </div>
        
      </div>
    </div>


