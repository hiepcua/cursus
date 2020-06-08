<?php

class Document

{

    var $SrcFile = false;//File ngu?n

    var $DestFile = false;//File ðích n?u ðý?c lýu

    var $Quality = 100; //Ch?t lý?ng ?nh s? ðý?c t?o

    var $NewWidth = 0; //Ð? r?ng c?a ?nh s? ðý?c t?o

    var $NewHeight = 0;//Ð? cao c?a ?nh s? ðý?c t?o

    var $WidthPercent = 0;//chi?u r?ng c?a ?nh c?n t?o dùng khi mu?n resize ?nh nhýng gi? nguyên t? l? dài/r?ng

    var $HeightPercent = 0;//chi?u cao c?a ?nh c?n t?o dùng khi mu?n resize ?nh nhýng gi? nguyên t? l? dài/r?ng

	function GetType()//Hàm l?y ki?u c?a file ngu?n - ch? h? tr? jpg(1), gif(2), png(3)

    {

        $arr['mime'] = false;

        $arr = getimagesize($this->SrcFile);

		//echo $arr['mime'];

        $type = 0;

        switch($arr['mime'])

        {

            case 'text/plain': //.txt
				$type = 1; break;

			case 'application/rar': //.rar
                $type = 2; break;

            case 'application/pdf':  //.pdf
                $type = 3;  break;

			case 'application/vnd.ms-excel': //.xls Excel 2003
				$type = 4;  break;
				
			case 'application/vnd.openxmlformats-officedocument.presentationml.presentation': //.xlsx Excel 2007
				$type = 5;  break;
				
            case 'application/octet-stream': //.zip
                $type = 6;  break;
				
			case 'application/msword': //.doc word 2003
                $type = 7;  break;
				
			case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document': //.docx word 2007
                $type = 8;  break;		
				
			case 'application/vnd.ms-powerpoint': //.ppt  PowerPoint 2003
                $type = 9;  break;	
				
			case 'application/vnd.openxmlformats-officedocument.presentationml.presentation"': //.pptx PowerPoint 2007
                $type = 10;  break;		
					
			case 'text/html': //.html
                $type = 7;  break;
				
			
					
            default:

                $type = 0;

                break;

        }

        if($type > 0)

            return $type;

        else

            die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">File nguồn không tồn tại hoặc không phải định dạng cho phép !. Lỗi Image->GetType()");

    }

	function GetWidth() //Hàm l?y chi?u r?ng c?a ?nh g?c

    {

        $arr[0] = 0;

        $arr = getimagesize($this->SrcFile);

        if(intval($arr[0]) > 0)

            return intval($arr[0]);

        else

            die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">File nguồn không tồn tại hoặc không phải định dạng cho phép !. Lỗi Image->GetWidth()");

    }

	function GetHeight() //Hàm l?y chi?u cao c?a ?nh g?c

    {

        $arr[1] = 0;

        $arr = getimagesize($this->SrcFile);

        if(intval($arr[1]) > 0)

            return intval($arr[1]);

        else

            die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">File nguồn không tồn tại hoặc không phải định dạng cho phép !. Lỗi Image->GetHeight()");

    }

	function LoadImageFromFile()//Ham t?o m?t ?nh vào trong b? nh? t? file ngu?n - tr? v? ð?a ch? vùng nh? ch?a anh dc t?o

    {

        $type = $this->GetType();

        $img = false;

        switch($type)

        {

            case 1:

                $img = imagecreatefromjpeg($this->SrcFile);

                break;

            case 2:

                $img = imagecreatefromgif($this->SrcFile);

                break;

            case 3:

                $img = imagecreatefrompng($this->SrcFile);

                break;

        }

        return $img;

    }

	function NewImage($W, $H) //Hàm t?o 1 ?nh m?i trong b? nh? - tr? v? ð?a ch? c?a nó trong b? nh?

    {

        if($this->GetType() != 2)

		    @$imgNew = imagecreatetruecolor($W,$H);//Dung cho gif - chua ho tro gif nen gif se khong transfer

        else

            $imgNew = imagecreate($W, $H);

        @$white = imagecolorallocate($imgNew, 255, 255, 255);//Dung cho PNG

        @imagefilledrectangle( $imgNew, 0, 0, $W, $H, $white);//Dung cho PNG

        return $imgNew;

    }

	function CopyImage($Src, $Dest, $Width, $Height) //Hàm copy và resize t? ?nh có ð?a ch? trong b? nh? $Src t?i ?nh có ð?a ch? $Dest

    {

        //imagecopyresized($Dest, $Src,0,0,0,0, $Width, $Height, $this->GetWidth(), $this->GetHeight());

		$cur_w=$this->GetWidth(); $dx=$cur_w/$Width;

		$cur_h=$this->GetHeight(); $dy=$cur_h/$Height;

		$newx=$Width/2;

		$newh=$Height/2;

		if($dx>$dy)

		{

			$Height=$cur_h/$dx;

		}else{

			$Width=$cur_w/$dy;

		}

		$newx-=$Width/2; $newx=ceil($newx);

		$newh-=$Height/2; $newh=ceil($newh);

		imagecopyresized($Dest, $Src,$newx,$newh,0,0, $Width, $Height, $this->GetWidth(), $this->GetHeight());

    }

	function SaveFile($Src, $Dest)//Hàm ghi thành file n?u c?n

    {

        $type = $this->GetType();

        switch($type)

        {

            case 1:

                imagejpeg($Dest, $this->DestFile, $this->Quality);

                break;

            case 2:

                if(function_exists('imagegif')) //PHP < 5 no support

                    imagegif($Dest, $this->DestFile, $this->Quality);

                else

                    imagejpeg($Dest, $this->DestFile, $this->Quality);

                break;

            case 3:

				//header('Content-type: image/png');

				if(function_exists('function.imagepng'))

				{

					$this->Quality=9;

                	imagepng($Dest, $this->DestFile, $this->Quality);

				}

				else

					imagejpeg($Dest, $this->DestFile, $this->Quality);

                break;

        }

    }

	function FreeMemory($Src, $Dest)//Hàm gi?i phóng b? nh? ch?a h?nh ?nh ngu?n và ðích

    {

        imagedestroy($Src);

        imagedestroy($Dest);

    }



