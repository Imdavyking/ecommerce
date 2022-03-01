<?php
if (!defined('root')) define('root', $_SERVER['DOCUMENT_ROOT']);
$constantVar = function ($name) {
    return constant($name);
};
require_once "{$constantVar('root')}/includes/user_cart_items.php";
require_once "{$constantVar('root')}/includes/checkLogin.php";
$totalItemCost = 0;

require_once "{$constantVar('root')}/includes/common_data.inc.php";
outPutMinified('htmlStart');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "{$constantVar('root')}/partials/meta_tags.php"; ?>
    <link rel="stylesheet" href="<?= $CACHE_BUSTER('/css/cart.min.css') ?>" />
    <script src="<?= $CACHE_BUSTER('/js/cart.min.js') ?>" defer></script>
    <script src="/vendor/paystack/inline.js" nonce="<?= $_SESSION['nonce'] ?>" integrity="sha256-yWBBmkfJZmY0euPtODIO1rEg2nVcrZDruWoTvI6poq0=" defer></script>
    <title>Cart | <?= $CONSTANT('COMPANY_DEFAULT_TITLE') ?></title>
</head>

<body data-userCartItemsIds="<?= json_encode($cartItemsIds ?? []) ?>" data-userid="<?= htmlspecialchars($loginResult['user_id'] ?? '') ?>" data-email="<?= htmlspecialchars($loginResult['email'] ?? '') ?>" data-phone="<?= htmlspecialchars($loginResult['phone'] ?? '') ?>">
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
                        <li class="page__title">Cart</li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <main id="main">
        <section class="section cart__area">
            <div class="container">
                <div class="responsive__cart-area">
                    <form class="cart__form">
                        <div class="cart__table table-responsive">
                            <table width="100%" class="table">
                                <thead>
                                    <tr>
                                        <th>PRODUCT</th>
                                        <th>NAME</th>
                                        <th>UNIT PRICE</th>
                                        <th>QUANTITY</th>
                                        <th>TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($isLoggedIn) : ?>
                                        <?php foreach ($cartItems as $cart) : ?>
                                            <tr>
                                                <td class="product__thumbnail">
                                                    <a href="/house/product?id=<?= rawurlencode($cart['id']) ?>">
                                                        <img src="<?= htmlspecialchars($CACHE_BUSTER($cart['image'])) ?>" alt="">
                                                    </a>
                                                </td>
                                                <td class="product__name">
                                                    <a href="#"><?= htmlspecialchars($cart['title']) ?></a>
                                                    <br><br>
                                                    <small>White/6.25</small>
                                                </td>
                                                <td class="product__price">
                                                    <div class="price">
                                                        <span class="new__price" data-price="<?= htmlspecialchars($cart['price']) ?>">$<?= number_format(htmlspecialchars($cart['price'])) ?></span>
                                                        <?php $totalItemCost += $cart['price'] * $cart['product_quantity'] ?>
                                                    </div>
                                                </td>
                                                <td class="product__quantity">
                                                    <div class="input-counter">
                                                        <div>
                                                            <span class="minus-btn">
                                                                <svg>
                                                                    <use xlink:href="/img/sprite.svg#icon-minus"></use>
                                                                </svg>
                                                            </span>
                                                            <input type="text" min="1" value="<?= htmlspecialchars($cart['product_quantity']) ?>" max="10" class="counter-btn">
                                                            <span class="plus-btn">
                                                                <svg>
                                                                    <use xlink:href="/img/sprite.svg#icon-plus"></use>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="product__subtotal">
                                                    <div class="price">
                                                        <span class="new__price updated__price">$<?= number_format(htmlspecialchars($cart['price'] * $cart['product_quantity'])) ?></span>
                                                    </div>
                                                    <a href="#" class="remove__cart-item" data-id="<?= htmlspecialchars($cart['id']) ?>">
                                                        <svg>
                                                            <use xlink:href="/img/sprite.svg#icon-trash"></use>
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="cart-btns">
                            <div class="continue__shopping">
                                <a href="/" class="link_responsive">Continue Shopping</a>
                            </div>
                            <label>
                                <div class="check__shipping">
                                    <input type="checkbox" class="check__shipping__checkbox">
                                    <span id="shipping-fee" data-fee="7">Shipping(+$7)</span>
                                </div>
                            </label>
                        </div>

                        <div class="cart__totals">
                            <h3>Cart Totals</h3>
                            <ul>
                                <li>
                                    Subtotal
                                    <span class="new__price subtotal">$<?= number_format(htmlspecialchars($totalItemCost)) ?></span>
                                </li>
                                <li>
                                    Shipping
                                    <span class="shipping__fee">$0</span>
                                </li>
                                <li>
                                    Total
                                    <span class="new__price total__cost">$<?= number_format(htmlspecialchars($totalItemCost)) ?></span>
                                </li>
                            </ul>
                            <a href="#!" class="link_responsive" id="check_out_and_pay">PROCEED TO CHECKOUT</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>


    </main>
    <?php require_once "{$constantVar('root')}/partials/footer.php"; ?>

    <a href="#header" class="goto-top scroll-link">
        <svg>
            <use xlink:href="/img/sprite.svg#icon-arrow-up"></use>
        </svg>
    </a>
</body>

</html>