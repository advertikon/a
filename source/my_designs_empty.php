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
          <div class="empty">
            <img src="<?php includeImg('designs-empty.png'); ?>">
            <p><strong>YOU HAVE NO DESIGNS YET :(</strong></p>
            <p>Start creating your first jewerlly design. Easy.  </p>
            <a href="constructor_step_1.php" class="mobile-hide"><span></span>go to my jewellery design</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once( 'partial/footer.php' ); ?>
