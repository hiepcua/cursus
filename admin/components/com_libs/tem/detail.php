<?php 
require_once(LIB_PATH."cls.lib_lession.php");
$objles = new CLS_lIB_LESSION;
$lib_code=$les_code='';
if(isset($_GET['lib'])){
	$lib_code=addslashes($_GET['lib']);
	$les_code=isset($_GET['code'])?addslashes($_GET['code']):'';
	$objles->getList(" AND `code`='$lib_code'");
	$row = $objles->Fetch_Assoc();
	$lib_id=$row['id'];
	$lib_name=stripslashes($row['title']);
	$lib_thumb=$row['thumb'];
	if($lib_thumb=='') $lib_thumb=ROOTHOST.'images/noimage.png';
	else $lib_thumb=ROOTHOST.$lib_thumb;
?>
<div class="col-md-3">
	<aside class="sidebar">
		<div class="logo">
			<img src="<?php echo $lib_thumb;?>" alt="<?php echo $lib_name;?> Tutorial" class="img-responsive">
		</div>
		<?php echo $objles->getPartName($lib_id,$lib_code.'-tutorials',$les_code);?>
	</aside>
</div>
<div class="col-md-9 right-col">
	<div class="content">
		<?php 
		$arr=$objles->getLession($lib_id,$les_code); 
		if(count($arr)==0) echo "<h1>$lib_name</h1><hr>Dữ liệu đang cập nhật.<br>";
		else {
		$les_id=$arr['id'];
		if($arr['thumb']!='') echo "<img src='".$arr['thumb']."' class='img-responsive'/>";?>
		<h1><?php echo stripslashes($arr['title']);?></h1>
		<?php 
		$next=$objles->NextRow($les_id,$lib_code);
		$preview=$objles->PrevRow($les_id,$lib_code);
		
		$print='<div class="print-btn col-md-3 pull-left text-center">
			<a href="'.ROOTHOST.'tutorial-print-'.$les_id.'" target="_blank"><i class="fa fa-print big-font"></i> Print</a>
			</div>';
		$pdf='<div class="pdf-btn col-md-3 pull-left text-center">
			<a href="#" title="'.$lib_name.' tutorial" target="_blank"><i class="fa fa-file-pdf-o big-font"></i> PDF</a>
			</div>';
		echo '<div class="path">'.$preview.$next.'</div>'; ?>
		<div class="clearfix"></div>
		<div class="posts"><?php echo stripslashes($arr['content']);?></div>
		<?php echo '<div class="path">'.$preview.$print.$pdf.$next.'</div>';?>	
		<?php } ?>
		<div class="clearfix"></div><br>
	</div>
</div>
<?php } ?>