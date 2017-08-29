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
        <div class="purchases-inner-header">
          <a href="purchases.php" class="back">Back</a>
          <a href="#" class="print">Print</a>
          <p>Order Number: 3456 7890 8900</p>
        </div>
        <table class="purchases">
          <tr>
            <th>Image</th>
            <th>Product Name</th>
            <th>Quantaty</th>
            <th>Total</th>
          </tr>
          <tr>
            <td data-title="Image"><div class="img"><img src="<?php includeImg('product-small.png'); ?>"></div></td>
            <td data-title="Product Name">Silver neckace with 3 details and 4 details from gold</td>
            <td data-title="Quantity">1</td>
            <td data-title="Total"><span>300 $</span></td>
          </tr>
          <tr>
            <td data-title="Image"><div class="img"><img src="<?php includeImg('product-small.png'); ?>"></div></td>
            <td data-title="Product Name">Silver neckace with 3 details and 4 details from gold</td>
            <td data-title="Quantity">1</td>
            <td data-title="Total"><span>300 $</span></td>
          </tr>
          <tr class="purchases-total">
            <td></td>
            <td></td>
            <td>Total</td>
            <td data-title="Total"><span>600 $</span></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>
<?php include_once( 'partial/footer.php' ); ?>
<script type="text/javascript">
  jQuery('body').addClass('purchases-inner-page');
</script>
