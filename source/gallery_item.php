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
            <a href="gallery.php" itemprop="item"><span itemprop="name">Gallery Store</span></a>
            <meta itemprop="position" content="2" />
          </li>
          <li itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
            <a href="gallery.php" itemprop="item"><span itemprop="name">Rings</span></a>
            <meta itemprop="position" content="3" />
          </li>
          <li itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
            <link href="" itemprop="item" />
            <span itemprop="name">Gold Plated Regular Ring</span>
            <meta itemprop="position" content="4" />
          </li>
        </ol>
      </div>
      <div class="gallery-item-wrapper">
        <div class="swiper-container">
          <a href="my_favorites.php" class="to-favorites"></a>
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <div class="img">
                <img src="<?php includeImg('product.png'); ?>">
              </div>
            </div>
            <div class="swiper-slide">
              <div class="img">
                <img src="<?php includeImg('product.png'); ?>">
              </div>
            </div>
            <div class="swiper-slide">
              <div class="img">
                <img src="<?php includeImg('product.png'); ?>">
              </div>
            </div>
          </div>
          <div class="swiper-pagination"></div>
        </div>
        <div class="product-info">
          <div class="product-name">Model name</div>
          <div class="product-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut</div>
          <div class="product-price"><label>Price:</label><span>100 $</span></div>
          <div class="product-options">
            <div class="option">
              <label>Your size:</label>
              <div class="field">
                <input type="text" value="15" class="decimal"/>
                <span>mm</span>
                <a href="#" class="size-guide" data-popup="size-guide">size giude</a>
              </div>
            </div>
            <div class="option">
              <label>Quantity:</label>
              <div class="field field-counter">
                <div class="minus">-</div>
                <input type="text" value="1" maxlength="2" class="decimal"/>
                <div class="plus">+</div>
              </div>
            </div>
          </div>
          <a href="#" class="add-to-cart">add to cart</a>
          <a href="constructor_step_4.php" class="more"><span></span>edit in constructor</a>
        </div>
      </div>
      <div class="gallery-other-wrapper" data-size="5" data-size-1="4" data-size-2="3" data-size-3="2">
        <div class="title">You may also like
          <div class="gallery-controls">
            <div class="swiper-prev"><span></span></div>
            <div class="swiper-next"><span></span></div>
          </div>
        </div>
        <div class="swiper-container">
          <div class="swiper-wrapper">
            <?php for ($i=0; $i < 8; $i++):?>
              <div class="swiper-slide">
                <div class="product-item">
                  <a href="my_favorites.php" class="to-favorites"></a>
                  <a href="gallery_item.php" class="img">
                    <img src="<?php includeImg('product-small.png'); ?>">
                    <div class="img-action">
                      <span data-popup="quick-view">quick view</span>
                      <span>shop</span>
                    </div>
                  </a>
                  <a href="gallery_item.php" class="product-name">Model name</a>
                  <div class="product-price"><span>100 $</span></div>
                </div>
              </div>
            <?php endfor; ?>
          </div>
        </div>
      </div>
      <div class="gallery-other-wrapper" data-size="6" data-size-1="5" data-size-2="4" data-size-3="2">
        <div class="title">Recently viewed 
          <div class="gallery-controls">
            <div class="swiper-prev"><span></span></div>
            <div class="swiper-next"><span></span></div>
          </div>
        </div>
        <div class="swiper-container">
          <div class="swiper-wrapper">
            <?php for ($i=0; $i < 8; $i++):?>
              <div class="swiper-slide">
                <div class="product-item">
                  <a href="my_favorites.php" class="to-favorites"></a>
                  <a href="gallery_item.php" class="img">
                    <img src="<?php includeImg('product-small.png'); ?>">
                    <div class="img-action">
                      <span data-popup="quick-view">quick view</span>
                    </div>
                  </a>
                </div>
              </div>
            <?php endfor; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once( 'partial/quick_view.php' ); ?>

<?php include_once( 'partial/footer.php' ); ?>
