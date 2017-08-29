<?php include_once( 'partial/header.php' ); ?>

<div class="container-inner">
  <div class="section wide flex-column">
    <div class="max-width breadcrumbs-wrapper">
      <div class="breadcrumbs">
        <ol itemscope="" itemtype="http://schema.org/BreadcrumbList">
          <li itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
            <a href="/" itemprop="item"><span itemprop="name">Home</span></a>
            <meta itemprop="position" content="1" />
          </li>
          <li itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
            <link href="" itemprop="item" />
            <span itemprop="name">My designs</span>
            <meta itemprop="position" content="2" />
          </li>
        </ol>
      </div>
      <div class="pagename"><h1>My designs</h1></div>
    </div>
    <div class="account">
      <div class="account-sidebar">
        <ul>
          <li class="active">
            <a href="my_designs.php" class="account-designs">My designs</a>
          </li>
          <li>
            <a href="account_details.php" class="account-details">Details</a>
          </li>
          <li>
            <a href="purchases.php" class="account-purchases">Orders</a>
          </li>
          <li>
            <a href="index.php" class="account-logout">Logout</a>
          </li>
        </ul>
      </div>
      <div class="account-main">
        <div class="my-designs">
          <div class="product-list">
            <div class="product-item">
              <div class="remove"></div>
              <div class="img">
                <img src="<?php includeImg('product-small.png'); ?>">
                <div class="img-action"><a href="constructor_step_4.php">Edit</a></div>
              </div>
              <a href="gallery_item.php" class="product-name">Model name</a>
              <div class="product-price"><span>100 $</span></div>
              <div class="product-options">
                <div class="option">
                  <label>Your size:</label>
                  <div class="field">
                    <input type="text" value="15" class="decimal"/>
                    <span>mm</span>
                  </div>
                </div>
                <div class="option">
                  <label class="mobile-hide">Quantity:</label>
                  <div class="field field-counter">
                    <div class="minus">-</div>
                    <input type="text" value="1" maxlength="2" class="decimal"/>
                    <div class="plus">+</div>
                  </div>
                </div>
              </div>
              <a href="#" class="add-to-cart">add to cart</a>
            </div>
            <div class="product-item">
              <div class="remove"></div>
              <div class="img">
                <img src="<?php includeImg('product-small.png'); ?>">
                <div class="img-action"><a href="constructor_step_4.php">Edit</a></div>
              </div>
              <a href="gallery_item.php" class="product-name">Model name</a>
              <div class="product-price"><span>100 $</span></div>
              <div class="product-options">
                <div class="option">
                  <label>Your size:</label>
                  <div class="field">
                    <input type="text" value="15" class="decimal"/>
                    <span>mm</span>
                  </div>
                </div>
                <div class="option">
                  <label class="mobile-hide">Quantity:</label>
                  <div class="field field-counter">
                    <div class="minus">-</div>
                    <input type="text" value="1" maxlength="2" class="decimal"/>
                    <div class="plus">+</div>
                  </div>
                </div>
              </div>
              <a href="#" class="add-to-cart">add to cart</a>
            </div>
            <div class="product-item">
              <div class="remove"></div>
              <div class="img">
                <img src="<?php includeImg('product-small.png'); ?>">
                <div class="img-action"><a href="constructor_step_4.php">Edit</a></div>
              </div>
              <a href="gallery_item.php" class="product-name">Model name</a>
              <div class="product-price"><span>100 $</span></div>
              <div class="product-options">
                <div class="option">
                  <label>Your size:</label>
                  <div class="field">
                    <input type="text" value="15" class="decimal"/>
                    <span>mm</span>
                  </div>
                </div>
                <div class="option">
                  <label class="mobile-hide">Quantity:</label>
                  <div class="field field-counter">
                    <div class="minus">-</div>
                    <input type="text" value="1" maxlength="2" class="decimal"/>
                    <div class="plus">+</div>
                  </div>
                </div>
              </div>
              <a href="#" class="add-to-cart">add to cart</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once( 'partial/footer.php' ); ?>
