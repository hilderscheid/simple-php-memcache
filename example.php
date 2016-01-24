<?php

include 'Samplemodel.php';
include 'Simplecache.php';

$samplemodel = new Samplemodel();
$cached_samplemodel = new Simplecache(new Samplemodel(), 5);

echo 'Simplecache: <br/>';
echo 'Live: '.$samplemodel->get();
echo '<br/>';
echo 'Cached: '.$cached_samplemodel->get();