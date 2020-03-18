<h2>About PANDEMIC.LV</h2>
<p>In the time of crisis, information overflow is inevitable. We're fixing the problem by the possibility to access, and share information — based on regions.</p>
<h2>Our idea</h2>
<p>
    We want to create a platform that solve most common issues for most people in crisis.<br/>
    The main possibility in the platform is communication — with neighbors, your city, your country and worldwide. This is solved by geolocation, and channels that anyone can join or create.<br/>
    Meanwhile, businesses can create their pin at any location on the map. Whether they are providing with fresh food, medical supplies or virtual guitar lessons — anyone can promote their business in the platform. This is extra good for small businesses like caffeterias that are currently searching any way possible to pay their employees.<br/>
    Last, but not least — the filtered information. The platform itself automatically updates the oficially approved information and publishes it. Meanwhile, the platform users can share their information regionally. Therefore, a city, or a neighbor, can talk only in the depth of their town or street.
</p>

<?php
$contents = file_get_contents('https://pomber.github.io/covid19/timeseries.json');
$contents = json_decode($contents, true);
$contents = array_reverse($contents['Latvia']);
?>
<strong>Statistics:</strong><br/>
<ol>
<?php foreach ($contents as $entry) { print('<li><strong>' . $entry['date'] . '</strong>, ' . $entry['confirmed'] . ' confirmed with ' . $entry['deaths'] . ' deaths and ' . $entry['recovered'] . ' recoveries</li>'); } ?>
</ol>
