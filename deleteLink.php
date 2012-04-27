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
$dateAdded = urldecode($_GET['dateAdded']);

// Remove from mongo
$row = array("dateAdded" => (int) $dateAdded);
$collection->remove($row, array("justOne" => true, "safe" => true));

exit();
