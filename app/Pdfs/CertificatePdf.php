<?php

namespace App\Pdfs;

use App\Pdfs\MasterPage;

use Carbon\Carbon;


class CertificatePdf
{

  protected $fontFamily = 'Times';
  protected $fontSize = 12;
  protected $fpdf;

  public function __construct()
  {

    $fontFamily = 'Times';
    $fontSize = 12;

    $this->fontFamily = $fontFamily;
    $this->fontSize = $fontSize;
    $this->fpdf = new MasterPage('', $fontFamily, $fontSize);
  }

  function writeLink($URL, $txt)
  {
    // Put a hyperlink
    $this->fpdf->SetTextColor(0, 0, 255);
    $this->fpdf->SetFont('', 'U');
    $this->fpdf->Write(5, $txt, $URL);
    $this->fpdf->SetFont('', '');
    $this->fpdf->SetTextColor(0);
  }

  function getOutput($sxtData, $DC)
  {

    // page setup
    $leftMargin = 50;
    $yMargin = 20;
    $rightMargin = $yMargin;
    $xMargins = $leftMargin + $rightMargin;
    $contentWidth = $this->fpdf->GetPageWidth() - $xMargins;

    $fontFamily = $this->fontFamily;
    $fontSize = $this->fontSize;

    $sxtData = (array) $sxtData[0];
    $name = $sxtData['employee_name'];
    $station = $sxtData['station'];
    $oJoinDate = $sxtData['join_date'];
    $joinDate = date('d-m-Y', strtotime($oJoinDate));
    $oexitDate = $sxtData['exit_date'];
    $exitDate = date('d-m-Y', strtotime($oexitDate));
    $designation = $sxtData['designation_name'];


    $this->fpdf->SetMargins($leftMargin, $yMargin, $rightMargin);
    $this->fpdf->AddPage("P", "A4");
    $this->fpdf->SetFont($fontFamily, 'B', 16);
    $this->fpdf->SetDrawColor(25, 25, 25);
    $this->fpdf->SetFillColor(178, 190, 181);
    $this->fpdf->Image(public_path() . '/images/kra.logo.png', 55, 5, 100, 0, 'PNG');
    $this->fpdf->SetFont('Times', 'B', 12);
    $this->fpdf->SetFont('Times', 'B', 12);
    $this->fpdf->Text(15, 15, ' HR/ADM/CF/Ver 2');
    $this->fpdf->Ln(20);
    $this->fpdf->SetFont($this->fontFamily, 'BU', $this->fontSize + 10);
    $this->fpdf->Cell(10, 0, 'CERTIFICATE OF SERVICE', 0, 1, 'L');
    $this->fpdf->SetFont($this->fontFamily, '', $this->fontSize);
    $this->fpdf->Ln(10);


    //Row 1
    $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize);
    $this->fpdf->Cell(60, 20, 'NAME OF EMPLOYEE', 0, 0, 'L'); // Note the 0 as the last argument

    $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize);
    $this->fpdf->Cell(30, 20, ':', 0, 0, 'C');

    $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize);
    $this->fpdf->Cell(0, 20, $name, 0, 1, 'L'); // Note the 1 as the last argument
    //Row 1 end

    //Row 2
    $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize);
    $this->fpdf->Cell(60, 20, 'DUTY STATION', 0, 0, 'L'); // Note the 0 as the last argument

    $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize);
    $this->fpdf->Cell(30, 20, ':', 0, 0, 'C');

    $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize);
    $this->fpdf->Cell(0, 20, $station, 0, 1, 'L'); // Note the 1 as the last argument
    //Row 2 end

    //Row 3
    $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize);
    $this->fpdf->Cell(60, 20, 'DATE EMPLOYED', 0, 0, 'L'); // Note the 0 as the last argument

    $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize);
    $this->fpdf->Cell(30, 20, ':', 0, 0, 'C');

    $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize);
    $this->fpdf->Cell(0, 20, $joinDate, 0, 1, 'L'); // Note the 1 as the last argument
    //Row 3 end

    //Row 4
    $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize);
    $this->fpdf->Cell(60, 20, 'DATE OF DEPARTURE', 0, 0, 'L'); // Note the 0 as the last argument

    $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize);
    $this->fpdf->Cell(30, 20, ':', 0, 0, 'C');

    $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize);
    $this->fpdf->Cell(0, 20, $exitDate, 0, 1, 'L'); // Note the 1 as the last argument
    //Row 4 end

    //Row 5
    $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize);
    $this->fpdf->Cell(60, 20, 'POSITION HELD', 0, 0, 'L'); // Note the 0 as the last argument

    $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize);
    $this->fpdf->Cell(30, 20, ':', 0, 0, 'C');

    $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize);
    $this->fpdf->Cell(0, 20, $designation, 0, 1, 'L'); // Note the 1 as the last argument
    //Row 5 end

    //Row 6
    $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize);
    $this->fpdf->Cell(60, 20, 'TERMS OF EMPLOYMENT', 0, 0, 'L'); // Note the 0 as the last argument

    $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize);
    $this->fpdf->Cell(30, 20, ':', 0, 0, 'C');

    $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize);
    $this->fpdf->Cell(0, 20, "CONTRACT", 0, 1, 'L'); // Note the 1 as the last argument
    //Row 6 end

    //Row 7
    $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize);
    $this->fpdf->Cell(60, 20, 'DATE ISSUED', 0, 0, 'L'); // Note the 0 as the last argument

    $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize);
    $this->fpdf->Cell(30, 20, ':', 0, 0, 'C');

    $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize);
    $this->fpdf->Cell(0, 20, date('d-m-Y', strtotime(Carbon::now())), 0, 1, 'L'); // Note the 1 as the last argument
    //Row 7 end

    // Put a centered line
    $this->fpdf->Ln(30); // Adjust line position as needed
    $this->fpdf->Cell(0, 0, '', 'T', 'C');

    // Centered text
    $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize);
    if ($DC) {
      $this->fpdf->Cell(0, 10, "Deputy Commissioner - Human Resources", 0, 1, 'C');
    } else {
      $this->fpdf->Cell(0, 10, "For Deputy Commissioner - Human Resources", 0, 1, 'C');
    }













    // if ($savePath) {
    $this->fpdf->Output('I', public_path());
    //} else {
    // $this->fpdf->Output();
    // exit;
    //}
  }
}