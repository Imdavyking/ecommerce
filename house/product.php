<?php

if (!session_id()) session_start();
$constantVar = function ($name) {
  return constant($name);
};

if (!defined('root')) define('root', $_SERVER['DOCUMENT_ROOT']);

require_once "{$constantVar('root')}/utils/db.php";
require_once "{$constantVar('root')}/includes/user_cart_items.php";
require_once "{$constantVar('root')}/includes/common_data.inc.php";

if (!isset($_GET['id'])) die("<script nonce='{$_SESSION['nonce']}'>history.go(-1)</script>");
$stmt  = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$_GET['id']]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);
if ($isLoggedIn) {
  $stmtUserQuantityOfProduct = $pdo->prepare("SELECT product_quantity FROM cart WHERE user_id = ? && product_id = ?");
  $stmtUserQuantityOfProduct->execute([$loginResult['user_id'], $_GET['id']]);
  $product_quantity = $stmtUserQuantityOfProduct->fetch(PDO::FETCH_ASSOC);
}

if (!$product) die("<script nonce='{$_SESSION['nonce']}'>history.go(-1)</script>");




$curl = curl_init("http://{$_SERVER['SERVER_NAME']}/api/products?limit=6");

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
curl_setopt_array($curl, $curlOptions);

$result = curl_exec($curl);
$error = curl_error($curl);
if ($error) die("Can not display products now ");
$resultJson = json_decode($result, true)['products'];
outPutMinified('htmlStart');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once "{$constantVar('root')}/partials/meta_tags.php"; ?>

  <link rel="stylesheet" href="<?= $CACHE_BUSTER('/css/products.min.css') ?>" />
  <script src="<?= $CACHE_BUSTER('/js/products.min.js') ?>" defer></script>

  <title><?= htmlspecialchars($product['title']) ?> | <?= $CONSTANT('COMPANY_DEFAULT_TITLE') ?></title>
</head>

