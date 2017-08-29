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
        <div class="empty">
          <img src="<?php includeImg('favorites-empty.png'); ?>">
          <p><strong>YOU HAVE NO SAVED ITEMS</strong></p>
          <p>Start saving as you shop by selecting the little heart. <br/>We'll sync your items across all your devices. Easy.  </p>
          <a href="gallery.php"><span></span>Continue shopping</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once( 'partial/footer.php' ); ?>
