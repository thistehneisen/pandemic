<h2>About PANDEMIC.LV</h2>
<p>In the time of crisis, information overflow is inevitable. We're fixing the problem by the possibility to access, and share information — based on regions.</p>
<?php
$contents = file_get_contents('https://pomber.github.io/covid19/timeseries.json');
$contents = json_decode($contents, true);
$contents = array_reverse($contents['Latvia']);
?>
<strong>Statistics:</strong><br/>

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
