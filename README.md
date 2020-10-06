[![Build Status](https://travis-ci.org/kadimi/bootswatch.svg?branch=master)](https://travis-ci.org/kadimi/bootswatch)

# Bootswatch for WordPress

A WordPress theme based on Bootswatch, with the ability to override its themes.

## Installation

```bash
# Clone the repository
cd ~/[...]/wp-content/themes
git clone git@github.com:kadimi/bootswatch.git
cd bootswatch

# Setup dependencies with Composer
rm vendor composer.lock -fr && composer install

```

## Build

The build script, among many other things, deletes unused files and generates the installable theme file **bootswatch.zip**, the build command is:

```bash
php -f build/build.php
```

## Overriding Bootstrap/Bootswatch `variables.less`

You can override variables used by a sub-theme using the `bootswatch_variables_overrides` filter hook, here is an example:

```php
/**
 * Override base font size for Lumen sub-theme.
 */
function my_variables_overrides( $overrides, $theme ) {
	if ( 'lumen' === $theme ) {
		$overrides[ '@font-size-base' ] = '15px';
	}
	return $overrides;
}
add_filter( 'bootswatch_variables_overrides', 'my_variables_overrides', 10, 2 );
```
