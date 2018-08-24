<?php
    require_once "../db_connect.php";
    require_once "../class/Laporan.php";
    require_once "../helper/url.php";
    
    $lp = new Laporan($db);

    if($_GET['kasus'] == 'kejadian')
    {
        /** Set Clause Data */
        $data = array(
            'from' => $_GET['from'],
            'to' => $_GET['to'],
            'kasus' => 1
        );

        /** Set Tabel Title */
        $title = array('No','Judul', 'Alamat', 'Tanggal');
        /** Set Table Size */
        $size = array('3%','47%','30%','20%');
        /** Set field Tabel */
        $field = array('judul','alamat','tgl_buat');

        /** Set Head Laporan */
        $headData = array(
            'title' => 'Laporan Kejadian',
            'subtitle' => 'Sistem Pengaduan Kecelakaan',
            'tgl' => $_GET['from'].' - '.$_GET['to']
        );
    
        /** Merge title & size to array */
        $titleData = array();
        $i = 0;
        foreach ($title as $key => $value) {
            $titleData[$i]['size'] = $size[$i];
            $titleData[$i]['data'] = $title[$i]; 
            $i++;
        }
    
        /** Set Dompdf Configuration */
        $initial = array(
            'paperSize' => 'a4',
            'paperType' => 'portrait',
            'fileName' => 'Laporan Kejadian'
        );
        
        /** Hit */
        $lp->_laporanKejadian($data, $field, $headData, $titleData, $initial);
    }

    if($_GET['kasus'] == 'kerusakan')
    {
        /** Set Clause Data */
        $data = array(
            'from' => $_GET['from'],
            'to' => $_GET['to'],
            'kasus' => 2
        );

        /** Set Tabel Title */
        $title = array('No','Judul', 'Alamat', 'Tanggal');
        /** Set Table Size */
        $size = array('3%','47%','30%','20%');
        /** Set field Tabel */
        $field = array('judul','alamat','tgl_buat');

        /** Set Head Laporan */
        $headData = array(
            'title' => 'Laporan Kerusakan',
            'subtitle' => 'Sistem Pengaduan Kecelakaan',
            'tgl' => $_GET['from'].' - '.$_GET['to']
        );
    
        /** Merge title & size to array */
        $titleData = array();
        $i = 0;
        foreach ($title as $key => $value) {
            $titleData[$i]['size'] = $size[$i];
            $titleData[$i]['data'] = $title[$i]; 
            $i++;
        }
    
        /** Set Dompdf Configuration */
        $initial = array(
            'paperSize' => 'a4',
            'paperType' => 'portrait',
            'fileName' => 'Laporan Kerusakan'
        );
        
        /** Hit */
        $lp->_laporanKejadian($data, $field, $headData, $titleData, $initial);
    }

    if($_GET['kasus'] == 'kecelakaan')
    {
        /** Set Clause Data */
        $data = array(
            'from' => $_GET['from'],
            'to' => $_GET['to']
        );

        /** Set Tabel Title */
        $title = array('No','Kode', 'Lokasi', 'Tanggal');
        /** Set Table Size */
        $size = array('3%','27%','45%','25%');
        /** Set field Tabel */
        $field = array('kode','lokasi','createAt');

        /** Set Head Laporan */
        $headData = array(
            'title' => 'Laporan Kecelakaan',
            'subtitle' => 'Sistem Pengaduan Kecelakaan',
            'tgl' => $_GET['from'].' - '.$_GET['to']
        );
    
        /** Merge title & size to array */
        $titleData = array();
        $i = 0;
        foreach ($title as $key => $value) {
            $titleData[$i]['size'] = $size[$i];
            $titleData[$i]['data'] = $title[$i]; 
            $i++;
        }
    
        /** Set Dompdf Configuration */
        $initial = array(
            'paperSize' => 'a4',
            'paperType' => 'portrait',
            'fileName' => 'Laporan Kecelakaan'
        );
        
        /** Hit */
        $lp->_laporanKecelakaan($data, $field, $headData, $titleData, $initial);
    }

    if($_GET['kasus'] == 'laporKejadian')
    {
        /** Set Clause Data */
        $data = array(
            'from' => $_GET['from'],
            'to' => $_GET['to'],
            'kasus' => 'kejadian'
        );

        /** Set Tabel Title */
        $title = array('No','Judul', 'Lokasi', 'Tanggal');
        /** Set Table Size */
        $size = array('3%','37%','35%','25%');
        /** Set field Tabel */
        $field = array('judul','lokasi','tgl_lapor');

        /** Set Head Laporan */
        $headData = array(
            'title' => 'Laporan Kejadian dari Warga',
            'subtitle' => 'Sistem Pengaduan Kecelakaan',
            'tgl' => $_GET['from'].' - '.$_GET['to']
        );
    
        /** Merge title & size to array */
        $titleData = array();
        $i = 0;
        foreach ($title as $key => $value) {
            $titleData[$i]['size'] = $size[$i];
            $titleData[$i]['data'] = $title[$i]; 
            $i++;
        }
    
        /** Set Dompdf Configuration */
        $initial = array(
            'paperSize' => 'a4',
            'paperType' => 'portrait',
            'fileName' => 'Laporan Kejadian Warga'
        );
        
        /** Hit */
        $lp->_laporanWarga($data, $field, $headData, $titleData, $initial);
    }

    if($_GET['kasus'] == 'laporKerusakan')
    {
        /** Set Clause Data */
        $data = array(
            'from' => $_GET['from'],
            'to' => $_GET['to'],
            'kasus' => 'kerusakan'
        );

        /** Set Tabel Title */
        $title = array('No','Judul', 'Lokasi', 'Tanggal');
        /** Set Table Size */
        $size = array('3%','37%','35%','25%');
        /** Set field Tabel */
        $field = array('judul','lokasi','tgl_lapor');

        /** Set Head Laporan */
        $headData = array(
            'title' => 'Laporan Kerusakan dari Warga',
            'subtitle' => 'Sistem Pengaduan Kecelakaan',
            'tgl' => $_GET['from'].' - '.$_GET['to']
        );
    
        /** Merge title & size to array */
        $titleData = array();
        $i = 0;
        foreach ($title as $key => $value) {
            $titleData[$i]['size'] = $size[$i];
            $titleData[$i]['data'] = $title[$i]; 
            $i++;
        }
    
        /** Set Dompdf Configuration */
        $initial = array(
            'paperSize' => 'a4',
            'paperType' => 'portrait',
            'fileName' => 'Laporan Kerusakan Warga'
        );
        
        /** Hit */
        $lp->_laporanWarga($data, $field, $headData, $titleData, $initial);
    }
?>