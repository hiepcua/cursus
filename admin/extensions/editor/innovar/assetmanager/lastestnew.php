<?php
require_once(libs_path."gfclass/cls.simple_image.php");

if(!isset($clsimage)) $clsimage = new SimpleImage();
if(!isset($objcon)) $objcon = new CLS_CONTENTS();
$objcon->getList($objmodule->CatID," ORDER BY `order` ASC, `con_id` DESC LIMIT 0,4");
?>
	<?php if($objmodule->ViewTitle==1)
	{?>
	<h3 class="title"><a href="index.php?com=contents&viewtype=block&catid=<?php echo $objmodule->CatID;?>">&nbsp;</a></h3>
    <?php 
	}
	$i=1;
	while($rows = $objcon->FetchArray()) {
		if($i==4)
		$cls="data_end";
		else
		$cls="";
		echo '<div class="data_center '.$cls.' '.$objmodule->Class.'">';
		$title = stripslashes($rows["title"]);
		$intro = Substring(stripslashes($rows["intro"]),0,25);
		$fulltext = stripslashes($rows["fulltext"]);
		$link = 'index.php?com=contents&viewtype=article&item='.$rows["con_id"];
    	
		$imgs=$clsimage->get_image($fulltext);
		$width = "100%";
		if($imgs!='') {
			$imgs ='<img src="'.$imgs.'"/>';
		}		
		echo '<h2 class="data_h2">'.$title.'</h2><a href="'.$link.'" class="box_img">'.$imgs.'</a>
				<div class="data_content">'.$intro.'</div>';
		//if($i==1)	
		echo '<a href="'.$link.'" class="data_readmore">Chi tiết</a>';  
			//echo '<a href="'.$link.'" class="readmore">Xem tiếp <small>>></small></a>';
    	echo '</div>';
		$i++;
    } 
	?>
<?php
unset($objcon);
unset($objmodule);
unset($clsimage);
unset($rows);
?>
