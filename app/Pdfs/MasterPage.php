<?php

namespace App\Pdfs;

use Codedge\Fpdf\Fpdf\Fpdf;

class MasterPage extends Fpdf
{

  protected $visiblity;
  protected $fontFamily;
  protected $fontSize;

  public function __construct($visiblity, $fontFamily, $fontSize)
  {
    $this->visiblity = $visiblity;
    $this->fontFamily = $fontFamily;
    $this->fontSize = $fontSize;

    parent::__construct();
  }

  function Header()
  {

    $pageHeight = $this->GetPageHeight();
    if ($this->visiblity != 'INTERNAL') {
      $this->Image(public_path() . '/images/pdf-strip.png', 5, 0, 10, $pageHeight, 'PNG');

    }

  }

  function Footer()
  {
    $this->SetY(-20);

  }
}