<body data-userCartItemsIds="<?= json_encode($cartItemsIds ?? []) ?>" data-userid=" <?= htmlspecialchars($loginResult['user_id'] ?? '') ?>">
  <header id="header" class="header">
    <div class="navigation">
      <div class="container">
        <?php require_once "{$constantVar('root')}/partials/nav_bar.php"; ?>
      </div>
    </div>

    <div class="page__title-area">
      <div class="container">
        <div class="page__title-container">
          <ul class="page__titles">
            <li>
              <a href="/">
                <svg>
                  <use xlink:href="/img/sprite.svg#icon-home"></use>
                </svg>
              </a>
            </li>
            <li class="page__title"><?= htmlspecialchars($product['title']) ?></li>
          </ul>
        </div>
      </div>
    </div>
  </header>

  <main id="main">
    <div class="container">
      <!-- Products Details -->
      <section class="section product-details__section">
        <div class="product-detail__container">
          <div class="product-detail__left">
            <div class="details__container--left">
              <div class="product__pictures">
                <div class="pictures__container">
                  <img class="picture" src="<?= htmlspecialchars($CACHE_BUSTER($product['image'])) ?>" id="pic1" />
                </div>
                <div class="pictures__container">
                  <img class="picture" src="<?= htmlspecialchars($CACHE_BUSTER($product['image'])) ?>" id="pic2" />
                </div>
                <div class="pictures__container">
                  <img class="picture" src="<?= htmlspecialchars($CACHE_BUSTER($product['image'])) ?>" id="pic3" />
                </div>
              </div>
              <div class="product__picture" id="product__picture">
                <div class="picture__container">
                  <img src="<?= htmlspecialchars($CACHE_BUSTER($product['image'])) ?>" id="pic" />
                </div>
              </div>
              <div class="zoom" id="zoom"></div>
            </div>

            <div class="product-details__btn">
              <a class="add product__btn" href="#" id="<?= htmlspecialchars($product['id']) ?>" data-id="<?= htmlspecialchars($product['id']) ?>">
                <span>
                  <svg>
                    <use xlink:href="/img/sprite.svg#icon-cart-plus"></use>
                  </svg>
                </span>
                ADD TO CART</a>
              <a class="buy" href="/house/<?php if ($isLoggedIn) : ?>cart<?php else : ?>login<?php endif; ?>">
                <span>
                  <svg>
                    <use xlink:href="/img/sprite.svg#icon-credit-card"></use>
                  </svg>
                </span>
                BUY NOW
              </a>
            </div>
          </div>

          <div class="product-detail__right">
            <div class="product-detail__content">
              <h3><?= htmlspecialchars($product['title']) ?></h3>
              <div class="price">
                <span class="new__price">$<?= number_format(htmlspecialchars($product['price'])) ?></span>
              </div>
              <div class="product__review">
                <div class="rating">
                  <div class="stars-outer">
                    <div class="stars-inner" data-rating="<?= htmlspecialchars($product['rating']) ?>"></div>
                  </div>
                </div>
                <a href="#" class="rating__quatity"><?= htmlspecialchars($product['no_of_voters']) ?> reviews</a>
              </div>
              <p>
                <?= htmlspecialchars($product['description'] ?? 'No description yet') ?>
              </p>
              <div class="product__info-container">
                <ul class="product__info">
                  <li>

                    <div class="input-counter">
                      <span>Quantity:</span>
                      <div>
                        <span class="minus-btn">
                          <svg>
                            <use xlink:href="/img/sprite.svg#icon-minus"></use>
                          </svg>
                        </span>
                        <input type="text" data-id="<?= htmlspecialchars($product['id']) ?>" min="1" value="<?= htmlspecialchars($product_quantity['product_quantity'] ?? 1) ?>" max="10" class="counter-btn">
                        <span class="plus-btn">
                          <svg>
                            <use xlink:href="/img/sprite.svg#icon-plus"></use>
                          </svg>
                        </span>
                      </div>
                    </div>
                  </li>

                  <li>
                    <span>Subtotal:</span>
                    <a href="#" class="new__price">$<?= number_format(htmlspecialchars($product['price'])) ?></a>
                  </li>
                  <li>
                    <span>Product Type:</span>
                    <a href="#">Phone</a>
                  </li>
                  <li>
                    <span>Availability:</span>
                    <a href="#" class="in-stock">In Stock (<?= htmlspecialchars($product['no_of_items']) ?> Item(s))</a>
                  </li>
                </ul>
                <div class="product-info__btn">
                  <a href="#">
                    <span>
                      <svg>
                        <use xlink:href="/img/sprite.svg#icon-crop"></use>
                      </svg>
                    </span>&nbsp;
                    SIZE GUIDE
                  </a>
                  <a href="#">
                    <span>
                      <svg>
                        <use xlink:href="/img/sprite.svg#icon-truck"></use>
                      </svg>
                    </span>&nbsp;
                    SHIPPING
                  </a>
                  <a href="#">
                    <span>
                      <svg>
                        <use xlink:href="/img/sprite.svg#icon-envelope-o"></use>
                      </svg>&nbsp;
                    </span>
                    ASK ABOUT THIS PRODUCT
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="product-detail__bottom">
          <div class="title__container tabs">

            <div class="section__titles category__titles ">
              <div class="section__title detail-btn active" data-id="description">
                <span class="dot"></span>
                <h1 class="primary__title">Description</h1>
              </div>
            </div>

            <div class="section__titles">
              <div class="section__title detail-btn" data-id="reviews">
                <span class="dot"></span>
                <h1 class="primary__title">Reviews</h1>
              </div>
            </div>

            <div class="section__titles">
              <div class="section__title detail-btn" data-id="shipping">
                <span class="dot"></span>
                <h1 class="primary__title">Shipping Details</h1>
              </div>
            </div>
          </div>

          <div class="detail__content">
            <div class="content active" id="description">
              <p><?= htmlspecialchars($product['description'] ?? 'No description yet') ?>
              </p>
              <h2>Specification</h2>
              <?php if (isset($product['spec']) && count($product['spec']) !== 0) : ?>
                <ul>
                  <?php foreach ($product['spec'] as $key => $value) : ?>
                    <li><?= $product['spec'][$key] ?></li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </div>
            <div class="content" id="reviews">
              <h1>Customer Reviews</h1>
              <div class="rating">
                <div class="stars-outer">
                  <div class="stars-inner" data-rating="<?= htmlspecialchars($product['rating']) ?>"></div>
                </div>
              </div>
            </div>
            <div class=" content" id="shipping">
              <h3>Returns Policy</h3>
              <p>You may return most new, unopened items within 30 days of delivery for a full refund. We'll also pay
                the return shipping costs if the return is a result of our error (you received an incorrect or defective
                item, etc.).</p>
              <p>You should expect to receive your refund within four weeks of giving your package to the return
                shipper, however, in many cases you will receive a refund more quickly. This time period includes the
                transit time for us to receive your return from the shipper (5 to 10 business days), the time it takes
                us to process your return once we receive it (3 to 5 business days), and the time it takes your bank to
                process our refund request (5 to 10 business days).
              </p>
              <p>If you need to return an item, simply login to your account, view the order using the 'Complete
                Orders' link under the My Account menu and click the Return Item(s) button. We'll notify you via
                e-mail of your refund once we've received and processed the returned item.
              </p>
              <h3>Shipping</h3>
              <p>We can ship to virtually any address in the world. Note that there are restrictions on some products,
                and some products cannot be shipped to international destinations.</p>
              <p>When you place an order, we will estimate shipping and delivery dates for you based on the
                availability of your items and the shipping options you choose. Depending on the shipping provider you
                choose, shipping date estimates may appear on the shipping quotes page.
              </p>
              <p>Please also note that the shipping rates for many items we sell are weight-based. The weight of any
                such item can be found on its detail page. To reflect the policies of the shipping companies we use, all
                weights will be rounded up to the next full pound.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- Related Products -->
      <section class="section related__products">
        <div class="title__container">
          <div class="section__title filter-btn active">
            <span class=" dot"></span>
            <h1 class="primary__title">Related Products</h1>
          </div>
        </div>
        <div class="container" data-aos="fade-up" data-aos-duration="1200">
          <div class="glide" id="glide_3">
            <div class="glide__track" data-glide-el="track">
              <ul class="glide__slides latest-center">
                <?php foreach ($resultJson as $key => $value) : ?>
                  <li class="glide__slide">
                    <div class="product">
                      <div class="product__header">
                        <a href="#"><img src="<?= htmlspecialchars($CACHE_BUSTER($value['image'])) ?>" alt="<?= htmlspecialchars($value['title']) ?>"></a>
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
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>

            <div class="glide__arrows" data-glide-el="controls">
              <button class="glide__arrow glide__arrow--left" data-glide-dir="<">
                <svg>
                  <use xlink:href="/img/sprite.svg#icon-arrow-left2"></use>
                </svg>
              </button>
              <button class="glide__arrow glide__arrow--right" data-glide-dir=">">
                <svg>
                  <use xlink:href="/img/sprite.svg#icon-arrow-right2"></use>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </section>
      <!-- Latest Products -->
      <section class="section latest__products">
        <div class="title__container">
          <div class="section__title filter-btn active" data-id="Latest Products">
            <span class="dot"></span>
            <h1 class="primary__title">Latest Products</h1>
          </div>
        </div>
        <div class="container" data-aos="fade-up" data-aos-duration="1200">
          <div class="glide" id="glide_2">
            <div class="glide__track" data-glide-el="track">
              <ul class="glide__slides latest-center">
                <?php foreach ($resultJson as $key => $value) : ?>
                  <li class="glide__slide">
                    <div class="product">
                      <div class="product__header">
                        <a href="#"><img src="<?= htmlspecialchars($CACHE_BUSTER($value['image'])) ?>" alt="<?= htmlspecialchars($value['title']) ?>"></a>
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
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>

            <div class="glide__arrows" data-glide-el="controls">
              <button class="glide__arrow glide__arrow--left" data-glide-dir="<">
                <svg>
                  <use xlink:href="/img/sprite.svg#icon-arrow-left2"></use>
                </svg>
              </button>
              <button class="glide__arrow glide__arrow--right" data-glide-dir=">">
                <svg>
                  <use xlink:href="/img/sprite.svg#icon-arrow-right2"></use>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </section>
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