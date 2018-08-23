<?php
    require_once "../db_connect.php";
    require_once "../class/Laporan.php";
    require_once "../helper/url.php";
    
    $lp = new Laporan($db);
    $data = array(
        'from' => $_GET['from'],
        'to' => $_GET['to'],
        'kasus' => $_GET['kasus']
    );

    $title = array('judul','alamat');
    $size = array('50%','50%');

    $headData = array(
        'title' => 'Ini Title',
        'subtitle' => 'Ini Subtitle',
        'tgl' => $_GET['from'].' - '.$_GET['to']
    );

    $titleData = array();
    $i = 0;
    foreach ($title as $key => $value) {
        $titleData[$i]['size'] = $size[$i];
        $titleData[$i]['data'] = $title[$i]; 
        $i++;
    }

    $initial = array(
        'paperSize' => 'a4',
        'paperType' => 'portrait',
        'fileName' => 'Laporan Kejadian'
    );

    // echo $lp->_laporan($data, $headData, $titleData, $initial);
    // echo '<pre>';
    echo print_r($lp->_laporan($data, $title, $headData, $titleData, $initial));
    // echo '</pre>';
    // echo var_dump($data);
?>