<?php 
	defined("ISHOME") or die("Can not acess this page, please come back!");
	define("COMS","document_group");
	define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');
	require_once('libs/cls.document_group.php');
	$obj=new CLS_DOCUMENT_TYPE();

	if(isset($_POST["cmdsave"])){
		$obj->Name=addslashes($_POST["txttitle"]);
		$obj->ParID=(int)$_POST["cbo_doctype"];
		$obj->Code=un_unicode($obj->Name);
        if($_POST['txtthumb']!="") {
            $obj->Img=addslashes($_POST['txtthumb']);
        }
        $obj->Banner = ($_POST['select_banner']) ? $_POST['select_banner'] : "";
		$obj->isActive	=(int)$_POST["optactive"];
		if(isset($_POST["txtid"])){
			$obj->ID=(int)$_POST["txtid"];
			$obj->Update();
		}else{
			$obj->Add_new();
		}
		 echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
	}
	if(isset($_POST["txtaction"]) && $_POST["txtaction"]!=""){
		$ids=$_POST["txtids"];
		$ids=str_replace(",","','",$ids);
		switch ($_POST["txtaction"]){
			case "public": 		$obj->setActive($ids,1); 		break;
			case "unpublic": 	$obj->setActive($ids,0); 		break;
			case "edit": 	
				$id=explode("','",$ids);
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&task=edit&id=".$id[0]."'</script>";
				exit();
				break;
			case 'order':
				$sls=explode(',',$_POST['txtorders']); $ids=explode(',',$_POST['txtids']);
				$obj->Orders($ids,$sls); 	break;	
			case "delete": 		$obj->Delete($ids); 		break;
		}
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
	}
	$task = '';
	if(isset($_GET['task']))
		$task=$_GET['task'];
	if(!is_file(THIS_COM_PATH.'task/'.$task.'.php')){
		$task='list';
	}
	include_once(THIS_COM_PATH.'task/'.$task.'.php');
	unset($obj); unset($task);	unset($objlang); unset($ids);
?>