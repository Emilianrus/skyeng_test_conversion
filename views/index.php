<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['',  ''],
      <?php $ind = 1; ?>
      <?php foreach($conversions as $conversion): ?>
      <?= '['.$ind.', ' . $conversion['value'] . '],' ?>
      <?php $ind++;?>
      <?php endforeach; ?>
    ]);

    var options = {
      vAxis: {title: 'Конверсия, %'},
      hAxis: {title: 'Период, №'},
      isStacked: true
    };

    var chart = new google.visualization.SteppedAreaChart(document.getElementById('diagram'));

    chart.draw(data, options);
  }
</script>

<h1>Задача на PHP</h1>

<p>Алгоритм получения конверсии реализован в методе Customer::ConversionReport.</p>
<p>Введите необходимое количество дней в периоде и нажмите "Построить отчет".</p>

<form class="navbar-form" action="/index.php" method="post">
    <div class="form-group">
        <label class="control-label">Дней в периоде: </label>
        <input type="text" class="form-control" name="days_interval" value="<?= $daysInterval ?>">
    </div>
    <button type="submit" class="btn btn-default">Построить отчет</button>
</form>

<div id="diagram" style="width: 1024px; height: 500px;"></div>

<div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-1"><b>№</b></div>
        <div class="col-md-2"><b>Период:</b></div>
        <div class="col-md-2"><b>Конверсия:</b></div>
    </div>
<?php $ind = 1; ?>
<?php foreach($conversions as $conversion): ?>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-1"><?= $ind ?></div>
        <div class="col-md-2"><?= date('d.m.Y', $conversion['intervalBegin'])?> - <?= date('d.m.Y', $conversion['intervalEnd']); ?></div>
        <div class="col-md-2"><?= $conversion['value'] ?>%</div>
    </div>
    <?php $ind++;?>
<?php endforeach; ?>
