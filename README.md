[![Build Status](https://travis-ci.org/kadimi/bootswatch.svg?branch=master)](https://travis-ci.org/kadimi/bootswatch)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kadimi/bootswatch/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/kadimi/bootswatch/?branch=master)
[![Dependency Status](https://www.versioneye.com/user/projects/57d5e17b87b0f6003c14c503/badge.svg)](https://www.versioneye.com/user/projects/57d5e17b87b0f6003c14c503)

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

...Then login to the dashboard and follow the messages in the notices to install and activate required plugins.

## Overriding Bootstrap/Bootswatch `variables.less`

You can override variables used by a sub-theme using the `bootswatch_variables_overrides` filter hook, here is an example:

```php
/**
 * Override base font size for Lumen sub-theme.
 */
add_filter( 'bootswatch_variables_overrides', function( $variables_overrides, $bootswatch_theme ) {
	if ( 'lumen' === $bootswatch_theme ) {
		$variables_overrides[ '@font-size-base' ] = '15px';
	}
	return $variables_overrides;
}, 10, 3 );
```

## Code Sniffing

The command you need is:

```bash
phpcs -p -s -v -n . --standard=./codesniffer.ruleset.xml --extensions=php
```

This command requires PHP_CodeSniffer and WordPress-Coding-Standards, an easy way to install them:

```bash
# Install PHP_CodeSniffer
composer global require squizlabs/php_codesniffer

# Install WordPress-Coding-Standards
composer global require wp-coding-standards/wpcs

# Configure PHP_CodeSniffer to use WordPress-Coding-Standards
phpcs --config-set installed_paths ~/.config/composer/vendor/wp-coding-standards/wpcs/

```
