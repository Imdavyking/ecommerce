<?php

if (!session_id()) session_start();
define('root', $_SERVER['DOCUMENT_ROOT']);
$constantVar = function ($name) {
  return constant($name);
};
require_once "{$constantVar('root')}/includes/checkLogin.php";
require_once "{$constantVar('root')}/includes/user_cart_items.php";
require_once "{$constantVar('root')}/includes/common_data.inc.php";
$userSearchQueryResult = [];
if (isset($_GET['query']) && isset($_GET['page'])) {
  $query = trim(rawurlencode($_GET['query']));
  $page = trim(rawurlencode($_GET['page']));
  $curlGetSearchQueryResult = curl_init("http://{$_SERVER['SERVER_NAME']}/api/search?query={$query}&page={$page}");

  $curlOptions = [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true
  ];

  if (debug) {
    $curlOptions = $curlOptions + [
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_SSL_VERIFYHOST =>  false
    ];
  }
  curl_setopt_array($curlGetSearchQueryResult, $curlOptions);

  $result = json_decode(curl_exec($curlGetSearchQueryResult), true);
  $error = curl_error($curlGetSearchQueryResult);
  if ($error) die("Can not display products now ");
  // if ($result['status'] === 'error') die(header('Location: /'));
  $userSearchQueryResult = $result['products'];
} else die(header('Location: /'));

outPutMinified('htmlStart');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once "{$constantVar('root')}/partials/meta_tags.php"; ?>
  <!-- Custom StyleSheet -->
  <link rel="stylesheet" href="<?= $CACHE_BUSTER('/css/search.min.css') ?>" />
  <script src="<?= $CACHE_BUSTER('/js/search.min.js') ?>" defer></script>
  <title>Search | <?= $CONSTANT('COMPANY_DEFAULT_TITLE') ?></title>
</head>

<body data-userCartItemsIds="<?= json_encode($cartItemsIds ?? []) ?>" data-userid="<?= htmlspecialchars($loginResult['user_id'] ?? '') ?>">

  <!-- Header -->
  <header id="header" class="header">
    <div class="navigation">
      <div class="container">
        <?php require_once "{$constantVar('root')}/partials/nav_bar.php"; ?>
      </div>
    </div>

  </header>
  <!-- Main -->
  <main id="main">
    <div class="container">
      <section class="category__section section" id="category">
        <div class="tab__list">
          <div class="title__container tabs">
            <div class="section__titles category__titles ">
              <div class="section__title filter-btn active" data-id="All Products">
                <h1 class="primary__title"><?= (count($userSearchQueryResult) !== 0 ? 'All Products' : 'Sorry product was not found') ?></h1>
              </div>
            </div>
          </div>
        </div>
        <div class="category__container">
          <div class="category__center">
            <?php if (count($userSearchQueryResult) !== 0) : ?>
              <?php foreach ($userSearchQueryResult as $key => $value) : ?>
                <div class="product category__products">
                  <div class="product__header">
                    <img src="<?= htmlspecialchars($CACHE_BUSTER($value['image'])) ?>" alt="product">
                  </div>
                  <div class="product__footer">
                    <h3><?= htmlspecialchars($value['title']) ?></h3>
                    <div class="rating">
                      <div class="stars-outer">
                        <div class="stars-inner" data-rating="<?= htmlspecialchars($value['rating']) ?>"></div>
                      </div>
                    </div>
                    <div class="product__price">
                      <h4>$<?= number_format(htmlspecialchars($value['price'])) ?></h4>
                    </div>
                    <a href="#"><button type="submit" class="product__btn" data-id="<?= htmlspecialchars($value['id']) ?>">Add To Cart</button></a>
                  </div>
                  <ul>
                    <li>
                      <a data-tip="Quick View" data-place="left" href="/house/product?id=<?= htmlspecialchars($value['id']) ?>">
                        <svg>
                          <use xlink:href="/img/sprite.svg#icon-eye"></use>
                        </svg>
                      </a>
                    </li>
                    <li>
                      <a data-tip="Add To Wishlist" data-place="left" href="#">
                        <svg>
                          <use xlink:href="/img/sprite.svg#icon-heart-o"></use>
                        </svg>
                      </a>
                    </li>
                    <li>
                      <a data-tip="Add To Compare" data-place="left" href="#">
                        <svg>
                          <use xlink:href="/img/sprite.svg#icon-loop2"></use>
                        </svg>
                      </a>
                    </li>
                  </ul>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </section>
      <?php if (count($userSearchQueryResult) !== 0) : ?>
        <div class="controls noPrev">


          <a class="left<?= htmlspecialchars($result['current_page'] === 1
                          ? ' disabled'
                          : '') ?>" href="/house/search?query=<?= rawurlencode($_GET['query']) ?>&page=<?=
                                                                                                        rawurlencode($result['current_page'] === 1
                                                                                                          ? '#'
                                                                                                          : $result['current_page'] - 1)
                                                                                                        ?>" class="prev">
            <i class="fa fa-chevron-left"></i></a>


          <div class="page">
            <span class="current" data-current="<?= htmlspecialchars($result['current_page']) ?>"><?= htmlspecialchars($result['current_page']) ?></span>
            &nbsp;of&nbsp;
            <span class="total" data-total="<?= htmlspecialchars($result['total_pages']) ?>"><?= htmlspecialchars($result['total_pages']) ?></span>
          </div>


          <a class="right<?= $result['current_page'] === $result['total_pages']
                            ? ' disabled'
                            : '' ?>" href="/house/search?query=<?= rawurlencode($_GET['query']) ?>&page=<?=
                                                                                                        rawurlencode($result['current_page'] === $result['total_pages']
                                                                                                          ? '#'
                                                                                                          : $result['current_page'] + 1)
                                                                                                        ?>" class="next">
            <i class="fa fa-chevron-right"></i>
          </a>
        </div>

      <?php endif; ?>
    </div>
  </main>
  <?php require_once "{$constantVar('root')}/partials/footer.php"; ?>

  <a href="#header" class="goto-top scroll-link">
    <svg>
      <use xlink:href="/img/sprite.svg#icon-arrow-up"></use>
    </svg>
  </a>
</body>

</html>