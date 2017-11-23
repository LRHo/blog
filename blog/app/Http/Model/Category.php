<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = 'category';
    protected $primaryKey = 'cate_id';
    public $timestamps = false;
    protected $guarded = [];
//
    public function tree()
    {
        $category = $this -> all();
        return $this->getTree($category,'cate_id','cate_pid','cate_name');
    }
//二级子菜单分类方法
    public function getTree($data,$field_id='id',$field_pid='pid',$field_name='name',$pid=0){
        $arr = array();
        foreach($data as $k =>$v){
            if($v->$field_pid == $pid){
                $data[$k]["_".$field_name] = $data[$k][$field_name];
                $arr[]=$data[$k];
            }
            foreach($data as $m =>$n){
                if($n->$field_pid == $v->$field_id){
                    $data[$m]["_".$field_name] ='|--'. $data[$m][$field_name];
                    $arr[] = $data[$m];
                }
            }
        }
        return $arr;
    }
}
