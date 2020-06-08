<?php
class CLS_VIDEO{
    private $pro=array( 'ID'=>'-1',
        'VideoID'=>'',
        'Name'=>'','Code'=>'',
        'Link'=>'','Thumb'=>'',
        'Intro'=>'','Content'=>'',
        'isHot'=>'','Order'=>'',
        'Cdate'=>'','Mdate'=>'',
        'isActive'=>1);
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
    public function getList($where='',$limit=''){
        $sql="SELECT * FROM `tbl_video` ".$where.' ORDER BY `name` '.$limit;
        return $this->objmysql->Query($sql);
    }
    public function Num_rows(){
        return $this->objmysql->Num_rows();
    }
    public function Fetch_Assoc(){
        return $this->objmysql->Fetch_Assoc();
    }

    public function getNameById($id){
        $objdata=new CLS_MYSQL;
        $sql="SELECT `name` FROM `tbl_video`  WHERE isactive=1 AND `id` = '$id'";
        $objdata->Query($sql);
        $row=$objdata->Fetch_Assoc();
        return $row['name'];
    }

    /* get info video*/
    public function youtube_image($id) {
        $resolution = array (
            'mqdefault',
            'maxresdefault',
            'sddefault',
            'hqdefault'
            /*'default'*/
        );
        $url='';
        for ($x = 0; $x < sizeof($resolution); $x++) {
            $img=$resolution[$x];
            $url = 'http://img.youtube.com/vi/' . $id . '/' . $resolution[$x] . '.jpg';
            /* if (get_headers($url)[0] == 'HTTP/1.0 200 OK') {
                 break;
             }*/
        }
        return $url;
    }
    public function getTitle($id){
        $content = file_get_contents("http://youtube.com/get_video_info?video_id=".$id);
        parse_str($content, $ytarr);
        return $ytarr['title'];
    }
}
?>