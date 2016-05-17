<?php
echo "<pre>";
function connect($database) {
    // Connect to database server
    $link = mysqli_connect('localhost', 'root', '', $database) or die('Could not connect: ' . mysqli_error($link));
    // Select database
    mysqli_select_db($link, $database) or die('Could not select database');
    return $link;
}
function close($link) {
    // Closing connection
    mysqli_close($link);
}
function query($sql, $link) {
    $result = mysqli_query($link, $sql) or die('Query failed: ' . mysqli_error($link));
    if ($result === true) {
        return $result;
    }
    if ($result === false) {
        return [];
    }
    $data = [];
        while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $data[] = $line;
    }
    mysqli_free_result($result);
    return $data;
}
 function select($link, $table, $id = null) {
     if ($id == NUll) {
             $sql = "SELECT * FROM $table";
     } else {
         $sql = "SELECT * FROM $table WHERE id_country = $id";
     }
     $data = query($sql, $link);
     return $data;
 }

function insert ($link, $table, array $data) {
    $sql = "INSERT INTO $table (%s) VALUES (%s)";
    foreach ($data as $key => $item) {
        $keys[] = $key;
        $items[] = "'$item'";
    }
    query(sprintf($sql, implode(', ', $keys), implode(', ', $items)),$link);
}

function update ($link, $table, array $data, $id)
{
    $sql = "UPDATE $table SET country_name = '$data[country_name]',
 abbr_name = '$data[abbr_name]',
 area = '$data[area]',
 population = '$data[population]',
 president = '$data[president]',
 continent_id = '$data[continent_id]',
 Prime_Minister = '$data[Prime_Minister]'
 WHERE id_country = $id";
    query($sql, $link);

    /*foreach ($data as $key => $item) {
        $sql = "UPDATE $table SET $key = '$item' WHERE id_country = $id";
        query($sql, $link);
    }*/
}

function delete($link, $table, $id) {
    $sql = "DELETE FROM $table WHERE id_country = $id";
    query($sql, $link);
}

$connection = connect('practice_db');
$table = 'country';
$arrForInsert = [
    'country_name' => "Spain",
    'abbr_name' => "sp",
    'area' => "87",
    'population' => "100",
    'president' => "Spain President",
    'continent_id' => "1",
    'Prime_Minister' => "Spain Prime Minister"
];
insert($connection, $table, $arrForInsert);
//$idForSelect = '3';
$data = select($connection, $table/*, $idForSelect*/);
print_r($data);
$arrForUpdate = [
    'country_name' => "Belgium",
    'abbr_name' => "bl",
    'area' => "87",
    'population' => "100",
    'president' => "Spain President",
    'continent_id' => "1",
    'Prime_Minister' => "Spain Prime Minister"
];
$idForUpdate = '13';
update($connection, $table, $arrForUpdate, $idForUpdate);
$data = select($connection, $table/*, $idForSelect*/);
print_r($data);
$idForDelete = '29';
delete($connection, $table, $idForDelete);
$data = select($connection, $table/*, $idForSelect*/);
print_r($data);