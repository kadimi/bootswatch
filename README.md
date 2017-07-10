[![Build Status](https://travis-ci.org/kadimi/bootswatch.svg?branch=master)](https://travis-ci.org/kadimi/bootswatch)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kadimi/bootswatch/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/kadimi/bootswatch/?branch=master)
[![Dependency Status](https://www.versioneye.com/user/projects/59608395368b080049058e89/badge.svg)](https://www.versioneye.com/user/projects/59608395368b080049058e89)

# Bootswatch for WordPress

A WordPress theme based on Bootswatch, with the ability to override its themes.

## Installation

```bash
# Clone the repository
cd ~/[...]/wp-content/themes
git clone git@github.com:kadimi/bootswatch.git
cd bootswatch

# Setup dependencies with Composer
rm -fr composer.lock vendor
composer install

```

## Build

The build script, among many other things, deletes unused files and generates the installable theme file **bootswatch.zip**, you can run it manually with:

```bash
composer run-script post-install-cm
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

## Code Sniffing

The command you need is:

```bash
phpcs -p -s -v -n . --standard=./codesniffer.ruleset.xml --extensions=php
```

This command requires PHP_CodeSniffer and WordPress-Coding-Standards, you can install them as follows:

```bash
# Install PHP_CodeSniffer.
composer global require squizlabs/php_codesniffer:^2.8.1

# Install WordPress-Coding-Standards.
composer global require wp-coding-standards/wpcs

# Configure PHP_CodeSniffer to use WordPress-Coding-Standards.
phpcs --config-set installed_paths ~/.config/composer/vendor/wp-coding-standards/wpcs/

```
