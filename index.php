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

echo '<html><head><title>Remote Links</title></head><body>';
echo '<h2>Remote Links</h2>';
echo '<div id="links"><ul style="list-style-type:none;">';

$records = $collection->find();
foreach ($records as $record) {
  echo '<li>' . @date("Y-M-d", $record['dateAdded']) . " - <a href='" . $record['href'] . "'>" . $record['href'] . "</a>";
  echo " <span onclick='deleteLink(" . $record['dateAdded'] . ");'>[x]</span></li>";
}

if (count($records) == 0) {
  echo '<li>No Links</li>';
}

?>

</ul>
</div>
<h3>Insert a link</h3>
<input type="text" id="newLink" placeholder="http://ashannon.us" autofocus />
  <input type="button" onclick="addLink();" value="Add Link" />

<script>
var xhr = new XMLHttpRequest();

function addLink() {
  var newLink = document.querySelector("#newLink");
  xhr.open("GET", "addLink.php?link=" + encodeURIComponent(newLink.value), false);
  xhr.send(null);

  // Formatting
  newLink.value = "";
  window.location.reload();
}

function deleteLink(dateAdded) {
  xhr.open("GET", "deleteLink.php?dateAdded=" + encodeURIComponent(dateAdded), false);
  xhr.send(null);
  window.location.reload();
}
</script>
</body>
</html>
