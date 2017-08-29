<?php include_once( 'partial/header_constructor_edit.php' ); ?>

<div class="container-inner">
  <div class="constructor-wrapper">
    <?php include_once( 'partial/rotate.php' ); ?>
    <div class="step-wrapper">
      <div class="title">
        <input type="text" placeholder="My Jewellery"/>
        <p>You can add the name of your future jewelry</p>
      </div>
      <div class="canvas canvas-necklace">
        <div class="scrollbar-outer">
          <div class="basement">
            <img src="<?php includeImg('necklace-basement.png'); ?>">
            <canvas id="canvas" class="part-place"></canvas>
          </div>
          <div class="final-img model-necklace"><img src=""></div>
        </div>
      </div>
      <div class="zoom-controls">
        <div class="zoom-out"><img src="<?php includeImg('zoom-out.png'); ?>"></div>
        <span>Zoom</span>
        <div class="zoom-in"><img src="<?php includeImg('zoom-in.png'); ?>"></div>
      </div>
      <div class="constructor-total-wrapper">
        <div class="constructor-total-price"><label>Price:</label><span><i>300</i> $</span></div>
        <div class="constructor-total-weight"><label>Weight:</label><span><i>300</i> g</span></div>
      </div>
      <a href="#" class="constructor-complete">Complete</a>
    </div>
    <div class="constructor-edit-sidebar">
      <div class="title">my jewellery design:</div>
      <div class="edit-steps">
        <a href="constructor_step_1_edit.php" class="edit-step hidden">
          <span><img src="<?php includeImg('edit-available.png'); ?>"></span>
          My jewellery
        </a>
        <a href="constructor_step_2_edit-necklace.php" class="edit-step hidden">
          <span><img src="<?php includeImg('edit-available.png'); ?>"></span>
          My jewellery model
        </a>
        <a href="constructor_step_3-necklace-type1.php" class="edit-step hidden">
          <span><img src="<?php includeImg('edit-available.png'); ?>"></span>
          My jewellery material
        </a>
        <a href="constructor_step_4-necklace-type1.php" class="edit-step active">
          <span><img src="<?php includeImg('edit.png'); ?>"></span>
          My unique design
          <div class="parts-toggler active"><span></span></div>
        </a>
        <div class="parts-wrapper visible">
          <div class="part-view">
            <div class="close"></div>
            <div class="img">
              <img src="">
            </div>
            <div class="part-options">
              <div class="option part-name">
                <label>Name:</label>
                <span>Gold Plated Regular Ring</span>
              </div>
              <div class="option part-size">
                <label>Size:</label>
                <span>1.7x2.5 cm</span>
              </div>
              <div class="option part-weight">
                <label>Weight:</label>
                <span><i>8.00</i> gr</span>
              </div>
            </div>
            <div class="part-price"><label>Price:</label><span><i>10</i> $</span></div>
          </div>
          <div class="filters-wrapper">
            <div class="filters">
              <div class="filter">
                <label>Collection</label>
                <select>
                  <option>All</option>
                  <option>Pyramids</option>
                  <option>Circles</option>
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
          </div>
          <div class="scrollbar-outer">
            <div class="part-block">
              <div class="part-type">Pyramids collection</div>
              <div class="part-list">
                <div class="part">
                  <div class="img" data-src="<?php includeImg('ring-part-1-big.png'); ?>" data-name="Gold Plated Regular Ring" data-size="1.7x2.5 cm" data-weight="8.00" data-price="10">
                    <img class="part-img" src="<?php includeImg('ring-part-1.png'); ?>">
                  </div>
                  <div class="product-price"><span>100 $</span></div>
                </div>
                <div class="part">
                  <div class="img" data-src="<?php includeImg('ring-part-2-big.png'); ?>" data-name="Gold Plated Regular Ring" data-size="1.7x2.5 cm" data-weight="8.00" data-price="10">
                    <img class="part-img" src="<?php includeImg('ring-part-2.png'); ?>">
                  </div>
                  <div class="product-price"><span>100 $</span></div>
                </div>
                <div class="part">
                  <div class="img" data-src="<?php includeImg('ring-part-3-big.png'); ?>" data-name="Gold Plated Regular Ring" data-size="1.7x2.5 cm" data-weight="8.00" data-price="10">
                    <img class="part-img" src="<?php includeImg('ring-part-3.png'); ?>">
                  </div>
                  <div class="product-price"><span>100 $</span></div>
                </div>
                <div class="part">
                  <div class="img" data-src="<?php includeImg('ring-part-4-big.png'); ?>" data-name="Gold Plated Regular Ring" data-size="1.7x2.5 cm" data-weight="8.00" data-price="10">
                    <img class="part-img" src="<?php includeImg('ring-part-4.png'); ?>">
                  </div>
                  <div class="product-price"><span>100 $</span></div>
                </div>
              </div>
            </div>
            <div class="part-block">
              <div class="part-type">Circles collection</div>
              <div class="part-list">
                <div class="part">
                  <div class="img" data-src="<?php includeImg('ring-part-5-big.png'); ?>" data-name="Gold Plated Regular Ring" data-size="1.7x2.5 cm" data-weight="8.00" data-price="10">
                    <img class="part-img" src="<?php includeImg('ring-part-5.png'); ?>">
                  </div>
                  <div class="product-price"><span>100 $</span></div>
                </div>
                <div class="part">
                  <div class="img" data-src="<?php includeImg('ring-part-6-big.png'); ?>" data-name="Gold Plated Regular Ring" data-size="1.7x2.5 cm" data-weight="8.00" data-price="10">
                    <img class="part-img" src="<?php includeImg('ring-part-6.png'); ?>">
                  </div>
                  <div class="product-price"><span>100 $</span></div>
                </div>
                <div class="part">
                  <div class="img" data-src="<?php includeImg('ring-part-7-big.png'); ?>" data-name="Gold Plated Regular Ring" data-size="1.7x2.5 cm" data-weight="8.00" data-price="10">
                    <img class="part-img" src="<?php includeImg('ring-part-7.png'); ?>">
                  </div>
                  <div class="product-price"><span>100 $</span></div>
                </div>
                <div class="part">
                  <div class="img" data-src="<?php includeImg('ring-part-8-big.png'); ?>" data-name="Gold Plated Regular Ring" data-size="1.7x2.5 cm" data-weight="8.00" data-price="10">
                    <img class="part-img" src="<?php includeImg('ring-part-8.png'); ?>">
                  </div>
                  <div class="product-price"><span>100 $</span></div>
                </div>
                <div class="part">
                  <div class="img" data-src="<?php includeImg('ring-part-9-big.png'); ?>" data-name="Gold Plated Regular Ring" data-size="1.7x2.5 cm" data-weight="8.00" data-price="10">
                    <img class="part-img" src="<?php includeImg('ring-part-9.png'); ?>">
                  </div>
                  <div class="product-price"><span>100 $</span></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <a href="constructor_step_5.php" class="edit-step hidden step-5">
          <span>5</span>
          My order
        </a>
        <div class="product-info">
          <div class="product-name"><label>Description:</label><span>“Silver” Necklace</span></div>
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
          <div class="product-price"><label>Price:</label><span><i>100</i> $</span></div>
          <div class="btns">
            <a href="#" class="add-to-cart">add to cart</a>
            <a href="#" class="save">+ save to my designs</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="popup" id="image-zoom">
  <div class="popup-outer">
    <div class="popup-inner">
      <div class="popup-body">
        <div class="zoom-popup">
          <div class="close"></div>
          <div class="image-zoom">
            <div class="img"><img src=""></div>
          </div>
          <div class="range"><input type="range" value="1" min="1" max="2" step="0.05"></label></div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once( 'partial/scripts.php' ); ?>
<script type="text/javascript">
  jQuery('body').addClass('step-4-page');
</script>
</body>
</html>
