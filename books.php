<?php
$dataFile = 'data/books.json';
$data = [];

if (file_exists($dataFile) && filesize($dataFile) > 0) {
    $data = json_decode(file_get_contents($dataFile), true);
} else {
    echo "The books could not be found!";
}
?>





