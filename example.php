<?php

require_once('Dataset.php');

$data = new DataStore();

// creation of key value pair
// $data->create('name', "abc");

// read all
// $data->read();

// read by key
$data->read('name');

// delete data
// $data->delete('name');


?>
