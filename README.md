# Minimum requirements for WordPress Themes or Plugins
Check the minimum requirements for your WordPress theme or plugin

## Installation
To install simply require the package in the `composer.json` file like

```json
  "require":
    {
      "overclokk/minimum-requirements": "*"
    }
```

and then use `composer install` or `composer update` to fetch the package.

### CLI
Or simply run
```shell
composer require overclokk/minimum-requirements
```
Or
```shell
php composer.phar  require overclokk/minimum-requirements
```

## Example

```php
/**
 * Require minimum-requirements class to load minimum compatibility theme/plugin
 */
require( YOUR_PLUGIN_PATH . 'core/wp-requirements.php' );

/**
 * Instantiate the class
 *
 * @param string $php_ver The minimum PHP version.
 * @param string $wp_ver  The minimum WP version.
 * @param string $name    The name of the theme/plugin to check.
 * @param array  $plugins Required plugins format plugin_path/plugin_name.
 *
 * @var Minimum_Requirements
 */
$requirements = new Minimum_Requirements( '5.3', '3.5', 'YOUR PLUGIN NAME', array( 'plugin-needed/plugin-needed.php' ) );

/**
 * Check compatibility on install
 * If is not compatible on install print an admin_notice
 */
register_activation_hook( __FILE__, array( $requirements, 'check_compatibility_on_install' ) );

/**
 * If it is already installed and activated check if example new version is compatible, if is not don't load plugin code and prin admin_notice
 */
if ( ! $requirements->is_compatible_version() ) {

	add_action( 'admin_notices', array( $requirements, 'load_plugin_admin_notices' ) );
	return;

}
```

## Credits

The original code (only the part of cheking requirements) comes from [SZ-Google](https://wordpress.org/plugins/sz-google/) of Massimo della Rovere with my personal improvements and a little piece of code from [WordPress-Plugin-Boilerplate-Powered
](https://github.com/Mte90/WordPress-Plugin-Boilerplate-Powered) of Mte90 (the part that check the plugin needed).