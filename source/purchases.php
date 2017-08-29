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
        <table class="purchases">
          <tr>
            <th>Tracking Number</th>
            <th>Order Date</th>
            <th>Total</th>
            <th>Date Shipped</th>
            <th>Status</th>
            <th>Order</th>
          </tr>
          <?php for ($i=0; $i < 6; $i++):?>
            <tr>
              <td class="order-number" data-title="Tracking Number">9990 9890 9877</td>
              <td class="order-date" data-title="Order Date">11/05/2017</td>
              <td class="order-total" data-title="Total"><span>300 $</span></td>
              <td data-title="Date Shipped">13/05/2017</td>
              <td data-title="Status">DELIVERED</td>
              <td data-title="Order"><a href="purchases-inner.php">view</a></td>
            </tr>
          <?php endfor; ?>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include_once( 'partial/footer.php' ); ?>
