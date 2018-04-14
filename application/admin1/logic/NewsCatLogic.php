<?php

/**
 * tpshop
 * ============================================================================
 * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * Author: 当燃
 * Date: 2015-09-09
 */

namespace app\admin\logic;

use think\Model;
use think\Db;
/**
 * 分类逻辑定义
 * Class CatsLogic
 * @package Admin\Logic
 */
class NewsCatLogic extends Model
{

    /**
     * 获得指定分类下的子分类的数组
     *
     * @access  public
     * @param   int     $id     分类的ID
     * @param   int     $selected   当前选中分类的ID
     * @param   boolean $re_type    返回的类型: 值为真时返回下拉列表,否则返回数组
     * @param   int     $level      限定返回的级数。为0时返回所有级数
     * @return  mix
     */
    public function news_cat_list($id = 0, $selected = 0, $re_type = true, $level = 0)
    {
        static $res = NULL;
        
        if ($res === NULL)
        {
            $data = false;//read_static_cache('art_cat_pid_releate');
            if ($data === false)
            {
            	$cat_type = I('cat_type/d');
                $where = array();
            	if($cat_type != ""){
                    $where['c.cat_type'] = $cat_type;
            	}
                $res = DB::name('news_category')
                    ->field('c.*,count(s.id) as has_children')
                    ->alias('c')
                    ->join('__NEWS_CATEGORY__ s','s.pid = c.id','LEFT')
                    ->where($where)
                    ->group('c.id')
                    ->order('pid,sort')
                    ->select();
                //write_static_cache('art_cat_pid_releate', $res);
            }
            else
            {
                $res = $data;
            }
        }
    
        if (empty($res) == true)
        {
            return $re_type ? '' : array();
        }
    
        $options = $this->news_cat_options($id, $res); // 获得指定分类下的子分类的数组
    
        /* 截取到指定的缩减级别 */
        if ($level > 0)
        {
            if ($id == 0)
            {
                $end_level = $level;
            }
            else
            {
                $first_item = reset($options); // 获取第一个元素
                $end_level  = $first_item['level'] + $level;
            }
    
            /* 保留level小于end_level的部分 */
            foreach ($options AS $key => $val)
            {
                if ($val['level'] >= $end_level)
                {
                    unset($options[$key]);
                }
            }
        }
    
        $pre_key = 0;
        foreach ($options AS $key => $value)
        {
            $options[$key]['has_children'] = 1;
            if ($pre_key > 0)
            {
                if ($options[$pre_key]['id'] == $options[$key]['pid'])
                {
                    $options[$pre_key]['has_children'] = 1;
                }
            }
            $pre_key = $key;
        }
    
        if ($re_type == true)
        {
            $select = '';
            foreach ($options AS $var)
            {
                $select .= '<option value="' . $var['id'] . '" ';
                //$select .= ' cat_type="' . $var['cat_type'] . '" ';
                $select .= ($selected == $var['id']) ? "selected='ture'" : '';
                $select .= '>';
                if ($var['level'] > 0)
                {
                    $select .= str_repeat('&nbsp;', $var['level'] * 4);
                }
                $select .= htmlspecialchars(addslashes($var['name'])) . '</option>';
            }
    
            return $select;
        }
        else
        {
            foreach ($options AS $key => $value)
            {
                ///$options[$key]['url'] = build_uri('article_cat', array('acid' => $value['id']), $value['name']);
            }
            return $options;
        }
    }
    
    /**
     * 过滤和排序所有文章分类，返回一个带有缩进级别的数组
     *
     * @access  private
     * @param   int     $id     上级分类ID
     * @param   array   $arr        含有所有分类的数组
     * @param   int     $level      级别
     * @return  void
     */
    public function news_cat_options($spec_id, $arr)
    {
        static $cat_options = array();
    
        if (isset($cat_options[$spec_id]))
        {
            return $cat_options[$spec_id];
        }
    
        if (!isset($cat_options[0]))
        {
            $level = $last_id = 0;
            $options = $id_array = $level_array = array();
            while (!empty($arr))
            {
                foreach ($arr AS $key => $value)
                {
                    $id = $value['id'];
                    if ($level == 0 && $last_id == 0)
                    {
                        if ($value['pid'] > 0)
                        {
                            break;
                        }
    
                        $options[$id]          = $value;
                        $options[$id]['level'] = $level;
                        $options[$id]['id']    = $id;
                        $options[$id]['name']  = $value['name'];
                        unset($arr[$key]);
    
                        if ($value['has_children'] == 0)
                        {
                            continue;
                        }
                        $last_id  = $id;
                        $id_array = array($id);
                        $level_array[$last_id] = ++$level;
                        continue;
                    }
    
                    if ($value['pid'] == $last_id)
                    {
                        $options[$id]          = $value;
                        $options[$id]['level'] = $level;
                        $options[$id]['id']    = $id;
                        $options[$id]['name']  = $value['name'];
                        unset($arr[$key]);
    
                        if ($value['has_children'] > 0)
                        {
                            if (end($id_array) != $last_id)
                            {
                                $id_array[] = $last_id;
                            }
                            $last_id    = $id;
                            $id_array[] = $id;
                            $level_array[$last_id] = ++$level;
                        }
                    }
                    elseif ($value['pid'] > $last_id)
                    {
                        break;
                    }
                }
    
                $count = count($id_array);
                if ($count > 1)
                {
                    $last_id = array_pop($id_array);
                }
                elseif ($count == 1)
                {
                    if ($last_id != end($id_array))
                    {
                        $last_id = end($id_array);
                    }
                    else
                    {
                        $level = 0;
                        $last_id = 0;
                        $id_array = array();
                        continue;
                    }
                }
    
                if ($last_id && isset($level_array[$last_id]))
                {
                    $level = $level_array[$last_id];
                }
                else
                {
                    $level = 0;
                    break;
                }
            }
            $cat_options[0] = $options;
        }
        else
        {
            $options = $cat_options[0];
        }
    
        if (!$spec_id)
        {
            return $options;
        }
        else
        {
            if (empty($options[$spec_id]))
            {
                return array();
            }
    
            $spec_id_level = $options[$spec_id]['level'];
    
            foreach ($options AS $key => $value)
            {
                if ($key != $spec_id)
                {
                    unset($options[$key]);
                }
                else
                {
                    break;
                }
            }
    
            $spec_id_array = array();
            foreach ($options AS $key => $value)
            {
                if (($spec_id_level == $value['level'] && $value['id'] != $spec_id) ||
                    ($spec_id_level > $value['level']))
                {
                    break;
                }
                else
                {
                    $spec_id_array[$key] = $value;
                }
            }
            $cat_options[$spec_id] = $spec_id_array;
    
            return $spec_id_array;
        }
    }

}