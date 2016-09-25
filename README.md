# fs
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
