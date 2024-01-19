<?php

namespace App\Pdfs;

use App\Http\Controllers\NewPdfController;
use App\Pdfs\MasterPage;


class ClearancePdf
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
        $this->fpdf = new MasterPage('INTERNAL', $fontFamily, $fontSize);
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
    function getAbbreviation($inputString)
    {
        // Split the input string into words
        $words = explode(' ', $inputString);

        // Initialize an empty abbreviation
        $abbreviation = '';

        // Iterate through the words and append the first letter of each word to the abbreviation
        foreach ($words as $word) {
            $abbreviation .= strtoupper(substr($word, 0, 1));
        }

        return $abbreviation;
    }
    function getOutput($sxtDepartments, $sxtData, $DC)
    {
        // Page setup
        $leftMargin = 10;
        $yMargin = 10;
        $rightMargin = 10;
        $xMargins = $leftMargin + $rightMargin;
        $contentWidth = $this->fpdf->GetPageWidth() - $xMargins;

        $fontFamily = $this->fontFamily;
        $fontSize = $this->fontSize;

        $case_id = "";
        $name = "";
        $number = "";
        $dept = "";
        $div = "";
        $mergedValue = "";
        $desig = "";
        $station = "";
        $phone = "";
        $email = "";
        $address = "";


        for ($i = 0; $i < count($sxtData); $i++) {
            $currentData = (array) $sxtData[$i];
            $caseIdx = $currentData['case_idx'];
            $caseId = $currentData['case_id'];
            $name = $currentData['employee_name'];
            $number = $currentData['user_name'];
            $dept = $currentData['department'];
            $abb = $this->getAbbreviation($dept);
            $div = $currentData['division'];
            $mergedValue = $dept . '/' . $div;
            $desig = $currentData['designation'];
            $station = $currentData['station'];
            $phone = $currentData['phone'];
            $email = $currentData['email'];
            $address = $currentData['address'];
            $remarks = $currentData['remarks'];

            $emailDept = $currentData['emailDept'];
        }



        $this->fpdf->SetMargins($leftMargin, $yMargin, $rightMargin);
        $this->fpdf->AddPage("P", "A4");
        $this->fpdf->SetFont($fontFamily, 'B', 10);
        $this->fpdf->SetDrawColor(25, 25, 25);
        $this->fpdf->SetFillColor(178, 190, 181);
        $this->fpdf->SetLineWidth(1);
        $this->fpdf->Rect(10, 50, $this->fpdf->GetPageWidth() - 20, $this->fpdf->GetPageHeight() - 200);
        $this->fpdf->Image(public_path() . '/images/kra.logo.png', 55, 5, 100, 0, 'PNG');
        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Text(180, 15, "INTERNAL");
        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Text(15, 15, 'HR/ADM/CF/Ver 2');
        $this->fpdf->Ln(20);
        $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize + 10);
        $this->fpdf->Cell(0, 10, 'STAFF CLEARANCE FORM', 0, 1, 'C');

        $this->fpdf->SetFont($this->fontFamily, 'BI', $this->fontSize + 4);
        $this->fpdf->Cell(0, 5, 'To be completed when an Employee is separating with the Authority', 0, 1, 'C');

        //Section employee details
        $this->fpdf->SetFont($this->fontFamily, 'BU', $this->fontSize + 4);
        $this->fpdf->Cell(10, 25, ' EMPLOYEE DETAILS', 0, 1, 'L');

        $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize + 4);
        $this->fpdf->Cell(0, 0, ' Employee Name: ', 0, 0, 'L');

        $this->fpdf->SetFont($this->fontFamily, '', $this->fontSize + 4);
        $this->fpdf->Cell(-5, 0, $name, 0, 1, 'R');

        $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize + 4);
        $this->fpdf->Cell(0, 20, ' Employee Number: ', 0, 0, 'L');

        $this->fpdf->SetFont($this->fontFamily, '', $this->fontSize + 4);
        $this->fpdf->Cell(-5, 20, $number, 0, 1, 'R');

        $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize + 4);
        $this->fpdf->Cell(0, 0, ' Department/Division: ', 0, 0, 'L');

        $this->fpdf->SetFont($this->fontFamily, '', $this->fontSize + 4);
        $this->fpdf->Cell(-5, 0,$mergedValue , 0, 1, 'R');

        $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize + 4);
        $this->fpdf->Cell(0, 20, " Employees's Designation: ", 0, 0, 'L');

        $this->fpdf->SetFont($this->fontFamily, '', $this->fontSize + 4);
        $this->fpdf->Cell(-5, 20, $desig, 0, 1, 'R');

        $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize + 4);
        $this->fpdf->Cell(0, 0, " Station: ", 0, 0, 'L');

        $this->fpdf->SetFont($this->fontFamily, '', $this->fontSize + 4);
        $this->fpdf->Cell(-5, 0, $station, 0, 1, 'R');

        $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize + 4);
        $this->fpdf->Cell(0, 20, " Personal Address: ", 0, 0, 'L');

        $this->fpdf->SetFont($this->fontFamily, '', $this->fontSize + 4);
        $this->fpdf->Cell(-5, 20, $address, 0, 1, 'R');

        $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize + 4);
        $this->fpdf->Cell(0, 0, " Personal Telephone Contact: ", 0, 0, 'L');

        $this->fpdf->SetFont($this->fontFamily, '', $this->fontSize + 4);
        $this->fpdf->Cell(-5, 0, $phone, 0, 1, 'R');

        $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize + 4);
        $this->fpdf->Cell(0, 20, " Personal Email Address: ", 0, 0, 'L');
 
        $this->fpdf->SetFont($this->fontFamily, '', $this->fontSize + 4);
        $this->fpdf->Cell(-5, 20, strtolower($email), 0, 1, 'R');

        //Departments
        for ($i = 0; $i < count($sxtDepartments); $i++) {
            $this->fpdf->SetFont($this->fontFamily, 'BU', $this->fontSize + 4);
            if ($sxtDepartments[$i] == 'own_department') {
                $this->fpdf->Cell(10, 10, strtoupper($dept), 0, 1, 'L');
            } else if ($sxtDepartments[$i] != 'admin' && $sxtDepartments[$i] != 'hr' && $sxtDepartments[$i] != 'reports') {
                $this->fpdf->Cell(10, 10, strtoupper($sxtDepartments[$i]), 0, 1, 'L');
            }
            $xcontroller = new NewPdfController();
            $xdata = $xcontroller->filterData($sxtDepartments[$i], $caseIdx);
            $remarkData = $xcontroller->remarks($sxtDepartments[$i], $caseIdx);



            if (!$xdata->isEmpty()) {
                $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize);
                // Table header
                $this->fpdf->Cell(45, 10, 'LIABILITY', 1);
                $this->fpdf->Cell(45, 10, 'AMOUNT', 1);
                $this->fpdf->Cell(45, 10, 'COMMENT', 1);
                $this->fpdf->Cell(45, 10, 'CLEARED BY', 1);
                // Add more header cells as needed

                $this->fpdf->Ln(); // Move to the next row
                foreach ($xdata as $row) {
                    foreach ($row as $cell) {
                        $this->fpdf->Cell(45, 10, (string) $cell, 1);
                    }
                    $this->fpdf->Ln(10); // Move to the next row
                }
            }
            if ($sxtDepartments[$i] != 'admin' && $sxtDepartments[$i] != 'hr' && $sxtDepartments[$i] != 'reports') {
                foreach ($remarkData as $item) {
                    $email = $item->email;
                    $remark = $item->remarks;
                    $lname = $item->lname;
                    $oname = $item->oname;
                    $mergedName = $lname . $oname;

                    $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize + 4);
                    $this->fpdf->Cell(0, 15, " Contact: ", 0, 0, 'L');

                    $this->fpdf->SetFont($this->fontFamily, '', $this->fontSize + 4);
                    $this->fpdf->Cell(-40, 15, $email, 0, 1, 'R');

                    $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize + 4);
                    $this->fpdf->Cell(0, 10, " Cleared by: ", 0, 0, 'L');

                    $this->fpdf->SetFont($this->fontFamily, '', $this->fontSize + 4);
                    $this->fpdf->Cell(-40, 10, $mergedName, 0, 1, 'R');

                    $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize + 4);
                    $this->fpdf->Cell(0, 10, " Remarks: ", 0, 1, 'L');


                    $this->fpdf->SetFont($this->fontFamily, 'I', $this->fontSize);
                    $this->fpdf->MultiCell(250, 15, $remark, 0, '');

                }
            }


        }
        $this->fpdf->Cell(0, 10, "", 0, 1, 'L');
        $this->fpdf->Cell(0, 10, "", 0, 1, 'L');
        $this->fpdf->SetFont($this->fontFamily, 'BU', $this->fontSize + 4);
        $this->fpdf->Cell(10, 10, "APPROVAL BY DEPUTY COMMISSIONER - HUMAN RESOURCES", 0, 1, 'L');

        $this->fpdf->SetFont($this->fontFamily, 'B', $this->fontSize + 4);
        $this->fpdf->Cell(0, 10, "I certify that the officer has: ", 0, 1, 'L');

        $this->fpdf->Cell(0, 10, "1. Surrendered his/her Staff Identification (Yes/No)", 0, 1, 'L');
        $this->fpdf->Cell(0, 10, "2. Has completed and submitted the Exit Interview Questionnaire", 0, 1, 'L');

        $this->fpdf->Cell(0, 10, "Remarks: ", 0, 1, 'L');
        $this->fpdf->Cell(0, 10, "", 0, 1, 'L');
        $this->fpdf->Cell(0, 10, "", 0, 1, 'L');
        $this->fpdf->Cell(0, 10, "Name: ", 0, 1, 'L');
        $this->fpdf->Cell(0, 10, "", 0, 1, 'L');

        // Put a centered line
        // $this->fpdf->Ln(20); // Adjust line position as needed
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





