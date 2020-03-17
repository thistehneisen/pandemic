<h2>About PANDEMIC.LV</h2>
<p>In the time of crisis, information overflow is inevitable. We're fixing the problem by the possibility to access, and share information — based on regions.</p>
<?php
$contents = file_get_contents('https://pomber.github.io/covid19/timeseries.json');
$contents = json_decode($contents, true);
$contents = $contents['Latvia'];
?>
<p><strong>Statistics:</strong><br/>
<ol>
<?php foreach ($contents as $entry) { print('<li>Date: ' . $entry['date'] . '<br/>Confirmed: ' . $entry['confirmed'] . '<br/>Deaths: ' . $entry['deaths'] . '<br/>Recovered: ' . $entry['recovered'] . '</li>'); } ?>
</ol>
</p>