Contao Flexible Template Sections
=================================

[![Build Status](http://img.shields.io/travis/netzmacht/contao-flexible-sections/master.svg?style=flat-square)](https://travis-ci.org/netzmacht/contao-flexible-sections)
[![Version](http://img.shields.io/packagist/v/netzmacht/contao-flexible-sections.svg?style=flat-square)](http://packagist.com/packages/netzmacht/contao-flexible-sections)
[![License](http://img.shields.io/packagist/l/netzmacht/contao-flexible-sections.svg?style=flat-square)](http://packagist.com/packages/netzmacht/contao-flexible-sections)
[![Downloads](http://img.shields.io/packagist/dt/netzmacht/contao-flexible-sections.svg?style=flat-square)](http://packagist.com/packages/netzmacht/contao-flexible-sections)
[![Contao Community Alliance coding standard](http://img.shields.io/badge/cca-coding_standard-red.svg?style=flat-square)](https://github.com/contao-community-alliance/coding-standard)

This extension provides a very flexible way to define custom sections in Contao. For each template section the position
 and template can be defined.
 

Install
-------

Contao Flexible Template can be installed using composer:

```
$ php composer.phar require netzmacht/contao-flexible-sections:~1.0
$ php composer.phar update
```

Usage
-----

 * Instead of a comma separated list of sections in the backend you have a new sections wizard. Define your sections there.
 * You have to the frontend page template `fe_flexible_section` or use it as your base template to extend. 
