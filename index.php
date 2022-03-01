<?php

if (!session_id()) session_start();

define('root', $_SERVER['DOCUMENT_ROOT']);
$constantVar = function ($name) {
  return constant($name);
};
require_once "{$constantVar('root')}/includes/checkLogin.php";
require_once "{$constantVar('root')}/includes/user_cart_items.php";
require_once "{$constantVar('root')}/includes/common_data.inc.php";

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

  <link rel="stylesheet" href="<?= $CACHE_BUSTER('/css/style.min.css') ?>" />

  <script src="<?= $CACHE_BUSTER('/js/index.min.js') ?>" defer></script>


  <title>Home | <?= $CONSTANT('COMPANY_DEFAULT_TITLE') ?></title>
</head>

<body data-userCartItemsIds="<?= json_encode($cartItemsIds ?? []) ?>" data-userid=" <?= htmlspecialchars($loginResult['user_id'] ?? '') ?>">

  <!-- Header -->
  <header id="header" class="header">
    <div class="navigation">
      <div class="container">
        <?php require_once "{$constantVar('root')}/partials/nav_bar.php"; ?>
      </div>
    </div>

    <!-- Hero -->
    <div class="hero">
      <div class="glide" id="glide_1">
        <div class="glide__track" data-glide-el="track">
          <ul class="glide__slides">
            <li class="glide__slide">
              <div class="hero__center">
                <div class="hero__left">
                  <span class="">New Inspiration <?= $userConfig['current_year'] ?></span>
                  <h1 class="">HOUSES MADE FOR YOU!</h1>
                  <p>Trending from mobile and headHouse style collection</p>
                  <a href="#lastest"><button class="hero__btn">BUY NOW</button></a>
                </div>
                <div class="hero__right">
                  <div class="hero__img-container">
                    <img class="banner_01" src="<?= $CACHE_BUSTER('/img/house_show.jpg') ?>" alt="banner2" />
                  </div>
                </div>
              </div>
            </li>
            <li class="glide__slide">
              <div class="hero__center">
                <div class="hero__left">
                  <span>New Inspiration 2020</span>
                  <h1>HOUSES MADE FOR YOU!</h1>
                  <p>Trending from house style collection</p>
                  <a href="#lastest"><button class="hero__btn">BUY NOW</button></a>
                </div>
                <div class="hero__right">
                  <img class="banner_02" src="<?= $CACHE_BUSTER('/img/house_show_2.jpg') ?>" alt="banner2" />
                </div>
              </div>
            </li>
          </ul>
        </div>
        <div class="glide__bullets" data-glide-el="controls[nav]">
          <i class="glide__bullet" data-glide-dir="=0"></i>
          <i class="glide__bullet" data-glide-dir="=1"></i>
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
  </header>
  <!-- End Header -->

  <!-- Main -->
  <main id="main">
    <div class="container">
      <!-- Collection -->
      <section id="collection" class="section collection">
        <div class="collection__container" data-aos="fade-up" data-aos-duration="1200">
          <div class="collection__box">
            <div class="img__container">
              <img class="collection_02" src="<?= $CACHE_BUSTER('/img/house_1.jpg') ?>" alt="">
            </div>
            <div class="collection__content">
              <div class="collection__data">
                <span>New designs Introduced</span>
                <h1>Best HOUSES</h1>
                <a href="#lastest">BUY NOW</a>
              </div>
            </div>
          </div>
          <div class="collection__box">
            <div class="img__container">
              <img class="collection_01" src="<?= $CACHE_BUSTER('/img/house_2.jpg') ?>" alt="">
            </div>
            <div class="collection__content">
              <div class="collection__data">
                <span>House Presets</span>
                <h1>Affordable HOUSES</h1>
                <a href="#lastest">BUY NOW</a>
              </div>
            </div>
          </div>
      </section>

      <!-- Latest Products -->
      <section class="section latest__products" id="latest">
        <div class="title__container">
          <div class="section__title active" data-id="Latest Products">
            <span class="dot"></span>
            <h1 class="primary__title" id="lastest">Latest Products</h1>
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

      <section class="category__section section" id="category">
        <div class="tab__list">
          <div class="title__container tabs">
            <div class="section__titles category__titles ">
              <div class="section__title filter-btn active" data-id="All Products">
                <span class="dot"></span>
                <h1 class="primary__title">All Products</h1>
              </div>
            </div>
            <div class="section__titles">
              <div class="section__title filter-btn" data-id="Trending Products">
                <span class="dot"></span>
                <h1 class="primary__title">Trending Products</h1>
              </div>
            </div>

            <div class="section__titles">
              <div class="section__title filter-btn" data-id="Special Products">
                <span class="dot"></span>
                <h1 class="primary__title">Special Products</h1>
              </div>
            </div>

            <div class="section__titles">
              <div class="section__title filter-btn" data-id="Featured Products">
                <span class="dot"></span>
                <h1 class="primary__title">Featured Products</h1>
              </div>
            </div>

          </div>
        </div>
        <div class="category__container" data-aos="fade-up" data-aos-duration="1200">
          <div class="category__center"></div>
        </div>
    </div>
    </section>

    </div>

    <!-- Testimonial Section -->
    <section class="section testimonial" id="testimonial">
      <div class="testimonial__container">
        <div class="glide" id="glide_4">
          <div class="glide__track" data-glide-el="track">
            <ul class="glide__slides">
              <li class="glide__slide">
                <div class="testimonial__box">
                  <div class="client__image">
                    <img src="<?= $CACHE_BUSTER('/img/profile1.jpg') ?>" alt="profile">
                  </div>
                  <p>Looking for an honest person...you found the right place.</p>
                  <div class="client__info">
                    <h3>Mr Kolawole</h3>
                    <span>Business man</span>
                  </div>
                </div>
              </li>
              <li class="glide__slide">
                <div class="testimonial__box">
                  <div class="client__image">
                    <img src="<?= $CACHE_BUSTER('/img/profile2.jpg') ?>" alt="profile">
                  </div>
                  <p>I know i now have the most beautiful house.</p>
                  <div class="client__info">
                    <h3>Mary Chen</h3>
                    <span>Founder at Annex Foundation</span>
                  </div>
                </div>
              </li>
              <li class="glide__slide">
                <div class="testimonial__box">
                  <div class="client__image">
                    <img src="<?= $CACHE_BUSTER('/img/profile3.jpg') ?>" alt="profile">
                  </div>
                  <p>I bought my first house from naxtrust real estate, and I have never had an issue working with the company!.</p>
                  <div class="client__info">
                    <h3>Mr Johnson Ejiro</h3>
                    <span>dealer and crypto trader</span>
                  </div>
                </div>

              </li>
              <li class="glide__slide">
                <div class="testimonial__box">
                  <div class="client__image">
                    <img src="<?= $CACHE_BUSTER('/img/profile4.jpg') ?>" alt="">
                  </div>
                  <p>What can I say, I get best items for cheap prices</p>
                  <div class="client__info">
                    <h3>John Dan</h3>
                    <span>Student(UNN)</span>
                  </div>
                </div>
              </li>
            </ul>
          </div>

          <div class="glide__bullets" data-glide-el="controls[nav]">
            <button class="glide__bullet" data-glide-dir="=0"></button>
            <button class="glide__bullet" data-glide-dir="=1"></button>
            <button class="glide__bullet" data-glide-dir="=2"></button>
            <button class="glide__bullet" data-glide-dir="=3"></button>
          </div>
        </div>
      </div>
    </section>

    <!--New Section  -->
    <section class="section news" id="news">
      <div class="container">
        <div class="title__container">
          <div class="section__titles">
            <div class="section__title active">
              <span class="dot"></span>
              <h1 class="primary__title">House News</h1>
            </div>
          </div>
        </div>
        <div class="news__container">
          <div class="glide" id="glide_5">
            <div class="glide__track" data-glide-el="track">
              <ul class="glide__slides">
                <li class="glide__slide">
                  <div class="new__card">
                    <div class="card__header">
                      <img src="<?= $CACHE_BUSTER('/img/news1.jpg') ?>" alt="">
                    </div>
                    <div class="card__footer">
                      <h3>what will you love for Christmas?</h3>
                      <span>By Admin</span>
                      <p>Take the wheel and spin to win fanastic prices</p>
                      <a href="#">Read More</a>
                    </div>
                  </div>
                </li>
                <li class="glide__slide">
                  <div class="new__card">
                    <div class="card__header">
                      <img src="<?= $CACHE_BUSTER('/img/news2.jpg') ?>" alt="">
                    </div>
                    <div class="card__footer">
                      <h3>Black Friday coming soon!</h3>
                      <span>By Admin</span>
                      <p>Enjoy up to 50% discount on all HOUSES in this coming black Friday!</p>
                      <a href="#">Read More</a>
                    </div>
                  </div>
                </li>
                <li class="glide__slide">
                  <div class="new__card">
                    <div class="card__header">
                      <img src="<?= $CACHE_BUSTER('/img/news3.jpg') ?>" alt="">
                    </div>
                    <div class="card__footer">
                      <h3>Making payment is now easier</h3>
                      <span>By Admin</span>
                      <p>You can make payment in a faster means than before</p>
                      <a href="#">Read More</a>
                    </div>
                  </div>
                </li>
                <li class="glide__slide">
                  <div class="new__card">
                    <div class="card__header">
                      <img src="<?= $CACHE_BUSTER('/img/news4.jpg') ?>" alt="">
                    </div>
                    <div class="card__footer">
                      <h3>Best customer of the month</h3>
                      <span>By Admin</span>
                      <p>We have revealed by far, the best person to patronize us.</p>
                      <a href="#">Read More</a>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- NewsLetter -->
    <section class="section newsletter" id="contact">
      <div class="container" id="newsletter">
        <div class="newsletter__content">
          <div class="newsletter__data">
            <h3>SUBSCRIBE TO OUR NEWSLETTER</h3>
            <p>A short sentence describing what someone will receive by subscribing</p>
          </div>
          <form action="#">
            <input type="email" placeholder="Enter your email address" class="newsletter__email">
            <a class="newsletter__link" href="#">subscribe</a>
          </form>
        </div>
      </div>
    </section>

  </main>

  <!-- End Main -->

  <!-- Facility Section -->
  <?php require_once "{$constantVar('root')}/partials/footer.php"; ?>
  <!-- End Footer -->

  <!-- PopUp -->
  <div class="popup hide__popup">
    <div class="popup__content">
      <div class="popup__close">
        <svg>
          <use xlink:href="/img/sprite.svg#icon-cross"></use>
        </svg>
      </div>
      <div class="popup__left">
        <div class="popup-img__container">
          <img class="popup__img" src="<?= $CACHE_BUSTER('/img/popup.jpg') ?>" alt="popup">
        </div>
      </div>
      <div class="popup__right">
        <div class="right__content">
          <h1>Get Discount <span>30%</span> Off</h1>
          <p>Sign up to our newsletter and save 30% for you next purchase. No spam, we promise!
          </p>
          <form action="#">
            <input type="email" placeholder="Enter your email..." class="popup__form newsletter__email">
            <a href="#" class="newsletter__link">Subscribe</a>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Go To -->

  <a href="#header" class="goto-top scroll-link">
    <svg>
      <use xlink:href="/img/sprite.svg#icon-arrow-up"></use>
    </svg>
  </a>
</body>

</html>