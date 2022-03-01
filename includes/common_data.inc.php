<?php
if (!defined('root')) define('root', $_SERVER['DOCUMENT_ROOT']);
if (!defined('debug')) define('debug', true);
if (!session_id()) session_start();
$_SESSION['nonce'] = sha1(random_bytes(64));
if (!isset($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = sha1(random_bytes(64));
header("X-CSRF-TOKEN: {$_SESSION['csrf_token']}");
header("Content-Security-Policy:default-src 'self' ;script-src 'self' 'nonce-{$_SESSION['nonce']}';form-action 'self';block-all-mixed-content;style-src 'self' paystack.com *.paystack.com 'unsafe-inline';frame-src *.paystack.com ");

date_default_timezone_set('Africa/lagos');
$constantVar = function ($name) {
  return constant($name);
};
require_once "{$constantVar('root')}/includes/checkLogin.php";
require_once "{$constantVar('root')}/includes/user_cart_items.php";

$userConfig = [
  'company_name' => 'NaxTrust RealEstate',
  'company_certificate' => 'https://beta.companieshouse.gov.uk/company/SC155714',
  'company_email' => 'info@naxtrust.com',
  'country' => 'Nigeria',
  'state' => 'Lagos',
  'continent' => 'Africa',
  'company_default_title' => 'NaxTrust RealEstate',
  'company_description' => 'Get quality housing and phones at affordable price',
  'company_pwa_theme_color' => 'black',
  'term_of_service_last_updated_date' => '2nd August, 2022',
  'current_year' => date('Y'),
  'address' => 'cool, uk',
  'phone' => '+234801234456',
  'vapid_PublicKey' => 'BCpdEt0sWGGw6gMmKthAFxMO1vGzi73UM0s4o6lTcvnByfu3ZVyenJlopjIahi-qVKH6kC7Jqu4vJlvnSzrw_tw',
  'vapid_PrivateKey' => 'RSNx0wJegNU1vYVwo0BrCCfq0590UmIawRKpWkcveZY'
];
$CONSTANT = function ($constantName) {
  return constant($constantName);
};

/**
 * RETURNS THE VALUE OF A FUNCTION
 * @param string $functionName
 */
$FUNCTION = function ($functionName, ...$functionArguments) {
  return $functionName(...$functionArguments);
};

/**
 * RETURNS A RANDOM STRING OF A GIVEN LENGTH
 * @param int $length - length of random string to return
 * @param string $keyspace - charset of string to use
 * @return string 
 */
function random_str($length = 24, $numbers_only = false, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
  if ($numbers_only) $keyspace = '0123456789';
  if ($length < 1) throw new \RangeException("Length must be a positive integer");
  $pieces = [];
  $max = mb_strlen($keyspace, '8bit') - 1;
  for ($i = 0; $i < $length; ++$i) $pieces[] = $keyspace[random_int(0, $max)];
  return implode('', $pieces);
}


/**
 * GIVES CLIENT ADEQUATE WAY TO BUST CACHE ON BROWSER
 * @param string $rootRelativeFileName - a file starting from root i.e /js/main.min.js
 * @return string the file cache busting file name
 */
$CACHE_BUSTER = function ($rootRelativeFileName) use ($FUNCTION) {
  return FILE_CACHE_BUSTER[strtolower($rootRelativeFileName)] ?? "$rootRelativeFileName?v={$FUNCTION("time")}";
};

function minifier($buffer)
{
  $search = [
    '/\>[^\S ]+/s',
    '/[^\S ]+\</s',
    '/(\s)+/s',
    '/<!--(.|\s)*?-->/'
  ];

  $replace = [
    '>',
    '<',
    '\\1',
    ''
  ];
  $blocks = preg_split('/(<\/?pre[^>]*>)/', $buffer, 0, PREG_SPLIT_DELIM_CAPTURE);

  $buffer = '';

  foreach ($blocks as $i => $block) ($i % 4 === 2) ? ($buffer .= $block) : ($buffer .= preg_replace($search, $replace, $block));
  return $buffer;
}

function outPutMinified($filePointer)
{
  return [
    'htmlStart' => ob_start('minifier'),
    'htmlEnd' => ob_flush()
  ][$filePointer];
}

function makeNotFoundIfNotRequestUrl($request_url)
{
  if ($_SERVER['REQUEST_URI'] !== $request_url) {
    $_SERVER['REDIRECT_STATUS'] = 404;
    http_response_code(404);
    return true;
  }
  return false;
}


DEFINE(
  'FILE_CACHE_BUSTER',
  json_decode(file_exists("{$CONSTANT('root')}/json/cacheBuster.min.json") ? file_get_contents("{$CONSTANT('root')}/json/cacheBuster.min.json") : '{}', true)
);
DEFINE('CURRENT_YEAR', "{$userConfig['current_year']}");
DEFINE('COMPANY_NAME', "{$userConfig['company_name']}");
DEFINE('COMPANY_EMAIL', "{$userConfig['company_email']}");
DEFINE('TERM_OF_SERVICE_LAST_UPDATED_DATE', "{$userConfig['term_of_service_last_updated_date']}");
DEFINE('COUNTRY', "{$userConfig['country']}");
DEFINE('STATE', "{$userConfig['state']}");
DEFINE('CONTINENT', "{$userConfig['continent']}");
DEFINE('COMPANY_WEBSITE', '/');
DEFINE('TERM_OF_SERVICE_HEADING', 'Terms of Service');
DEFINE('SERVER_HTTP_SCHEME', 'https');
DEFINE('COMPANY_WEBSITE_URL', "{$CONSTANT('SERVER_HTTP_SCHEME')}://{$_SERVER['SERVER_NAME']}");
DEFINE('COMPANY_DEFAULT_TITLE', "{$userConfig['company_default_title']}");
DEFINE('COMPANY_DESCRIPTION', "{$userConfig['company_description']}");
DEFINE('COMPANY_OPEN_GRAPH_IMAGE_URL', "{$CONSTANT('COMPANY_WEBSITE_URL')}{$CACHE_BUSTER('/favicon.ico')}");
DEFINE('COMPANY_PWA_THEME_COLOR', "{$userConfig['company_pwa_theme_color']}");
DEFINE('TITLE_HEADING', " | {$CONSTANT('COMPANY_DEFAULT_TITLE')}");
