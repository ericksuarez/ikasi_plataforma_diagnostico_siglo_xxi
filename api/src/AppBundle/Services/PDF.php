<?php
/**
 * Created by PhpStorm.
 * User: Iván
 * Date: 29/12/2016
 * Time: 05:01 PM
 */
namespace AppBundle\Services {

    use FPDF;

    class PDF extends FPDF
    {
        var $logo;
        var $title;

        /**
         * PDF constructor.
         * @param null $logo
         * @param string $orientation
         * @param string $unit
         * @param string $size
         */
        function __construct($logo = null, $title = 'SINADEP', $orientation = 'P', $unit = 'mm', $size = 'letter')
        {
            parent::__construct($orientation, $unit, $size);
            $this->logo = $logo;
            $this->title;
        }

        /**
         * Encabezado de página
         */
        function Header()
        {
            // Logo
            $this->Image($this->logo, 70, 8, 0, 0);
            // Arial bold 15
            $this->SetFont('Arial', 'B', 15);
            // Movernos a la derecha
            //$this->Cell(80);
            $this->Ln(20);
            // Título
            $this->Cell(190, 10, $this->title, 0, 0, 'C');
            // Salto de línea
            $this->Ln(20);
        }

        /**
         * Pie de página
         */
        function Footer()
        {
            // Posición: a 1,5 cm del final
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial', 'I', 8);
            // Número de página
            $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        }

        //***** Aquí comienza código para ajustar texto *************
        //***********************************************************
        function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)
        {
            //Get string width
            $str_width=$this->GetStringWidth($txt);

            //Calculate ratio to fit cell
            if($w==0)
                $w = $this->w-$this->rMargin-$this->x;
            $ratio = ($w-$this->cMargin*2)/$str_width;

            $fit = ($ratio < 1 || ($ratio > 1 && $force));
            if ($fit)
            {
                if ($scale)
                {
                    //Calculate horizontal scaling
                    $horiz_scale=$ratio*100.0;
                    //Set horizontal scaling
                    $this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));
                }
                else
                {
                    //Calculate character spacing in points
                    $char_space=($w-$this->cMargin*2-$str_width)/max($this->MBGetStringLength($txt)-1,1)*$this->k;
                    //Set character spacing
                    $this->_out(sprintf('BT %.2F Tc ET',$char_space));
                }
                //Override user alignment (since text will fill up cell)
                $align='';
            }

            //Pass on to Cell method
            $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);

            //Reset character spacing/horizontal scaling
            if ($fit)
                $this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');
        }

        function CellFitSpace($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
        {
            $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,false);
        }

        //Patch to also work with CJK double-byte text
        public function MBGetStringLength($s)
        {
            if($this->CurrentFont['type']=='Type0')
            {
                $len = 0;
                $nbbytes = strlen($s);
                for ($i = 0; $i < $nbbytes; $i++)
                {
                    if (ord($s[$i])<128)
                        $len++;
                    else
                    {
                        $len++;
                        $i++;
                    }
                }
                return $len;
            }
            else
                return strlen($s);
        }
        //************** Fin del código para ajustar texto *****************
		/************************************************************
		*                                                           *
		*    MultiCell with bullet (array)                          *
		*                                                           *
		*    Requires an array with the following  keys:            *
		*                                                           *
		*        Bullet -> String or Number                         *
		*        Margin -> Number, space between bullet and text    *
		*        Indent -> Number, width from current x position    *
		*        Spacer -> Number, calls Cell(x), spacer=x          *
		*        Text -> Array, items to be bulleted                *
		*                                                           *
		************************************************************/

		function MultiCellBltArray($w, $h, $blt_array, $border=0, $align='J', $fill=false)
		{
			if (!is_array($blt_array))
			{
				die('MultiCellBltArray requires an array with the following keys: bullet,margin,text,indent,spacer');
				exit;
			}
					
			//Save x
			$bak_x = 10;
			
			for ($i=0; $i<sizeof($blt_array['text']); $i++)
			{
				//Get bullet width including margin
				$blt_width = $this->GetStringWidth($blt_array['bullet'] . $blt_array['margin'])+$this->cMargin*2;
				
				// SetX
				$this->SetX($bak_x);
				
				//Output indent
				if ($blt_array['indent'] > 0)
					$this->Cell($blt_array['indent']);
				
				//Output bullet
				$this->Cell($blt_width,$h,$blt_array['bullet'] . $blt_array['margin'],0,'',$fill);
				
				//Output text
				$this->MultiCell($w-$blt_width,$h,$blt_array['text'][$i],$border,$align,$fill);
				
				//Insert a spacer between items if not the last item
				if ($i != sizeof($blt_array['text'])-1)
					$this->Ln($blt_array['spacer']);
				
				//Increment bullet if it's a number
				if (is_numeric($blt_array['bullet']))
					$blt_array['bullet']++;
			}
		
			//Restore x
			$this->x = $bak_x;
		}
    }
}