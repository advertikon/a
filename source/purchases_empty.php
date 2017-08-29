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
            <span itemprop="name">Orders</span>
            <meta itemprop="position" content="2" />
          </li>
        </ol>
      </div>
      <div class="pagename"><h1>Orders</h1></div>
    </div>
    <div class="account">
      <div class="account-sidebar">
        <ul>
          <li>
            <a href="my_designs.php" class="account-designs">My designs</a>
          </li>
          <li>
            <a href="account_details.php" class="account-details">Details</a>
          </li>
          <li class="active">
            <a href="purchases.php" class="account-purchases">Orders</a>
          </li>
          <li>
            <a href="index.php" class="account-logout">Logout</a>
          </li>
        </ul>
      </div>
      <div class="account-main">
        <div class="my-designs">
          <div class="empty">
            <img src="<?php includeImg('purchases-empty.png'); ?>">
            <p><strong>YOU HAVE NO PREVIOUS ORDERS :(</strong></p>
            <p>Find somethig beautiful in our store now </p>
            <a href="gallery.php"><span></span>Start shopping</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once( 'partial/footer.php' ); ?>
