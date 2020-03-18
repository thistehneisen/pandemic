<h2>About PANDEMIC.LV</h2>
<p>In the time of crisis, information overflow is inevitable. We're fixing the problem by the possibility to access, and share information — based on regions.</p>
<h2>Our idea</h2>
<p>
    We want to create a platform that solve most common issues for most people in crisis.<br/>
    The main possibility in the platform is communication — communicating with neighbors and others, helping them out, or just having a conversation for the sake of not being bored.<br/>
    Services, in the meanwhile can create their areas of functioning. Whether those are fresh fruits or teaching to play a guitar via Skype — all of these features can be added to the map, by anyone.
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
