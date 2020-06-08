<?php
$arr_com=array('user','module','category','content','catalog','product','order');


$arr_com=array(
	'user'=>array('add','edit','delete'),
	'module'=>array('add','edit','delete'),
	'category'=>array('add','edit','delete'),
	'content'=>array('add','edit','delete'),
	'catalog'=>array('add','edit','delete'),
	'product'=>array('add','edit','delete'),
	'order'=>array('add','edit','delete')
	'user'=>array('add','edit','delete','permission')
);
function is_com_permis($user_permis,$com,$task){
	if(!isset($arr_com[$com])) return false;
	if($task!=''){
		$n=count($user_permis[$com]);
		for($i=0;$i<$n;$i++){
			if($user_permis[$com][$i]==$task){
				return true;
			}
		}
		return false;
	}
	return true;
}
// add ruler:
// liệt kê com và add để tich những quyền user đó có
// permis ('com1'=>array('tas1','task2','task3','task4'),'com2'=>array('tas1','task2','task3','task4'));
