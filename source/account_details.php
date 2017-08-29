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
            <span itemprop="name">Account details</span>
            <meta itemprop="position" content="2" />
          </li>
        </ol>
      </div>
      <div class="pagename"><h1>Account details</h1></div>
    </div>
    <div class="account">
      <div class="account-sidebar">
        <ul>
          <li>
            <a href="my_designs.php" class="account-designs">My designs</a>
          </li>
          <li class="active">
            <a href="#" class="account-details">Details</a>
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
        <div class="account-form">
          <form>
            <div class="field">
              <label>First name</label>
              <input type="text" value="Jack"/>
              <p class="error-text">*error</p>
            </div>
            <div class="field">
              <label>Last name</label>
              <input type="text" value="Black"/>
              <p class="error-text">*error</p>
            </div>
            <div class="field-wrapper">
              <label>Date of birth</label>
              <div class="field-date">
                <div class="date-value">08/11/1972</div>
                <div class="field">
                  <input type="text" placeholder="day" value="08"/>
                  <p class="error-text">*error</p>
                </div>
                <div class="field">
                  <input type="text" placeholder="month" value="11"/>
                  <p class="error-text">*error</p>
                </div>
                <div class="field">
                  <input type="text" placeholder="year" value="1972"/>
                  <p class="error-text">*error</p>
                </div>
              </div>
            </div>
            <div class="field-wrapper">
              <label>Gender</label>
              <div class="field-gender">
                <div class="field radio">
                  <input type="radio" name="gender" id="female"/>
                  <label for="female">female</label>
                </div>
                <div class="field radio checked">
                  <input type="radio" name="gender" id="male" checked/>
                  <label for="male">male</label>
                </div>
              </div>
            </div>
            <div class="field">
              <label>Email</label>
              <input type="text" value="jackblack@gmail.com"/>
              <p class="error-text">*error</p>
            </div>
            <div class="field">
              <label>Password</label>
              <input type="password" value="123456"/>
              <div class="eye"></div>
              <p class="error-text">*error</p>
            </div>
            <button type="submit"><span></span><i>SAVE</i><i>EDIT</i></button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once( 'partial/footer.php' ); ?>
