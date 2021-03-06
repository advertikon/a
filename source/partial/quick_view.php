<div class="popup" id="quick-view">
  <div class="popup-outer">
    <div class="popup-inner">
      <div class="popup-body">
        <div class="close"></div>
        <div class="quick-wrapper">
          <div class="swiper-container">
            <a href="my_favorites.php" class="to-favorites"></a>
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <div class="img">
                  <img src="<?php includeImg('product-small.png'); ?>">
                </div>
              </div>
              <div class="swiper-slide">
                <div class="img">
                  <img src="<?php includeImg('product-small.png'); ?>">
                </div>
              </div>
              <div class="swiper-slide">
                <div class="img">
                  <img src="<?php includeImg('product-small.png'); ?>">
                </div>
              </div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-prev"><span></span></div>
            <div class="swiper-next"><span></span></div>
          </div>
          <div class="product-info">
            <div class="product-name">Model name</div>
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
            <a href="gallery_item.php" class="more"><span></span>view details</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>