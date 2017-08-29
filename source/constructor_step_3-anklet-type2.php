<?php include_once( 'partial/header_constructor_edit.php' ); ?>

<div class="container-inner">
  <div class="constructor-wrapper">
    <?php include_once( 'partial/rotate.php' ); ?>
    <div class="step-wrapper">
      <div class="filters-wrapper">
        <div class="filters-fixed">
          <div class="max-width">
            <div class="filters">
              <div class="filter">
                <label>Jewerlly type</label>
                <select>
                  <option>All</option>
                  <option>Rings</option>
                  <option>Bracelets</option>
                </select>
              </div>
              <div class="filter">
                <label>Material</label>
                <select>
                  <option>All</option>
                  <option>Gold</option>
                  <option>Wood</option>
                </select>
              </div>
              <div class="filter">
                <label>Sort by</label>
                <select>
                  <option>Price: low to high</option>
                  <option>Price: high to low</option>
                  <option>Name: A to Z</option>
                  <option>Name: Z to A</option>
                </select>
              </div>
            </div>
            <!-- <button disabled onclick="window.location='constructor_step_4.php'"><span></span>next step</button> -->
          </div>
        </div>
      </div>
      <div class="scrollbar-outer">
        <div class="product-list">
          <div class="product-item">
            <input type="radio" name="type" id="product-1"/>
            <label for="product-1">
              <div class="img">
                <img src="<?php includeImg('necklace2-basement.png'); ?>">
                <div class="img-action">
                  <a href="#" data-popup="zoom"><img src="<?php includeImg('zoom.png'); ?>"></a>
                  <a href="#">add</a>
                </div>
              </div>
            </label>
            <a href="gallery_item.php" class="product-name">Model name</a>
            <div class="product-price"><span>100 $</span></div>
          </div>
        </div>
        <div class="btns">
          <button class="back" onclick="window.location='constructor_step_2_edit-anklet.php'"><span></span>back</button>
          <button disabled onclick="window.location='constructor_step_4-anklet-type2.php'"><span></span>next step</button>
        </div>
      </div>
    </div>
    <div class="constructor-edit-sidebar">
      <div class="title">my jewellery design:</div>
      <div class="edit-steps">
        <a href="constructor_step_1_edit.php" class="edit-step">
          <span><img src="<?php includeImg('edit-available.png'); ?>"></span>
          My jewellery
        </a>
        <a href="constructor_step_2_edit-anklet.php" class="edit-step">
          <span><img src="<?php includeImg('edit-available.png'); ?>"></span>
          My jewellery model
        </a>
        <a href="#" class="edit-step active">
          <span><img src="<?php includeImg('edit.png'); ?>"></span>
          My jewellery material
        </a>
        <a href="#" class="edit-step">
          <span>4</span>
          My unique design
        </a>
        <a href="#" class="edit-step">
          <span>5</span>
          My order
        </a>
      </div>
    </div>
  </div>
</div>

<div class="popup" id="zoom">
  <div class="popup-outer">
    <div class="popup-inner">
      <div class="popup-body">
        <div class="close"></div>
        <div class="zoom-wrapper">
          <div class="product-name">Gold Plated Regular Earring</div>
          <div class="swiper-container">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <div class="img">
                  <img src="<?php includeImg('necklace2-basement.png'); ?>">
                </div>
              </div>
              <div class="swiper-slide">
                <div class="img">
                  <img src="<?php includeImg('necklace2-basement.png'); ?>">
                </div>
              </div>
              <div class="swiper-slide">
                <div class="img">
                  <img src="<?php includeImg('necklace2-basement.png'); ?>">
                </div>
              </div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-prev"><span></span></div>
            <div class="swiper-next"><span></span></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once( 'partial/scripts.php' ); ?>
<script type="text/javascript">
  jQuery('body').addClass('step-3-page');
</script>
</body>
</html>
