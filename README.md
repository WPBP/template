# Template
[![License](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](http://www.gnu.org/licenses/gpl-3.0)
![Downloads](https://img.shields.io/packagist/dt/wpbp/template.svg) 

Templating system in WordPress (woocommerce like) also for email with l10n support.  

* Your plugin as a `templates` folder that will be loaded by the plugin based on the code
* If a theme has a folder with the same slug name of the plugin will look if the file exist there

## Install

`composer require wpbp/language:1.0.1`

[composer-php52](https://github.com/composer-php52/composer-php52) supported.

## Example

```php
// This is like the woocommerce function
function load_content_demo( $original_template ) {
        if ( is_singular( 'demo' ) && in_the_loop() ) {
            return wpbp_get_template_part( 'plugin-name-folder', 'content', 'demo', false, array() ); // The last parameter is for arguments to pass to the template but is not mandatory
        } else {
            return $original_template;
        }
}
add_filter( 'template_include', 'load_content_demo' );

// This is an extended version that search for folder with names based on locales like it_IT
$get_template_email = wpbp_get_template_part( 'plugin-name-folder' , 'header', 'prefix' );
```

`wpbp_get_template_part` is the same of https://developer.wordpress.org/reference/hooks/get_template_part/ this filter, the difference is that this one is executed by this library

`wpbp_get_email_template` is a function that looks for folder like `en_US` with file's extension `.tpl`.

The code is very easy and in case of doubts you can check [here](https://github.com/WPBP/template/blob/master/template.php).


