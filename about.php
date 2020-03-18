<h2>About PANDEMIC.LV</h2>
<p>In the time of crisis, information overflow is inevitable. We're fixing the problem by accessing and sharing information based on regions.</p>
<h2>Our idea</h2>
<p>
We want to create a platform that solves the most common issues for people in crisis situations.<br/>
The best this platform offers is communication: with your neighbours, your city, your country and worldwide. This is solved by geolocation, and channels that anyone can join or create. We, humans, as social beings, need this as much as we need air.<br/>
Meanwhile, businesses can mark their service anywhere on the map. Whether they are providing fresh food, medical supplies or virtual guitar lessons — anyone can promote their service here. This is great for small businesses, like cafes, that are currently looking for any way possible to pay their employees. There is also the option to volunteer and help out those in need.<br/>
Last, but not least: the filtered information. The platform itself automatically updates the officially approved information and publishes it. Meanwhile, the platform users can share their information regionally so anyone can take an in-depth look at any street, town, city or region.
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
