<?php
defined('ISHOME') or die("Can't access this page!");
$COM='groupmember';

require_once libs_path."cls.upload.php";
$obj_upload = new CLS_UPLOAD();
$msg = new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.$COM])) $_SESSION['flash'.'com_'.$COM] = 2;

$viewtype=isset($_GET['viewtype'])?addslashes($_GET['viewtype']):'list';
if(is_file(COM_PATH.'com_'.$COM.'/tem/'.$viewtype.'.php')){ ?>
	<div class="row">
		<div class="col-sm-12 col-md-3 col-lg-3 sortable-grid ui-sortable">
			<div class="widget-tree">
				<header class="header">
					<span class="widget-icon"> <i class="fa fa-tree"></i> </span>
					<h2><?php echo LANG['COM_GMEMBER']['COM_TITLE'];?></h2>
				</header>
				<div class="tree smart-form">
					<ul role="group">
						<?php
						function findChild($array, $id){
							$flag = 0;
							foreach ($array as $key => $value) {
								if($value['par_id'] == $id){
									$flag = 1;
									return $flag;
								}
							}
							return $flag;
						};

						function printChilds($array, $id){
							$str_childs='';
							foreach ($array as $key => $value) {
								if($value['par_id'] == $id){
									if(findChild($array, $value['id']) == 1){
										$str_childs.='<li class="item_tree parent_li"><span class="item_tree"><a href="'.ROOTHOST.'groupmember/edit/'.$value['id'].'">'.$value['name'].'</a></span>';
										$str_childs.='<ul class="active">';
										$str_childs.= printChilds($array, $value['id']);
										$str_childs.='</ul>';
									}else{
										$str_childs.='<li class="item_tree"><span class="item_tree"><a href="'.ROOTHOST.'groupmember/edit/'.$value['id'].'">'.$value['name'].'</a></span>';
									}

									$str_childs.='</li>';
								}
							}
							return $str_childs;
						}

						$arr_gmems = SysGetList('tbl_gmember', array(), '');
						$num_arr_gmems = count($arr_gmems);
						$str_tree='';
						for ($i=0; $i < $num_arr_gmems; $i++) { 
							if($arr_gmems[$i]['par_id'] == 0){
								$childs = false;
								$tmp_id = $arr_gmems[$i]['id'];
								echo '<li class="parent_li">
								<span class="root"><i class="fa fa-sitemap"></i><a href="'.ROOTHOST.'groupmember/edit/'.$tmp_id.'" class="a_root">'.$arr_gmems[$i]['name'].'</a></span>';

								if(findChild($arr_gmems, $tmp_id) == 1){
									echo '<ul class="active">';
									echo printChilds($arr_gmems, $tmp_id);
									echo '</ul>';
								}


								echo '</li>';
							}
						}
						?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-sm-12 col-md-9 col-lg-9 sortable-grid ui-sortable">
			<?php
			function getListCombobox($parid=0, $level=0){
				$sql="SELECT * FROM tbl_gmember WHERE `par_id`='$parid' AND `isactive`='1' ";
				$objdata=new CLS_MYSQL();
				$objdata->Query($sql);
				$char="";
				if($level!=0){
					for($i=0;$i<$level;$i++)
						$char.="|-----";
				}
				if($objdata->Num_rows()<=0) return;
				while($rows=$objdata->Fetch_Assoc()){
					$id=$rows['id'];
					$parid=$rows['par_id'];
					$title=$rows['name'];
					echo "<option value='$id'>$char $title</option>";
					$nextlevel=$level+1;
					getListCombobox($id,$nextlevel);
				}
			}
			?>
			<?php include_once('tem/'.$viewtype.'.php'); ?>
		</div>
	</div>
<?php }
unset($viewtype); unset($obj); unset($COM);
?>