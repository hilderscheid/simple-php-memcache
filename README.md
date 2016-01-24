# Simple PHP Memcache #

## About ##

Very simple and powerfull class to cache your model responses

## Requirements ##

- PHP 5.x or higher

## Introduction ##

The class just reflect your models and saves the response for the given ttl.

## Usage ##

```php
<?php
    // instead of $yourclass = new \Yourclass();
    $yourclass = new Simplecache(new \Yourclass(), 60);
?>
```

## Example ##

```php
include 'Samplemodel.php';
include 'Simplecache.php';

$samplemodel = new Samplemodel();
$cached_samplemodel = new Simplecache(new Samplemodel(), 5);

echo 'Simplecache: <br/>';
echo 'Live: '.$samplemodel->get();
echo '<br/>';
echo 'Cached: '.$cached_samplemodel->get();
```
