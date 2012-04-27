<?php
/**
 * Remote Links
 * Adam Shannon
 */

require_once 'config/config.php';

// Setup the mongo connection
try {
  $mongo = new Mongo("mongodb://{$config['hostname']}:{$config['port']}");
} catch (Exception $e) {
  exit("Failed to connect to mongo. " + $e);
}

// Select the db and collection
$collection = $mongo->remoteLinks->remoteLinks;

// Grab the link
$url = urldecode($_GET['link']);

// Throw it into mongo
$row = array("href" => $url, "dateAdded" => @time());
$collection->insert($row);

exit(@time());
