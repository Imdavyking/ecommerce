<?php

if (!session_id()) session_start();
define('root', $_SERVER['DOCUMENT_ROOT']);
$constantVar = function ($name) {
  return constant($name);
};
require_once "{$constantVar('root')}/includes/common_data.inc.php";
outPutMinified('htmlStart');
?>
<!DOCTYPE html>
<!-- Designined by CodingLab | www.youtube.com/codinglabyt -->
<html lang="en" dir="ltr">

<head>
  <?php require_once "{$constantVar('root')}/partials/meta_tags.php"; ?>
  <title>Admin | <?= $CONSTANT('COMPANY_DEFAULT_TITLE') ?></title>
  <meta name="robot" content="noindex,nofollow" />
  <link rel="stylesheet" href="<?= $CACHE_BUSTER('/css/admin/style.min.css') ?>" />
  <!-- Boxicons CDN Link -->
  <link href="<?= $CACHE_BUSTER('/vendor/boxicons/boxicons.min.css') ?>" rel="stylesheet" />
  <script src="<?= $CACHE_BUSTER('/js/admin/main.min.js') ?>" defer></script>
</head>

<body>
  <div class="sidebar">
    <div class="logo-details sidebarBtn">
      <img src="<?= $CACHE_BUSTER('/favicon.ico') ?>" alt="company logo">
      <span class="logo_name">Nelka house</span>
    </div>
    <ul class="nav-links">
      <li>
        <a href="#" class="active">
          <i class="bx bx-grid-alt"></i>
          <span class="links_name">Dashboard</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-box"></i>
          <span class="links_name">Product</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-list-ul"></i>
          <span class="links_name">Order list</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-pie-chart-alt-2"></i>
          <span class="links_name">Analytics</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-coin-stack"></i>
          <span class="links_name">Stock</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-book-alt"></i>
          <span class="links_name">Total order</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-user"></i>
          <span class="links_name">Team</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-message"></i>
          <span class="links_name">Messages</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-heart"></i>
          <span class="links_name">Favorites</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-cog"></i>
          <span class="links_name">Setting</span>
        </a>
      </li>
      <li class="log_out">
        <a href="#">
          <i class="bx bx-log-out"></i>
          <span class="links_name">Log out</span>
        </a>
      </li>
    </ul>
  </div>
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <span class="dashboard">Dashboard</span>
      </div>
      <div class="search-box">
        <input type="text" placeholder="Search..." />
        <i class="bx bx-search searchBtn"></i>
      </div>
      <div class="profile-details">
        <img src="<?= $CACHE_BUSTER('/img/admin/nelka_ceo.jpg') ?>" alt="Admin" />
        <span class="admin_name">Nelka</span>
        <i class="bx bx-chevron-down"></i>
      </div>
    </nav>

    <div class="home-content">
      <div class="overview-boxes">
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Order</div>
            <div class="number">40,876</div>
            <div class="indicator">
              <i class="bx bx-up-arrow-alt"></i>
              <span class="text">Up from yesterday</span>
            </div>
          </div>
          <i class="bx bx-cart-alt cart"></i>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Sales</div>
            <div class="number">38,876</div>
            <div class="indicator">
              <i class="bx bx-up-arrow-alt"></i>
              <span class="text">Up from yesterday</span>
            </div>
          </div>
          <i class="bx bxs-cart-add cart two"></i>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Profit</div>
            <div class="number">$120,876</div>
            <div class="indicator">
              <i class="bx bx-up-arrow-alt"></i>
              <span class="text">Up from yesterday</span>
            </div>
          </div>
          <i class="bx bx-cart cart three"></i>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Return</div>
            <div class="number">11,086</div>
            <div class="indicator">
              <i class="bx bx-down-arrow-alt down"></i>
              <span class="text">Down From Today</span>
            </div>
          </div>
          <i class="bx bxs-cart-download cart four"></i>
        </div>
      </div>

      <div class="sales-boxes">
        <div class="recent-sales box">
          <div class="title">Recent Sales</div>
          <div class="sales-details">
            <ul class="details">
              <li class="topic">Date</li>
              <li><a href="#">02 Jan 2021</a></li>
              <li><a href="#">02 Jan 2021</a></li>
              <li><a href="#">02 Jan 2021</a></li>
              <li><a href="#">02 Jan 2021</a></li>
              <li><a href="#">02 Jan 2021</a></li>
              <li><a href="#">02 Jan 2021</a></li>
              <li><a href="#">02 Jan 2021</a></li>
            </ul>
            <ul class="details">
              <li class="topic">Customer</li>
              <li><a href="#">Alex Doe</a></li>
              <li><a href="#">David Mart</a></li>
              <li><a href="#">Roe Parter</a></li>
              <li><a href="#">Diana Penty</a></li>
              <li><a href="#">Martin Paw</a></li>
              <li><a href="#">Doe Alex</a></li>
              <li><a href="#">Aiana Lexa</a></li>
              <li><a href="#">Rexel Mags</a></li>
              <li><a href="#">Tiana Loths</a></li>
            </ul>
            <ul class="details">
              <li class="topic">Sales</li>
              <li><a href="#">Delivered</a></li>
              <li><a href="#">Pending</a></li>
              <li><a href="#">Returned</a></li>
              <li><a href="#">Delivered</a></li>
              <li><a href="#">Pending</a></li>
              <li><a href="#">Returned</a></li>
              <li><a href="#">Delivered</a></li>
              <li><a href="#">Pending</a></li>
              <li><a href="#">Delivered</a></li>
            </ul>
            <ul class="details">
              <li class="topic">Total</li>
              <li><a href="#">$204,000</a></li>
              <li><a href="#">$24,650</a></li>
              <li><a href="#">$650,000</a></li>
              <li><a href="#">$124,000</a></li>
              <li><a href="#">$204,000</a></li>
              <li><a href="#">$95,000</a></li>
              <li><a href="#">$67,300</a></li>
              <li><a href="#">$23,500</a></li>
              <li><a href="#">$1,000,000</a></li>
            </ul>
          </div>
          <div class="button">
            <a href="#">See All</a>
          </div>
        </div>
        <div class="top-sales box">
          <div class="title">Top Seling Product</div>
          <ul class="top-sales-details">
            <li>
              <a href="#">
                <img src="<?= $CACHE_BUSTER('/img/products/samsung/samsung5.jpg') ?>" alt="" />
                <span class="product">Samsung Galaxy A30</span>
              </a>
              <span class="price">$85,000</span>
            </li>
            <li>
              <a href="#">
                <img src="<?= $CACHE_BUSTER('/img/products/headphone/headphone7.jpg') ?>" alt="" />
                <span class="product">Sony WH-CH510</span>
              </a>
              <span class="price">$124,000</span>
            </li>
            <li>
              <a href="#">
                <img src="<?= $CACHE_BUSTER('/img/products/iphone/iphone4.jpg') ?>" alt="" />
                <span class="product">Apple iPhone 11</span>
              </a>
              <span class="price">$380,000</span>
            </li>
            <li>
              <a href="#">
                <img src="<?= $CACHE_BUSTER('/img/products/headphone/headphone10.jpg') ?>" alt="" />
                <span class="product">Sony WH</span>
              </a>
              <span class="price">$120,000</span>
            </li>
            <li>
              <a href="#">
                <img src="<?= $CACHE_BUSTER('/img/products/iphone/iphone5.jpg') ?>" alt="" />
                <span class="product">Apple iPhone 12</span>
              </a>
              <span class="price">$456,000</span>
            </li>
            <li>
              <a href="#">
                <img src="<?= $CACHE_BUSTER('/img/products/samsung/samsung6.jpg') ?>" alt="" />
                <span class="product">Samsung Galaxy J6+</span>
              </a>
              <span class="price">$60,000</span>
            </li>

            <li>
              <a href="#">
                <img src="<?= $CACHE_BUSTER('/img/products/iphone/iphone5.jpg') ?>" alt="" />
                <span class="product">Apple iPhone 11 pro</span>
              </a>
              <span class="price">$380,000</span>
            </li>
            <li>
              <a href="#">
                <img src="<?= $CACHE_BUSTER('/img/products/samsung/samsung2.jpg') ?>" alt="" />
                <span class="product">Samsung Galaxy S7 edge</span>
              </a>
              <span class="price">$85,000</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
</body>

</html>