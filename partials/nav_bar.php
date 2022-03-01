<?php require_once "{$constantVar('root')}/includes/common_data.inc.php"; ?>

<nav class='nav'>
  <div class='nav__hamburger'>
    <svg>
      <use xlink:href='/img/sprite.svg#icon-menu'></use>
    </svg>
  </div>

  <div class='nav__logo'>
    <a href='/' class='scroll-link'>
      <?= $userConfig['company_name'] ?>
    </a>
  </div>

  <div class='nav__menu'>
    <div class='menu__top'>
      <span class='nav__category'><?= $userConfig['company_name'] ?></span>
      <a href='#' class='close__toggle'>
        <svg>
          <use xlink:href='/img/sprite.svg#icon-cross'></use>
        </svg>
      </a>
    </div>
    <ul class='nav__list'>
      <li class='nav__item'>
        <a href='/' class='nav__link'>Home</a>
      </li>
      <li class='nav__item'>
        <a href='/house/product?id=1' class='nav__link'>Products</a>
      </li>
      <li class='nav__item'>
        <a href='#' class='nav__link'>Blog</a>
      </li>
      <li class='nav__item'>
        <a href='#contact_us' class='nav__link'>Contact</a>
      </li>
    </ul>
  </div>

  <div class='nav__icons'>
    <a href="/house/<?= ($isLoggedIn ? "logout?csrf_token={$_SESSION['csrf_token']}" : 'login') ?>" class='icon__item'>
      <?= ($isLoggedIn ? '<i class="fa fa-sign-out-alt" title="logged in"></i>'
        : '<svg class="icon__user"><use xlink:href="/img/sprite.svg#icon-user"></use></svg>') ?>
    </a>
    <a href='#!' class='icon__item button-open'>
      <svg class='icon__search'>
        <use xlink:href='/img/sprite.svg#icon-search'></use>
      </svg>
    </a>

    <a href='/house/cart' class='icon__item'>
      <svg class='icon__cart'>
        <use xlink:href='/img/sprite.svg#icon-shopping-basket'></use>
      </svg>
      <span id='cart__total'><?= $FUNCTION('htmlspecialchars', ($totalCartItem ?? 0)) ?></span>
    </a>
  </div>

  <div class="overlay hiding">
    <button class="button button-close">
      <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" class="icon">
        <rect class="fill-none" width="32" height="32"></rect>
        <path class="fill-currentcolor" d="M18.82813,16,29.41406,5.41406a1.99979,1.99979,0,0,0-2.82812-2.82812L16,13.17188,5.41406,2.58594A1.99979,1.99979,0,0,0,2.58594,5.41406L13.17188,16,2.58594,26.58594a1.99979,1.99979,0,1,0,2.82813,2.82813L16,18.82813,26.58594,29.41406a1.99979,1.99979,0,0,0,2.82813-2.82812Z"></path>
      </svg>
    </button>

    <div class="autocomplelete-search">
    </div>

    <form action="/house/search" class="form-search">
      <label for="keywords" class="visuallyhidden">Search</label>
      <input type="hidden" name="page" value="1">
      <input class="input input-search" id="keywords" name="query" type="text" placeholder="Find something…" autocomplete="off" autocorrect="off" autocapitalize="off" required>
      <button type="submit" class="button button-search">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" class="icon">
          <rect class="fill-none" width="32" height="32"></rect>
          <path class="fill-currentcolor" d="M29.82861,24.17139,25.56519,19.908A13.0381,13.0381,0,1,0,19.908,25.56525l4.26343,4.26337a4.00026,4.00026,0,0,0,5.65723-5.65723ZM5,14a9,9,0,1,1,9,9A9.00984,9.00984,0,0,1,5,14Z"></path>
        </svg>
      </button>
    </form>
  </div>

</nav>