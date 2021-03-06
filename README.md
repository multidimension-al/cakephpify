# CakePHP Plugin for Shopify API Authentication

[![Build Status](https://api.travis-ci.org/multidimension-al/cakephpify.svg)](https://travis-ci.org/multidimension-al/cakephpify)
[![Latest Stable Version](https://poser.pugx.org/multidimensional/cakephpify/v/stable.svg)](https://packagist.org/packages/multidimensional/cakephpify)
[![Code Coverage](https://scrutinizer-ci.com/g/multidimension-al/cakephpify/badges/coverage.png)](https://scrutinizer-ci.com/g/multidimension-al/cakephpify/)
[![Minimum PHP Version](http://img.shields.io/badge/php-%3E%3D%205.5-8892BF.svg)](https://php.net/)
[![License](https://poser.pugx.org/multidimensional/cakephpify/license.svg)](https://packagist.org/packages/multidimensional/cakephpify)
[![Total Downloads](https://poser.pugx.org/multidimensional/cakephpify/d/total.svg)](https://packagist.org/packages/multidimensional/cakephpify)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/multidimension-al/cakephpify/badges/quality-score.png)](https://scrutinizer-ci.com/g/multidimension-al/cakephpify/)

A CakePHP Plugin for Shopify API Authentication.

# NOTE: WE HAVE NOT YET REACHED A STABLE RELEASE, DO NOT USE THIS IN PRODUCTION!

## Requirements

* CakePHP 3.3+
* PHP 5.5.9+
* Database Connection
* Shopify API Credentials

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require --prefer-dist multidimensional/cakephpify
```

## Setup

Load the plugin by running following command in terminal:

```
bin/cake plugin load Multidimensional/Cakephpify -b -r
```

Or by manually adding following line to your app's `config/bootstrap.php`:

```php
Plugin::load('Multidimensional/Cakephpify', ['bootstrap' => true, 'routes' => true]);
```

## Configuration

Run the installation script command in termainl:

```
bin/cake ShopifyInstall
```


## Usage

Add this in your App

```php
// In a controller
public function initialize()
{
    parent::initialize();
    $this->loadComponent('Auth', [
        'authenticate' => ['Multidimensional/Cakephpify.ShopifyAuth']]);
}
```

## License

    The MIT License (MIT)

    Copyright (c) 2016 multidimension.al
    Copyright (c) 2012 Collin McDonald 
    Copyright (c) 2011 Sandeep Shetty
	
    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in
    all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
    THE SOFTWARE.
