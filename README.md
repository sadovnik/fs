# fs
[![Build Status](https://travis-ci.org/sadovnik/fs.svg?branch=master)](https://travis-ci.org/sadovnik/fs)
[![Code Climate](https://codeclimate.com/github/sadovnik/fs/badges/gpa.svg)](https://codeclimate.com/github/sadovnik/fs)
[![Test Coverage](https://codeclimate.com/github/sadovnik/fs/badges/coverage.svg)](https://codeclimate.com/github/sadovnik/fs/coverage)
[![Issue Count](https://codeclimate.com/github/sadovnik/fs/badges/issue_count.svg)](https://codeclimate.com/github/sadovnik/fs)

A simple filesystem interface.

## Install
Via Composer:
```
composer install sadovnik/fs
```

## Usage
```php
use Fs\Fs;

$data = Fs::read('some.file');
Fs::write('some_another.file', 'very important data');
Fs::isDir('some.file');
```

## Requirments
* PHP 7
