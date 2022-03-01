<?php
require_once "{$constantVar('root')}/includes/common_data.inc.php";
?>
<noscript>
  <div class="javascript-disable">This site uses Javascript to function,please consider enabling it</div>
  <link rel="stylesheet" href="<?= $CACHE_BUSTER('/css/noscript.min.css') ?>">
</noscript>
<section class='facility__section section' id='facility'>
  <div class='container'>
    <div class='facility__contianer' data-aos='fade-up' data-aos-duration='1200'>
      <div class='facility__box'>
        <div class='facility-img__container'>
          <svg>
            <use xlink:href='/img/sprite.svg#icon-airplane'></use>
          </svg>
        </div>
        <p>SHIPPING WORLD WIDE</p>
      </div>

      <div class='facility__box'>
        <div class='facility-img__container'>
          <svg>
            <use xlink:href='/img/sprite.svg#icon-credit-card-alt'></use>
          </svg>
        </div>
        <p>100% MONEY BACK GUARANTEE</p>
      </div>

      <div class='facility__box'>
        <div class='facility-img__container'>
          <svg>
            <use xlink:href='/img/sprite.svg#icon-credit-card'></use>
          </svg>
        </div>
        <p>MANY PAYMENT GATEWAYS</p>
      </div>

      <div class='facility__box'>
        <div class='facility-img__container'>
          <svg>
            <use xlink:href='/img/sprite.svg#icon-headphones'></use>
          </svg>
        </div>
        <p>24/7 ONLINE SUPPORT</p>
      </div>
    </div>
  </div>
</section>
<!-- Cookie Compliance -->
<div class="cookie-banner">
  <div id="cookie-law">
    <p class="eu-compliance-cookie">
      <span class="cookie-info">
        <span>This website uses cookies to personalize contents, and offer a better browsing experience.By continuing we assume your permission to deploy cookies. <a href="#!">Cookie policy</a></span>
        <i class="fa fa-times close-cookie-banner"></i>
      </span>
      <br>
    </p>
  </div>
</div>
<!-- Footer -->
<footer id='footer' class='section footer'>
  <div class='container'>
    <div class='footer__top'>
      <div class='footer-top__box'>
        <h3>EXTRAS</h3>
        <a href='#'>Brands</a>
        <a href='#'>Gift Certificates</a>
        <a href='#'>Affiliate</a>
        <a href='#'>Specials</a>
        <a href='/sitemap.xml'>Site Map</a>
      </div>
      <div class='footer-top__box'>
        <h3>INFORMATION</h3>
        <a href='#'>About Us</a>
        <a href='/house/terms'>Privacy Policy</a>
        <a href='/house/terms'>Terms & Conditions</a>
        <a href='#contact_us'>Contact Us</a>
        <a href='/sitemap.xml'>Site Map</a>
      </div>
      <div class='footer-top__box'>
        <h3>MY ACCOUNT</h3>
        <a href='#'>My Account</a>
        <a href='#'>Order History</a>
        <a href='#'>Wish List</a>
        <a href='#newsletter'>Newsletter</a>
        <a href='#'>Returns</a>
      </div>
      <div class='footer-top__box'>
        <h3 id="contact_us">CONTACT US</h3>
        <div>
          <span>
            <svg>
              <use xlink:href='/img/sprite.svg#icon-location'></use>
            </svg>
          </span>
          <?= $userConfig['address'] ?>
        </div>
        <a href='mailto:<?= $userConfig['company_email'] ?>'>
          <div>
            <span>
              <svg>
                <use xlink:href='/img/sprite.svg#icon-envelop'></use>
              </svg>
            </span>
            <?= $userConfig['company_email'] ?>
          </div>
        </a>
        <a href='tel:<?= $userConfig['phone'] ?>'>
          <div>
            <span>
              <svg>
                <use xlink:href='/img/sprite.svg#icon-phone'></use>
              </svg>
            </span>
            <?= $userConfig['phone'] ?>
          </div>
        </a>

        <div>
          <span>
            <svg>
              <use xlink:href='/img/sprite.svg#icon-paperplane'></use>
            </svg>
          </span>
          <?= $userConfig['state'] ?>,<?= $userConfig['country'] ?>
        </div>
        <a rel="noopener" target="_blank" href='//www.fb.com' aria-label="facebook">
          <div>
            <span>
              <i class="fab social-link fa-facebook"></i>
            </span>
            Facebook
          </div>
        </a>
        <a rel="noopener" target="_blank" href='//www.twitter.com' aria-label="twitter">
          <div>
            <span>
              <i class="fab social-link fa-twitter"></i>
            </span>
            Twitter
          </div>
        </a>
        <a rel="noopener" target="_blank" href='//www.instagram.com' aria-label="instagram">
          <div>
            <span>
              <i class="fab social-link fa-instagram"></i>
            </span>
            Instagram
          </div>
        </a>
        <div>
          <span>
            &copy; <?= $userConfig['company_name'] ?>,<?= date('Y') ?>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class='footer__bottom'>
    <div class='footer-bottom__box'>

    </div>
    <div class='footer-bottom__box'>

    </div>
  </div>
</footer>