//Hàm ðý?c g?i

	function SaveFileWH()//Hàm tr? v? file ?nh ðý?c resize v?i Width và Height do ta ch? ð?nh

    {

        $img = false;

        $imgNew = false;

        $img = $this->LoadImageFromFile();

        $imgNew = $this->NewImage($this->NewWidth, $this->NewHeight);

        $this->CopyImage($img, $imgNew, $this->NewWidth, $this->NewHeight);

        $this->SaveFile($img, $imgNew);

        $this->FreeMemory($img, $imgNew);

    }

//Hàm ðý?c g?i

	function SaveFileW()//Resize voi Width do ta chi dinh va Height lay theo ti le cua Width

    {

        $oldW = $this->GetWidth();

        $oldH = $this->GetHeight();

        $newW = $this->WidthPercent;

        $newH = $newW*($oldH/$oldW);

        $img = false;

        $imgNew = false;

        $img = $this->LoadImageFromFile();

        $imgNew = $this->NewImage($newW, $newH);

        $this->CopyImage($img, $imgNew, $newW, $newH);

        $this->SaveFile($img, $imgNew);

        $this->FreeMemory($img, $imgNew);

    }

//Hàm ðý?c g?i

	function SaveFileH()//Resize voi Height do ta chi dinh va Width lay theo ti le cua Height

    {

        $oldW = $this->GetWidth();

        $oldH = $this->GetHeight();

        $newH = $this->HeightPercent;

        $newW = $newH*($oldW/$oldH);

        $img = false;

        $imgNew = false;

        $img = $this->LoadImageFromFile();

        $imgNew = $this->NewImage($newW, $newH);

        $this->CopyImage($img, $imgNew, $newW, $newH);

        $this->SaveFile($img, $imgNew);

        $this->FreeMemory($img, $imgNew);

    }

}



?>