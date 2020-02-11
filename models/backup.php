
<?php

$config = array();
$config['dbname'] = 'teka';
$config['host'] = 'localhost';
$config['dbuser'] = 'root';
$config['dbpass'] = '';

$db = new PDO("mysql:dbname=" . $config['dbname'] . ";host=" . $config['host'], $config['dbuser'], $config['dbpass']);
$db->query("SET TIME_ZONE = '-03:00'");
$db->exec("SET CHARACTER SET utf8");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

date_default_timezone_set('America/Sao_Paulo');

$f = fopen(date('Y-m-d') . '.txt', 'wt');

$tables = $db->query('SHOW TABLES');

foreach ($tables as $table) {
    $sql = '-- TABLE: ' . $table[0] . PHP_EOL;
    $create =  $db->query('SHOW CREATE TABLE `' . $table[0] . '`')->fetch();
    $sql .= $create['Create Table'] . ';' . PHP_EOL;
    fwrite($f, $sql);

    $rows =  $db->query('SELECT * FROM `' . $table[0] . '`');
    $rows->setFetchMode(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        $row = array_map(array($db, 'quote'), $row);
        $sql = 'INSERT INTO `' . $table[0] . '`(`' . implode('`, `', array_keys($row)) . '`) VALUES (' . utf8_encode(implode(', ', $row)) .
            ');' . PHP_EOL;
        fwrite($f, $sql);
    }

    $sql = PHP_EOL;
    $result = fwrite($f, $sql);

    #echo $result != false ? 'backup feito com sucesso' : 'error';

    flush();
}

fclose($f);



?>
