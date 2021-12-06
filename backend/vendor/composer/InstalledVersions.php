<?php











namespace Composer;

use Composer\Autoload\ClassLoader;
use Composer\Semver\VersionParser;






class InstalledVersions
{
private static $installed = array (
  'root' => 
  array (
    'pretty_version' => '1.0.0+no-version-set',
    'version' => '1.0.0.0',
    'aliases' => 
    array (
    ),
    'reference' => NULL,
    'name' => '__root__',
  ),
  'versions' => 
  array (
    '__root__' => 
    array (
      'pretty_version' => '1.0.0+no-version-set',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => NULL,
    ),
    'cboden/ratchet' => 
    array (
      'pretty_version' => 'v0.4.1',
      'version' => '0.4.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '0d31f3a8ad4795fd48397712709e55cd07f51360',
    ),
    'doctrine/inflector' => 
    array (
      'pretty_version' => 'v1.3.0',
      'version' => '1.3.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '5527a48b7313d15261292c149e55e26eae771b0a',
    ),
    'evenement/evenement' => 
    array (
      'pretty_version' => 'v3.0.1',
      'version' => '3.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '531bfb9d15f8aa57454f5f0285b18bec903b8fb7',
    ),
    'guzzlehttp/psr7' => 
    array (
      'pretty_version' => '1.4.2',
      'version' => '1.4.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f5b8a8512e2b58b0071a7280e39f14f72e05d87c',
    ),
    'illuminate/container' => 
    array (
      'pretty_version' => 'v5.6.3',
      'version' => '5.6.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '4a42d667a05ec6d31f05b532cdac7e8e68e5ea2a',
    ),
    'illuminate/contracts' => 
    array (
      'pretty_version' => 'v5.6.3',
      'version' => '5.6.3.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f5d3ca46ec931e78fe961e52940e56fb7a0e6707',
    ),
    'illuminate/database' => 
    array (
      'pretty_version' => 'v5.6.3',
      'version' => '5.6.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '73b0b9c9b1b55ab0cffb558a8b68d533e98c86c3',
    ),
    'illuminate/support' => 
    array (
      'pretty_version' => 'v5.6.3',
      'version' => '5.6.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '08f8b351a77efebfe3650e069ffa3f21a9a308d7',
    ),
    'nesbot/carbon' => 
    array (
      'pretty_version' => '1.22.1',
      'version' => '1.22.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '7cdf42c0b1cc763ab7e4c33c47a24e27c66bfccc',
    ),
    'phpmailer/phpmailer' => 
    array (
      'pretty_version' => 'v6.0.3',
      'version' => '6.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '44d49bab5ab1fef721d3ee07e75dc0865ddf4cc6',
    ),
    'psr/container' => 
    array (
      'pretty_version' => '1.0.0',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b7ce3b176482dbbc1245ebf52b181af44c2cf55f',
    ),
    'psr/http-message' => 
    array (
      'pretty_version' => '1.0.1',
      'version' => '1.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f6561bf28d520154e4b0ec72be95418abe6d9363',
    ),
    'psr/http-message-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'psr/simple-cache' => 
    array (
      'pretty_version' => '1.0.0',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '753fa598e8f3b9966c886fe13f370baa45ef0e24',
    ),
    'ratchet/rfc6455' => 
    array (
      'pretty_version' => '0.2.4',
      'version' => '0.2.4.0',
      'aliases' => 
      array (
      ),
      'reference' => '1612f528c3496ad06e910d0f8b6f16ab97696706',
    ),
    'react/cache' => 
    array (
      'pretty_version' => 'v0.5.0',
      'version' => '0.5.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '7d7da7fb7574d471904ba357b39bbf110ccdbf66',
    ),
    'react/dns' => 
    array (
      'pretty_version' => 'v0.4.15',
      'version' => '0.4.15.0',
      'aliases' => 
      array (
      ),
      'reference' => '319e110a436d26a2fa137cfa3ef2063951715794',
    ),
    'react/event-loop' => 
    array (
      'pretty_version' => 'v1.0.0',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '0266aff7aa7b0613b1f38a723e14a0ebc55cfca3',
    ),
    'react/promise' => 
    array (
      'pretty_version' => 'v2.7.0',
      'version' => '2.7.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f4edc2581617431aea50430749db55cc3fc031b3',
    ),
    'react/promise-timer' => 
    array (
      'pretty_version' => 'v1.5.0',
      'version' => '1.5.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a11206938ca2394dc7bb368f5da25cd4533fa603',
    ),
    'react/socket' => 
    array (
      'pretty_version' => 'v1.0.0',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '476e2644a634c6301b8111e6d22a61679e6e6bd0',
    ),
    'react/stream' => 
    array (
      'pretty_version' => 'v1.0.0',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'fdd0140f42805d65bf9687636503db0b326d2244',
    ),
    'symfony/http-foundation' => 
    array (
      'pretty_version' => 'v4.1.4',
      'version' => '4.1.4.0',
      'aliases' => 
      array (
      ),
      'reference' => '3a5c91e133b220bb882b3cd773ba91bf39989345',
    ),
    'symfony/polyfill-mbstring' => 
    array (
      'pretty_version' => 'v1.7.0',
      'version' => '1.7.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '78be803ce01e55d3491c1397cf1c64beb9c1b63b',
    ),
    'symfony/routing' => 
    array (
      'pretty_version' => 'v4.1.4',
      'version' => '4.1.4.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a5784c2ec4168018c87b38f0e4f39d2278499f51',
    ),
    'symfony/translation' => 
    array (
      'pretty_version' => 'v3.4.4',
      'version' => '3.4.4.0',
      'aliases' => 
      array (
      ),
      'reference' => '10b32cf0eae28b9b39fe26c456c42b19854c4b84',
    ),
    'tightenco/collect' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.6.3',
      ),
    ),
    'yabacon/paystack-php' => 
    array (
      'pretty_version' => 'v2.2.0',
      'version' => '2.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e22effef1aad23ec9abcef16c3e7be83fe8b47fa',
    ),
  ),
);
private static $canGetVendors;
private static $installedByVendor = array();







