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

## Code Sniffing

The command you need is:

```bash
phpcs -p -s -v -n . --standard=./codesniffer.ruleset.xml --extensions=php
```
