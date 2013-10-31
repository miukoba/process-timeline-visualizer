<?php

$date = new DateTime();
$dateParam = $_GET['date'];
if ($dateParam) {
    $date = DateTime::createFromFormat('Ymd', $dateParam);
}
$logFileName = $date->format('Ymd') . '.log';
$fp = fopen('./log/' . $logFileName, 'r');

$previousDate = clone $date;
$previousDate->modify('-1 day');
$previousDateParam = http_build_query(array('date' => $previousDate->format("Ymd")));

$nextDate = clone $date;
$nextDate->modify('+1 day');
$nextDateParam = http_build_query(array('date' => $nextDate->format("Ymd")));

$dataRows = array();
while ($data = fgetcsv($fp, 0, ',')) {
    $dataRows[$data[1]][] = $data[0];
}

$number = 0;
$rows = array();
foreach ($dataRows as $name => $date) {
    $number++;
    $command = $name;
    $start = date('Y/m/d G:i:s', strtotime($date[0]));
    $end = date('Y/m/d G:i:s', strtotime($date[count($date) - 1]));
    $rows[$number] = [
        'number' => $number,
        'command' => trim($command),
        'start' => $start,
        'end' => $end
    ];
}
fclose($fp);
?><!doctype html>
<html lang="ja-JP">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="/favicon.png" type="image/png">
    <title>process timeline visualizer</title>
    <script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization',
       'version':'1','packages':['timeline']}]}"></script>
    <script type="text/javascript">
        google.setOnLoadCallback(draw);

        function draw() {
            var data = [
                <?php
                    for ($rowNum = 1;  $rowNum <= count($rows); $rowNum++) {
//                        $num = $rows[$rowNum]['number'];
                        $batchName = explode(" ", $rows[$rowNum]['command']);
                        $command = $rows[$rowNum]['command'];
                        $start = $rows[$rowNum]['start'];
                        $end = $rows[$rowNum]['end'];
//                        printf("[ '%s', '%s', new Date('%s'), new Date('%s') ]", $num, $command, $start, $end);
                        printf("[ '%s', '%s', new Date('%s'), new Date('%s') ]", $batchName[3], $command, $start, $end);
                        if($rowNum !== count($rows)){
                            echo ",\n";
                        }
                    }
                ?>
            ];

            drawChart(data);
        }

        function drawChart(data) {
            var container = document.getElementById('timeline');
            var chart = new google.visualization.Timeline(container);
            var dataTable = new google.visualization.DataTable();
            dataTable.addColumn({ type: 'string', id: 'number' });
            dataTable.addColumn({ type: 'string', id: 'command' });
            dataTable.addColumn({ type: 'date', id: 'start' });
            dataTable.addColumn({ type: 'date', id: 'end' });
            dataTable.addRows(data);
            chart.draw(dataTable);
        }
    </script>

</head>
<body>

<a href="/?<?php echo $previousDateParam ?>">&lt;&lt; 前日</a>　<a href="/?<?php echo $nextDateParam ?>">翌日 &gt;&gt;</a>

<div id="timeline" style="width: 1800px; height: 800px;"></div>

</body>
</html>
