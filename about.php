<h2>About Pandemic Baltics</h2>
<p>In the time of crisis, information overflow is inevitable. We're fixing the problem by accessing and sharing information based on regions and official sources.</p>
<h2>Our idea</h2>
<p>
We want to create a platform that solves the most common issues for people in crisis situations.<br/>
The best this platform offers is communication: with your neighbors, your city, your country and worldwide. This is solved by geo-location, and chat rooms that anyone can join or create. We, humans, as social beings, need this as much as we need air.<br/>
Meanwhile, businesses can mark their service anywhere on the map. Whether they are providing fresh food, medical supplies or virtual guitar lessons — anyone can promote their service here. This is great for small businesses, like cafes, that are currently looking for any way possible to pay their employees. There is also the option to volunteer and help out those in need.<br/>
Last, but not least: the filtered information. The platform itself automatically updates the officially approved information and publishes it. Meanwhile, the platform users can share their information regionally so anyone can take an in-depth look at any street, town, city or region.
</p>

<?php
$contents = file_get_contents('https://pomber.github.io/covid19/timeseries.json');
$contents = json_decode($contents, true);
$contents = array_reverse($contents[$settings['country']]);
?>
<h2>Statistics: <?php
print('(<em>'.$settings['country'].'</em>) <small>');
foreach ($settings['hosts'] as $host => $country) {
  if ($country === $settings['country'])
    continue;
  print('<a href="https://'.$host.'/#about" title="Pandemics '.$country.'">'.$country.'</a> ');
}
?></small></h2>

<canvas id="mainChart"></canvas>

<ol>
<?php foreach ($contents as $entry) { print('<li><strong>' . $entry['date'] . '</strong>, ' . $entry['confirmed'] . ' confirmed with ' . $entry['deaths'] . ' deaths and ' . $entry['recovered'] . ' recoveries</li>'); } ?>
</ol>

<script>
  const ctx = document.getElementById("mainChart").getContext("2d");
  fetch("https://pomber.github.io/covid19/timeseries.json").then(async res => {
    const json = await res.json();
    const latestData = json.Latvia.slice(-15);
    const labels = latestData.map(entry => entry.date);
    const colors = {
      green: {
        fill: "#e0eadf",
        stroke: "#5eb84d"
      },
      lightBlue: {
        stroke: "#6fccdd"
      },
      darkBlue: {
        fill: "#92bed2",
        stroke: "#3282bf"
      },
      purple: {
        fill: "#8fa8c8",
        stroke: "#75539e"
      }
    };

    const recovered = latestData.map(entry => entry.recovered);
    const deaths = latestData.map(entry => entry.deaths);
    const confirmed = latestData.map(entry => entry.confirmed);

    const myChart = new Chart(ctx, {
      type: "line",
      data: {
        labels,
        datasets: [
          {
            label: "Recovered",
            fill: true,
            backgroundColor: colors.green.fill,
            pointBackgroundColor: colors.green.stroke,
            borderColor: colors.green.stroke,
            pointHighlightStroke: colors.green.stroke,
            data: recovered
          },
          {
            label: "Confirmed",
            fill: true,
            backgroundColor: colors.darkBlue.fill,
            pointBackgroundColor: colors.darkBlue.stroke,
            borderColor: colors.darkBlue.stroke,
            pointHighlightStroke: colors.darkBlue.stroke,
            borderCapStyle: "butt",
            data: confirmed
          },
          {
            label: "Deaths",
            fill: true,
            backgroundColor: colors.green.fill,
            pointBackgroundColor: colors.lightBlue.stroke,
            borderColor: colors.lightBlue.stroke,
            pointHighlightStroke: colors.lightBlue.stroke,
            borderCapStyle: "butt",
            data: deaths
          }
        ]
      },
      options: {
        scales: {
          yAxes: [
            {
              stacked: true
            }
          ]
        }
      }
    });
  });
</script>
