<?php include_once( 'partial/header.php' ); ?>

<div class="container-inner">
  <div class="section wide flex-column">
    <div class="max-width">
      <div class="breadcrumbs">
          <ol itemscope="" itemtype="http://schema.org/BreadcrumbList">
            <li itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
              <a href="/" itemprop="item"><span itemprop="name">Home</span></a>
              <meta itemprop="position" content="1" />
            </li>
            <li itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
              <link href="" itemprop="item" />
              <span itemprop="name">My Account</span>
              <meta itemprop="position" content="2" />
            </li>
          </ol>
        </div>
      <div class="pagename"><h1>My Account</h1></div>
    </div>
    <div class="account account-page">
      <div class="account-sidebar">
        <ul>
          <li>
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
      <div class="more-links">
        <a href="gallery.php" class="more"><span></span><strong>Gallery</strong>Find jewellery in our store!</a>
      </div>
    </div>
  </div>
</div>

<?php include_once( 'partial/footer.php' ); ?>