// $this->fpdf->SetLineWidth(0.2);

// $this->fpdf->Cell(60, 10, 'Name', 1, 0, 'C');
// $this->fpdf->Cell(60, 10, 'Initial Remarks', 1, 0, 'C');
// $this->fpdf->Cell(60, 10, 'Liabilities', 1, 0, 'C');
// $this->fpdf->Cell(60, 10, 'Cleared By', 1, 0, 'C');
// $this->fpdf->Cell(60, 10, 'Role', 1, 1, 'C');

// foreach ($data as $row) {
//     $this->fpdf->Cell(60, 10, $row['Name'], 1, 0, 'C');
//     $this->fpdf->Cell(60, 10, $row['Initial remarks'], 1, 0, 'C');

//     if ($row['Initial remarks'] === 'Has Liabilities') {
//         // Nested table for liabilities
//         $this->fpdf->SetLineWidth(0.1);

//         $this->fpdf->Cell(30, 10, 'Item', 1, 0, 'C');
//         $this->fpdf->Cell(30, 10, 'Comment', 1, 1, 'C');

//         foreach ($row['Liabilities']['Item'] as $key => $item) {
//             $this->fpdf->Cell(30, 10, $item, 1, 0, 'C');
//             $this->fpdf->Cell(30, 10, $row['Liabilities']['Comment'][$key], 1, 1, 'C');
//         }
//     } else {
//         // Single cell for liabilities
//         $this->fpdf->Cell(60, 10, $row['Liabilities'], 1, 0, 'C');
//     }

//     $this->fpdf->Cell(60, 10, $row['Cleared by'], 1, 0, 'C');
//     $this->fpdf->Cell(60, 10, $row['Role'], 1, 1, 'C');
// }

// $this->fpdf->SetLineWidth(0.2);