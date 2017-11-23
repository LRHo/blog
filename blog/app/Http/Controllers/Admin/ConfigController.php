<?php

namespace App\Http\Controllers\admin;

use App\Http\Model\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    //get.admin/config 全部配置列表
    public function index()
    {
        $data=Config::orderBy('conf_order','asc')->get();
        foreach($data as $k =>$v){
            switch($v->field_type){
                case 'input':
                    $data[$k] -> _html='<input type="text" class="lg" name="conf_content[]"
                                        value="'.$v -> conf_content.'">';
                    break;
                case 'textarea':
                    $data[$k] -> _html='<textarea type="text" class="lg"  name="conf_content[]"
                                            style="resize: none" >'.$v -> conf_content.'</textarea>';
                    break;
                case 'radio':
                    //1|开启，0|关闭
                    $arr = explode(',',$v->field_value);
                    $str = '';
                    foreach($arr as $m=>$n) {
                        $arr_1 = explode('|', $n);
                        $c = $v -> conf_content == $arr_1[0]? 'checked': '' ;
                        $str .= '<input type="radio" name="conf_content[]"
                                value="'.$arr_1[0].'" '.$c.'>'.$arr_1[1].'　';
                    }
                    $data[$k] -> _html = $str;
                    break;
            }
        }
        return view('admin.config.index',compact('data'));
    }

    //get.admin/config/create 添加配置
    public function create()
    {
        return view('admin/config/add');

    }

    //post.admin/config 添加配置 提交*验证
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'conf_name' => 'required',
            'conf_title' => 'required',
        ];
        $massage = [
            'conf_name.required'=>'配置名称不能为空',
            'conf_title.required'=>'配置标题不能为空',
        ];
        $validator = Validator::make($input, $rules, $massage);
        if ($validator->passes()) {
            $re = Config::create($input);
            if($re){
                return redirect('admin/config');
            }else{
                return back()->with('errors','提交数据错误，请稍后重试！');
            }

        } else {
            return back()->withErrors($validator);
        }

    }

    //修改内容
    public function changeContent()
    {
        $input = Input::all();
        foreach($input['conf_id'] as $k => $v){
            Config::where('conf_id',$v)->update(['conf_content'=>$input['conf_content'][$k]]);
        }
        $this->putFile();
        return back();
    }

    //写入配置项
    public function putFile()
    {
        $config = Config::pluck('conf_content','conf_name')->all();
        $path = base_path().'\config\web.php';
        $str = '<?php return '.var_export($config,true).';';
        file_put_contents($path,$str);
    }
    //更改排序
    public function changeOrder()
    {

        $input = Input::all();
        $conf = Config::find($input['conf_id']);
        $conf ->conf_order = $input['conf_order'];
        $re = $conf->update();
        if($re){
            $data = [
                'status'=>0,
                'msg'=>'更新成功',
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'更新失败',
            ];
        }
        return $data;
    }

    //delete.admin/config/{config} 删除单个配置
    public function destroy($conf_id)
    {
        $re = Config::where('conf_id', $conf_id)->delete();
        if ($re) {
            $this->putFile();
            $data = [
                'status' => 0,
                'msg' => '删除成功！',
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '删除失败,请稍后重试！',
            ];
        }
        return $data;
    }
    //get.admin/config/{config}/edit 编辑（修改）配置
    public function edit($conf_id)
    {
        $field = Config::find($conf_id);
        return view('admin.config.edit',compact('field'));
    }

    //put.admin/config/{config} 更新配置
    public function update($conf_id)
    {
        $input = Input::except('_token','_method');
        $re = Config::where('conf_id',$conf_id)->update($input);
        if($re)
        {
            $this->putFile();
            return redirect('admin/config');
        }else
        {
            return back()->with('errors','编辑失败，请重试！');
        }

    }
}
