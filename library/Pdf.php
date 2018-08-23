<?php
    class Pdf {
        
        public function headTable($data = array())
		{
			$head = '<h3 align="center">'.$data['title'].'</h3><br>
						<h4 align="center">'.$data['subtitle'].'</h4>
						<div>Tanggal : '.$data['tgl'].'</div><br>
						<table style="width:100%;" border="1" color="black">';
			return $head;
		}

		public function titleTable($data = array())
		{
			$content = '<tr>';
			$i = 0;
			while($i < count($data)) {
				$content .= '<th width="'.$data[$i]['size'].'">'.$data[$i]['data'].'</th>';
				$i++;
			}
			$content .= '</tr>';
			return $content;	
        }
        
        public function contentTable($data = array(), $title = array())
        {

            
            $i = 0;
            // foreach ($data as $row) {
            //     $content .= '<td>'.$data[$i]['data'].'</td>'; 
            //     $i++;
            // }
            $content = '<tbody>';
            foreach ($data as $row) 
            {
                $content .= '<tr>';
                foreach($title as $key => $value)
                {
                    $content .= '<td>'.$row[$value].'</td>'; 
                }
                $content .= '</tr>';
                $i++;
            }
            $content .= '</tbody>';
            
            return $content;
        }

		public function footTable($data = array())
		{
			$foot = '</table>';
			return $foot;
        }
        
        public function initial($data = array(), $html)
        {
            require_once("../dompdf/dompdf_config.inc.php");

            $dompdf = new DOMPDF();
            $dompdf->set_paper($data['paperSize'], $data['paperType']);
            $dompdf->load_html(html_entity_decode($html));
            $dompdf->render();
            $dompdf->stream(
                $data['fileName'].'.pdf',
                array(
                    'Attachment' => 0
                )
            );
        }
    }
?>