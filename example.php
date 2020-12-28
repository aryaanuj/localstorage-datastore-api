<?php

require_once('Dataset.php');

//create file at specific location
//$data = new DataStore("C:/Users/PARIDHI/Documents/result.json");

//create file at current folder
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
