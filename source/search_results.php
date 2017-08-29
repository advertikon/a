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
            <span itemprop="name">search results “rings”</span>
            <meta itemprop="position" content="2" />
          </li>
        </ol>
      </div>
      <div class="pagename"><h1>Rings</h1><span>1  - 35  / 35 Items</span></div>
      <div class="gallery">
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
                <div class="filter sort">
                  <label>Sort by</label>
                  <select>
                    <option>Price: low to high</option>
                    <option>Price: high to low</option>
                    <option>Name: A to Z</option>
                    <option>Name: Z to A</option>
                  </select>
                </div>
                <div class="filters-toggler">
                  Open filters
                </div>
              </div>
              <div class="user-designs-toggler">
                <input type="checkbox" name="show-designs" checked id="show-designs"><label for="show-designs">Users Designs</label>
              </div>
            </div>
          </div>
        </div>
        <div class="product-list">
          <?php for ($i=0; $i < 20; $i++):?>
            <div class="product-item">
              <a href="my_favorites.php" class="to-favorites"></a>
              <a href="gallery_item.php" class="img">
                <img src="<?php includeImg('product-small.png'); ?>">
                <div class="img-action">
                  <span data-popup="quick-view">quick view</span>
                  <span>shop now</span>
                </div>
              </a>
              <a href="gallery_item.php" class="product-name">Model name</a>
              <div class="product-price"><span>100 $</span></div>
            </div>
          <?php endfor; ?>
        </div>
        <div class="pager">
          <ul>
            <li class="prev"><a href="#"><span></span></a></li>
            <li class="current"><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li class="next"><a href="#"><span></span></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>


<?php include_once( 'partial/quick_view.php' ); ?>

<?php include_once( 'partial/footer.php' ); ?>
<script type="text/javascript">
  jQuery('body').addClass('gallery-page');
</script>