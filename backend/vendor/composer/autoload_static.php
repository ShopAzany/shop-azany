<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit81eb7d45cb86396167b941f75b6bed30
{
    public static $files = array (
        'ad155f8f1cf0d418fe49e248db8c661b' => __DIR__ . '/..' . '/react/promise/src/functions_include.php',
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        '6b06ce8ccf69c43a60a1e48495a034c9' => __DIR__ . '/..' . '/react/promise-timer/src/functions.php',
        'a0edc8309cc5e1d60e3047b5df6b7052' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/functions_include.php',
        '72579e7bd17821bb1321b87411366eae' => __DIR__ . '/..' . '/illuminate/support/helpers.php',
        'def43f6c87e4f8dfd0c9e1b1bab14fe8' => __DIR__ . '/..' . '/symfony/polyfill-iconv/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Polyfill\\Iconv\\' => 23,
            'Symfony\\Component\\Translation\\' => 30,
            'Symfony\\Component\\Routing\\' => 26,
            'Symfony\\Component\\HttpFoundation\\' => 33,
        ),
        'R' => 
        array (
            'React\\Stream\\' => 13,
            'React\\Socket\\' => 13,
            'React\\Promise\\Timer\\' => 20,
            'React\\Promise\\' => 14,
            'React\\EventLoop\\' => 16,
            'React\\Dns\\' => 10,
            'React\\Cache\\' => 12,
            'Ratchet\\RFC6455\\' => 16,
            'Ratchet\\' => 8,
        ),
        'P' => 
        array (
            'Psr\\SimpleCache\\' => 16,
            'Psr\\Http\\Message\\' => 17,
            'Psr\\Container\\' => 14,
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'I' => 
        array (
            'Illuminate\\Support\\' => 19,
            'Illuminate\\Database\\' => 20,
            'Illuminate\\Contracts\\' => 21,
            'Illuminate\\Container\\' => 21,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
        ),
        'D' => 
        array (
            'Doctrine\\Common\\Inflector\\' => 26,
        ),
        'C' => 
        array (
            'Carbon\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Polyfill\\Iconv\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-iconv',
        ),
        'Symfony\\Component\\Translation\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/translation',
        ),
        'Symfony\\Component\\Routing\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/routing',
        ),
        'Symfony\\Component\\HttpFoundation\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/http-foundation',
        ),
        'React\\Stream\\' => 
        array (
            0 => __DIR__ . '/..' . '/react/stream/src',
        ),
        'React\\Socket\\' => 
        array (
            0 => __DIR__ . '/..' . '/react/socket/src',
        ),
        'React\\Promise\\Timer\\' => 
        array (
            0 => __DIR__ . '/..' . '/react/promise-timer/src',
        ),
        'React\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/react/promise/src',
        ),
        'React\\EventLoop\\' => 
        array (
            0 => __DIR__ . '/..' . '/react/event-loop/src',
        ),
        'React\\Dns\\' => 
        array (
            0 => __DIR__ . '/..' . '/react/dns/src',
        ),
        'React\\Cache\\' => 
        array (
            0 => __DIR__ . '/..' . '/react/cache/src',
        ),
        'Ratchet\\RFC6455\\' => 
        array (
            0 => __DIR__ . '/..' . '/ratchet/rfc6455/src',
        ),
        'Ratchet\\' => 
        array (
            0 => __DIR__ . '/..' . '/cboden/ratchet/src/Ratchet',
        ),
        'Psr\\SimpleCache\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/simple-cache/src',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Illuminate\\Support\\' => 
        array (
            0 => __DIR__ . '/..' . '/illuminate/support',
        ),
        'Illuminate\\Database\\' => 
        array (
            0 => __DIR__ . '/..' . '/illuminate/database',
        ),
        'Illuminate\\Contracts\\' => 
        array (
            0 => __DIR__ . '/..' . '/illuminate/contracts',
        ),
        'Illuminate\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/illuminate/container',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'Doctrine\\Common\\Inflector\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/inflector/lib/Doctrine/Common/Inflector',
        ),
        'Carbon\\' => 
        array (
            0 => __DIR__ . '/..' . '/nesbot/carbon/src/Carbon',
        ),
    );

    public static $prefixesPsr0 = array (
        'E' => 
        array (
            'Evenement' => 
            array (
                0 => __DIR__ . '/..' . '/evenement/evenement/src',
            ),
        ),
    );

    public static $classMap = array (
        'AboutUsTbl' => __DIR__ . '/../..' . '/app/models/AboutUsTbl.php',
        'Admin' => __DIR__ . '/../..' . '/app/models/Admin.php',
        'AdminLoginActivity' => __DIR__ . '/../..' . '/app/models/AdminLoginActivity.php',
        'Admin_bank' => __DIR__ . '/../..' . '/app/models/Admin_bank.php',
        'AdvertTbl' => __DIR__ . '/../..' . '/app/models/AdvertTbl.php',
        'BrandTbl' => __DIR__ . '/../..' . '/app/models/BrandTbl.php',
        'CategoriesChild' => __DIR__ . '/../..' . '/app/models/CategoriesChild.php',
        'CategoriesSubChild' => __DIR__ . '/../..' . '/app/models/CategoriesSubChild.php',
        'CategoryBanner' => __DIR__ . '/../..' . '/app/models/CategoryBanner.php',
        'CategoryHomeFeatured' => __DIR__ . '/../..' . '/app/models/CategoryHomeFeatured.php',
        'CategoryTbl' => __DIR__ . '/../..' . '/app/models/CategoryTbl.php',
        'CategoryVariation' => __DIR__ . '/../..' . '/app/models/CategoryVariation.php',
        'Cloudinery' => __DIR__ . '/../..' . '/app/classes/Cloudinary.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Config' => __DIR__ . '/../..' . '/app/classes/Config.php',
        'Configuration' => __DIR__ . '/../..' . '/app/models/Configuration.php',
        'Countries' => __DIR__ . '/../..' . '/app/classes/Countries.php',
        'Currency' => __DIR__ . '/../..' . '/app/classes/Currency.php',
        'CurrencyTbl' => __DIR__ . '/../..' . '/app/models/CurrencyTbl.php',
        'CusPagination' => __DIR__ . '/../..' . '/app/classes/CusPagination.php',
        'CustomDateTime' => __DIR__ . '/../..' . '/app/classes/CustomDateTime.php',
        'DBquery' => __DIR__ . '/../..' . '/app/classes/DBquery.php',
        'EmailNote' => __DIR__ . '/../..' . '/app/classes/Email.php',
        'Email_templates' => __DIR__ . '/../..' . '/app/models/Email_templates.php',
        'FaqTbl' => __DIR__ . '/../..' . '/app/models/FaqTbl.php',
        'FeatureProductBanner' => __DIR__ . '/../..' . '/app/models/FeatureProductBanner.php',
        'HeadersControl' => __DIR__ . '/../..' . '/app/classes/HeadersControl.php',
        'Helper' => __DIR__ . '/../..' . '/app/classes/Helper.php',
        'HomeBanners' => __DIR__ . '/../..' . '/app/models/HomeBanners.php',
        'HomeProductTbl' => __DIR__ . '/../..' . '/app/models/HomeProductTbl.php',
        'HomeSlider' => __DIR__ . '/../..' . '/app/models/HomeSliders.php',
        'HomeTopCategory' => __DIR__ . '/../..' . '/app/models/HomeTopCategory.php',
        'Images' => __DIR__ . '/../..' . '/app/classes/Images.php',
        'Input' => __DIR__ . '/../..' . '/app/classes/Input.php',
        'Invoices' => __DIR__ . '/../..' . '/app/models/Invoices.php',
        'InvoicesOLD' => __DIR__ . '/../..' . '/app/models/InvoicesOLD.php',
        'JWT' => __DIR__ . '/../..' . '/app/classes/JWT.php',
        'Menus' => __DIR__ . '/../..' . '/app/models/Menus.php',
        'Mobile_Detect' => __DIR__ . '/../..' . '/app/classes/Mobile_Detect.php',
        'OrderTrackingTbl' => __DIR__ . '/../..' . '/app/models/OrderTrackingTbl.php',
        'OrdersTbl' => __DIR__ . '/../..' . '/app/models/OrdersTbl.php',
        'OrdersTblOLD' => __DIR__ . '/../..' . '/app/models/OrdersTblOLD.php',
        'PHPMailer' => __DIR__ . '/../..' . '/app/classes/PHPMailer.php',
        'PageTbl' => __DIR__ . '/../..' . '/app/models/Pages.php',
        'Pagination' => __DIR__ . '/../..' . '/app/classes/pagination.php',
        'PaymentMethod' => __DIR__ . '/../..' . '/app/models/PaymentMethod.php',
        'Paypal' => __DIR__ . '/../..' . '/app/classes/Paypal.php',
        'Paystack' => __DIR__ . '/../..' . '/app/classes/Paystack.php',
        'Product' => __DIR__ . '/../..' . '/app/classes/Product.php',
        'ProductRatingTbl' => __DIR__ . '/../..' . '/app/models/ProductRatingTbl.php',
        'ProductVariation' => __DIR__ . '/../..' . '/app/models/ProductVariation.php',
        'ProductVariationOLD' => __DIR__ . '/../..' . '/app/models/ProductVariationOLD.php',
        'Products' => __DIR__ . '/../..' . '/app/models/Products.php',
        'Rating' => __DIR__ . '/../..' . '/app/classes/Rating.php',
        'Redirect' => __DIR__ . '/../..' . '/app/classes/Redirect.php',
        'SMS' => __DIR__ . '/../..' . '/app/classes/SMS.php',
        'SavedProductsTbl' => __DIR__ . '/../..' . '/app/models/SavedProductsTbl.php',
        'Seller' => __DIR__ . '/../..' . '/app/models/Seller.php',
        'SellerBankInfo' => __DIR__ . '/../..' . '/app/models/SellerBankInfo.php',
        'SellerBussinessInfo' => __DIR__ . '/../..' . '/app/models/SellerBussinessInfo.php',
        'SellerContent' => __DIR__ . '/../..' . '/app/models/SellerContent.php',
        'SellerLoginActivity' => __DIR__ . '/../..' . '/app/models/SellerLoginActivity.php',
        'SellerVerification' => __DIR__ . '/../..' . '/app/models/SellerVerification.php',
        'Session' => __DIR__ . '/../..' . '/app/classes/Session.php',
        'Settings' => __DIR__ . '/../..' . '/app/classes/Settings.php',
        'ShippingMethods' => __DIR__ . '/../..' . '/app/models/ShippingMethods.php',
        'ShopByCountry' => __DIR__ . '/../..' . '/app/models/ShopByCountry.php',
        'SocialSettingsTbl' => __DIR__ . '/../..' . '/app/models/SocialSettingsTbl.php',
        'Socials' => __DIR__ . '/../..' . '/app/classes/Socials.php',
        'Token' => __DIR__ . '/../..' . '/app/classes/Token.php',
        'Upload' => __DIR__ . '/../..' . '/app/classes/Upload.php',
        'UrlClass' => __DIR__ . '/../..' . '/app/classes/UrlClass.php',
        'User' => __DIR__ . '/../..' . '/app/models/User.php',
        'UserAddresses' => __DIR__ . '/../..' . '/app/models/UserAddresses.php',
        'UserLoginActivity' => __DIR__ . '/../..' . '/app/models/UserLoginActivity.php',
        'UserShoppingCart' => __DIR__ . '/../..' . '/app/models/UserShoppingCart.php',
        'User_notification' => __DIR__ . '/../..' . '/app/models/UserNotification.php',
        'User_verification' => __DIR__ . '/../..' . '/app/models/User_verification.php',
        'Validator' => __DIR__ . '/../..' . '/app/classes/Validator.php',
        'Vendor' => __DIR__ . '/../..' . '/app/models/Vendor.php',
        'VideoStreamTbl' => __DIR__ . '/../..' . '/app/models/VideoStreamTbl.php',
        'Visitor' => __DIR__ . '/../..' . '/app/classes/Visitor.php',
        'WalletTbl' => __DIR__ . '/../..' . '/app/models/WalletTbl.php',
        'WebsiteSettings' => __DIR__ . '/../..' . '/app/models/WebsiteSettings.php',
        'WhyChoseUsTbl' => __DIR__ . '/../..' . '/app/models/WhyChoseUsTbl.php',
        'WithdrawalsTbl' => __DIR__ . '/../..' . '/app/models/WithdrawalsTbl.php',
        'app' => __DIR__ . '/../..' . '/app/core/app.php',
        'controller' => __DIR__ . '/../..' . '/app/core/controller.php',
        'operations' => __DIR__ . '/../..' . '/app/core/operations.php',
        'phpmailerException' => __DIR__ . '/../..' . '/app/classes/PHPMailer.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit81eb7d45cb86396167b941f75b6bed30::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit81eb7d45cb86396167b941f75b6bed30::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit81eb7d45cb86396167b941f75b6bed30::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit81eb7d45cb86396167b941f75b6bed30::$classMap;

        }, null, ClassLoader::class);
    }
}
