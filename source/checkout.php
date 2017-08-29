<!doctype html>
<html>
  <head>
  <title>Arbole</title>
  <?php include_once( 'partial/meta.php' ); ?>
  </head>
  <body class="checkout">
    <div class="header">
      <h1>check out</h1>
      <a href="index.php" class="logo">
        <i><img src="<?php includeImg('logo-icon.svg'); ?>"/></i>
        <span><img src="<?php includeImg('logo-text.svg'); ?>"/></span>
      </a>
      <div class="secured">secured</div>
    </div>
    <div class="checkout-wrapper">
      <div class="max-width">
        <div class="col">
          <div class="checkout-block">
            <div class="title"><span>1</span>PROMO COD OR VOUCHER</div>
            <p>Discount/promo codes cannot be used when buying gift vouchers.</p>
            <div class="field field-promo">
              <input type="text" placeholder="enter"/>
              <button><span></span>Apply</button>
            </div>
          </div>
          <div class="checkout-block">
            <div class="title"><span>2</span>E-MAIL ADDRESS</div>
            <div class="field">
              <label>E-mail</label>
              <input type="text"/>
              <p class="error-text">*error</p>
            </div>
          </div>
          <div class="checkout-block">
            <div class="title"><span>3</span>DELIVERY ADDRESS</div>
            <div class="form delivery-form editing">
              <div class="edit-toggler">edit</div>
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
                <label>Phone</label>
                <input type="text"/>
                <p class="error-text">*error</p>
              </div>
              <div class="field">
                <label>Address</label>
                <input type="text"/>
                <p class="error-text">*error</p>
              </div>
              <div class="field">
                <label>City</label>
                <input type="text"/>
                <p class="error-text">*error</p>
              </div>
              <div class="field">
                <label>Country</label>
                <input type="text"/>
                <p class="error-text">*error</p>
              </div>
              <div class="field">
                <label>Postcode</label>
                <input type="text"/>
                <p class="error-text">*error</p>
              </div>
              <button>OK</button>
            </div>
          </div>
          <div class="checkout-block payment-method">
            <div class="title"><span>4</span>PAYMENT METHOD</div>
            <p>You can pay by using Paypal.</p>
            <p><img class="paypal" src="<?php includeImg('paypal.png'); ?>"/></p>
            <button disabled onclick="window.location = 'checkout_success.php'">PLACE ORDER</button>
          </div>
          <p class="terms">By placing your order you agree to our <a href="#">Terms & Conditions, privacy and returns policies</a>. You also consent to some of your data being stored by ARBOLE’, which may be used to make future shopping experiences better for you.</p>
        </div>
        <div class="col">
          <div class="checkout-block">
            <div class="title order-items-toggler">2 ITEMS</div>
            <div class="order-items">
              <div class="order-item">
                <div class="img"><img src="<?php includeImg('product-small.png'); ?>"></div>
                <div class="info">
                  <div class="product-name">Name of my jewellery</div>
                  <div class="product-options">
                    <div class="option">
                      <label>Quantity:</label>
                      <strong>1</strong>
                    </div>                
                  </div>
                  <div class="product-price"><label>Price:</label><span>100 $</span></div>
                </div>
              </div>
              <div class="order-item">
                <div class="img"><img src="<?php includeImg('product-small.png'); ?>"></div>
                <div class="info">
                  <div class="product-name">Name of my jewellery</div>
                  <div class="product-options">
                    <div class="option">
                      <label>Quantity:</label>
                      <strong>1</strong>
                    </div>
                  </div>
                  <div class="product-price"><label>Price:</label><span>100 $</span></div>
                </div>
              </div>
            </div>
            <div class="total">
              <label>total to pay:</label>
              <span>300 $</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include_once( 'partial/scripts.php' ); ?>
  </body>
</html>