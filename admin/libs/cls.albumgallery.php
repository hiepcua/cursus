<?php
class CLS_ALBUMGALLERY{
	private $pro=array( 'ID'=>'-1',
                         'GroupID'=>'',
                         'Name'=>'',
                           'Thumb'=>'',
                         'Intro'=>'',
                         'Code'=>'',
                         'Cdate'=>'',
                         'isActive'=>'',
						'GAlbumID'=>'',
						'GLink'=>'',
						'GisActive'=>1);
	private $objmysql=NULL;
	function __construct(){
		$this->objmysql=new CLS_MYSQL;
	}
	// property set value
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo ('Can not found $proname member');
			return;
		}
		$this->pro[$proname]=$value;
	}
	public function __get($proname){
		if(!isset($this->pro[$proname])){
			echo ("Can not found $proname member");
			return;
		}
		return $this->pro[$proname];
	}
	public function getListAlbum($where='',$limit=''){
		$sql="SELECT * FROM `tbl_album` ".$where.' ORDER BY id DESC'.$limit;
		return $this->objmysql->Query($sql);
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	function listAlbum($curid=0) {
		$sql="SELECT id,name FROM tbl_album WHERE isactive=1 ORDER BY id DESC";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		while($rows=$objdata->Fetch_Assoc())
		{
			if($rows['id']== $curid)
				echo '<option value="'.$rows['id'].'" selected="selected">'.$rows['name'].'</option>';
			else echo '<option value="'.$rows['id'].'">'.$rows['name'].'</option>';
		}
	}
    function getThumbByAlbum($album_id){
        $sql="SELECT * FROM `tbl_gallery` WHERE album_id='$album_id'";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        $rows=$objdata->Fetch_Assoc();
        $img=$rows['link'];
        if($img!=''){
            $img = strpos($img,'http')!==false?$img:ROOTHOST_FRONTEND.PATH_GALLERY_REVIEW.$img;

        }
        else $img=THUMB_DEFAULT;
        $img = '<img src="'.$img.'" height="45" width="80"/>';
        return $img;
    }
}
?>