public static function getInstalledPackages()
{
$packages = array();
foreach (self::getInstalled() as $installed) {
$packages[] = array_keys($installed['versions']);
}


if (1 === \count($packages)) {
return $packages[0];
}

return array_keys(array_flip(\call_user_func_array('array_merge', $packages)));
}









public static function isInstalled($packageName)
{
foreach (self::getInstalled() as $installed) {
if (isset($installed['versions'][$packageName])) {
return true;
}
}

return false;
}














public static function satisfies(VersionParser $parser, $packageName, $constraint)
{
$constraint = $parser->parseConstraints($constraint);
$provided = $parser->parseConstraints(self::getVersionRanges($packageName));

return $provided->matches($constraint);
}










public static function getVersionRanges($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

$ranges = array();
if (isset($installed['versions'][$packageName]['pretty_version'])) {
$ranges[] = $installed['versions'][$packageName]['pretty_version'];
}
if (array_key_exists('aliases', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['aliases']);
}
if (array_key_exists('replaced', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['replaced']);
}
if (array_key_exists('provided', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['provided']);
}

return implode(' || ', $ranges);
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getVersion($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['version'])) {
return null;
}

return $installed['versions'][$packageName]['version'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getPrettyVersion($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['pretty_version'])) {
return null;
}

return $installed['versions'][$packageName]['pretty_version'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getReference($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['reference'])) {
return null;
}

return $installed['versions'][$packageName]['reference'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getRootPackage()
{
$installed = self::getInstalled();

return $installed[0]['root'];
}







public static function getRawData()
{
return self::$installed;
}



















public static function reload($data)
{
self::$installed = $data;
self::$installedByVendor = array();
}




private static function getInstalled()
{
if (null === self::$canGetVendors) {
self::$canGetVendors = method_exists('Composer\Autoload\ClassLoader', 'getRegisteredLoaders');
}

$installed = array();

if (self::$canGetVendors) {

foreach (ClassLoader::getRegisteredLoaders() as $vendorDir => $loader) {
if (isset(self::$installedByVendor[$vendorDir])) {
$installed[] = self::$installedByVendor[$vendorDir];
} elseif (is_file($vendorDir.'/composer/installed.php')) {
$installed[] = self::$installedByVendor[$vendorDir] = require $vendorDir.'/composer/installed.php';
}
}
}

$installed[] = self::$installed;

return $installed;
}
}
