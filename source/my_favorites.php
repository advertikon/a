<?php include_once( 'partial/header.php' ); ?>

<div class="container-inner">
  <div class="section wide">
    <div class="max-width">
      <div class="breadcrumbs">
        <ol itemscope="" itemtype="http://schema.org/BreadcrumbList">
          <li itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
            <a href="/" itemprop="item"><span itemprop="name">Home</span></a>
            <meta itemprop="position" content="1" />
          </li>
          <li itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
            <link href="" itemprop="item" />
            <span itemprop="name">My favorites</span>
            <meta itemprop="position" content="2" />
          </li>
        </ol>
      </div>
      <div class="pagename"><h1>My favorites</h1></div>
      <div class="my-favorites">
        <div class="product-list">
          <div class="product-item">
            <div class="remove"></div>
            <a href="gallery_item.php" class="img">
              <img src="<?php includeImg('product-small.png'); ?>">
              <div class="img-action"><span data-popup="quick-view">View</span></div>
            </a>
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
            <a href="gallery_item.php" class="img">
              <img src="<?php includeImg('product-small.png'); ?>">
              <div class="img-action"><span data-popup="quick-view">View</span></div>
            </a>
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
            <a href="gallery_item.php" class="img">
              <img src="<?php includeImg('product-small.png'); ?>">
              <div class="img-action"><span data-popup="quick-view">View</span></div>
            </a>
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
            <a href="gallery_item.php" class="img">
              <img src="<?php includeImg('product-small.png'); ?>">
              <div class="img-action"><span data-popup="quick-view">View</span></div>
            </a>
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
            <a href="gallery_item.php" class="img">
              <img src="<?php includeImg('product-small.png'); ?>">
              <div class="img-action"><span data-popup="quick-view">View</span></div>
            </a>
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

<?php include_once( 'partial/quick_view.php' ); ?>

<?php include_once( 'partial/footer.php' ); ?>
