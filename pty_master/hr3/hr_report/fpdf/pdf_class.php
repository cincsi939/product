<?
class PDF extends FPDF
{
	var $left;
	var $top;
	var $width;
	var $height;
	var $save_lMargin;
	var $save_tMargin;

	//Page header
	function Header()
	{
		$str_title = "รายงานการติดตามงาน";
		$str_title = $str_title;
		$this->SetLineWidth(0.5);
		$this->SetFont('Angsana New','B',14);
		$this->Cell(0,10,$str_title,'B',0,'C');
		$this->Ln(10);

		//inner page area
		$this->left   = $this->lMargin;
		$this->top    = $this->tMargin;
		$this->width  = $this->w - $this->rMargin - $this->lMargin;
		$this->height = $this->h - $this->bMargin - $this->tMargin;

		$this->save_lMargin = $this->lMargin;
		$this->save_tMargin = $this->tMargin;
	}

	//Page footer
	function Footer()
	{
		$this->SetMargins($this->save_lMargin,$this->save_tMargin);
		$this->SetLineWidth(0.5);
		$this->Rect($this->left,$this->top,$this->width,$this->height);
		//Position at 1.5 cm from bottom
		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','I',8);
		//Page number
		$this->Cell(0,10,'Page '.$this->PageNo().' / {nb}',0,0,'R');
	}




	function print_text1($title ,$value ,$nLeftPad ,$box_width) {
		$x = $this->GetX();
		$y = $this->GetY();

		$this->SetXY($x,$y);
		$value = str_pad($value, strlen($value)+$nLeftPad, "*", STR_PAD_LEFT); 
		$this->SetFont('Angsana New','',14);
		$this->MultiCell($box_width,8, $value,0,'L');
		$this->Ln(0);

		$this->SetXY($x,$y);
		$this->SetFont('Angsana New','B',14);
		$w = $this->GetStringWidth($title)+3;
		$this->SetFillColor(255,255,255);
		$this->MultiCell($w,8,$title,0,'L',1);
	}

	function print_text2($title ,$value ,$nLeftPad ,$box_width) {
		$x = $this->GetX();
		$y = $this->GetY();

		$this->SetXY($x,$y);
		$this->SetFont('Angsana New','B',14);
		$w = $this->GetStringWidth($title)+3;
		$this->SetFillColor(255,255,255);
		$this->MultiCell($w,8,$title,0,'L',1);

		if($value!="") {
			$this->SetX($x + $nLeftPad);
			$value = $value;
			$this->SetFont('Angsana New','',14);
			$this->MultiCell($box_width,8, $value,0,'L');
		}	
	}

	function br() {
		$this->Ln(8);
		$x = $this->GetX();
		$y = $this->GetY();
		$this->Line($x,$y,$x+$this->width,$y);
	}
}//end class PDF

?>