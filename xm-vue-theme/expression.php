<?php
  header('Access-Control-Allow-Origin:*');
  header('Content-type:text/json');
  $url = dirname($_SERVER["REQUEST_URI"]);
  $array = array(
    'weixiao'   => array(
      'url'     => $url . '/static/images/smilies/weixiao.gif',
      'title'   => '微笑'
    ),
    'nanguo'    => array(
      'url'     => $url . '/static/images/smilies/nanguo.gif',
      'title'   => '难过'
    ),
    'qiudale'   => array(
      'url'     => $url . '/static/images/smilies/qiudale.gif',
      'title'   => '糗大了'
    ),
    'penxue'    => array(
      'url'     => $url . '/static/images/smilies/penxue.gif',
      'title'   => '喷血'
    ),
    'piezui'    => array(
      'url'     => $url . '/static/images/smilies/piezui.gif',
      'title'   => '撇嘴'
    ),
    'aoman'     => array(
      'url'     => $url . '/static/images/smilies/aoman.gif',
      'title'   => '傲慢'
    ),
    'baiyan'    => array(
      'url'     => $url . '/static/images/smilies/baiyan.gif',
      'title'   => '白眼'
    ),
    'bishi'     => array(
      'url'     => $url . '/static/images/smilies/bishi.gif',
      'title'   => '鄙视'
    ),
    'bizui'     => array(
      'url'     => $url . '/static/images/smilies/bizui.gif',
      'title'   => '闭嘴'
    ),
    'ciya'      => array(
      'url'     => $url . '/static/images/smilies/ciya.gif',
      'title'   => '呲牙'
    ),
    'dabing'    => array(
      'url'     => $url . '/static/images/smilies/dabing.gif',
      'title'   => '大兵'
    ),
    'daku'      => array(
      'url'     => $url . '/static/images/smilies/daku.gif',
      'title'   => '大哭'
    ),
    'deyi'      => array(
      'url'     => $url . '/static/images/smilies/deyi.gif',
      'title'   => '得意'
    ),
    'doge'      => array(
      'url'     => $url . '/static/images/smilies/doge.gif',
      'title'   => 'doge'
    ),
    'fadai'     => array(
      'url'     => $url . '/static/images/smilies/fadai.gif',
      'title'   => '发呆'
    ),
    'fanu'      => array(
      'url'     => $url . '/static/images/smilies/fanu.gif',
      'title'   => '发怒'
    ),
    'fendou'    => array(
      'url'     => $url . '/static/images/smilies/fendou.gif',
      'title'   => '奋斗'
    ),
    'ganga'     => array(
      'url'     => $url . '/static/images/smilies/ganga.gif',
      'title'   => '尴尬'
    ),
    'guzhang'   => array(
      'url'     => $url . '/static/images/smilies/guzhang.gif',
      'title'   => '鼓掌'
    ),
    'haixiu'    => array(
      'url'     => $url . '/static/images/smilies/haixiu.gif',
      'title'   => '害羞'
    ),
    'hanxiao'   => array(
      'url'     => $url . '/static/images/smilies/hanxiao.gif',
      'title'   => '憨笑'
    ),
    'haqian'    => array(
      'url'     => $url . '/static/images/smilies/haqian.gif',
      'title'   => '哈欠'
    ),
    'huaixiao'  => array(
      'url'     => $url . '/static/images/smilies/huaixiao.gif',
      'title'   => '坏笑'
    ),
    'jie'       => array(
      'url'     => $url . '/static/images/smilies/jie.gif',
      'title'   => '饥饿'
    ),
    'jingkong'  => array(
      'url'     => $url . '/static/images/smilies/jingkong.gif',
      'title'   => '惊恐'
    ),
    'jingxi'    => array(
      'url'     => $url . '/static/images/smilies/jingxi.gif',
      'title'   => '惊喜'
    ),
    'jingya'    => array(
      'url'     => $url . '/static/images/smilies/jingya.gif',
      'title'   => '惊讶'
    ),
    'keai'      => array(
      'url'     => $url . '/static/images/smilies/keai.gif',
      'title'   => '可爱'
    ),
    'kelian'    => array(
      'url'     => $url . '/static/images/smilies/kelian.gif',
      'title'   => '可怜'
    ),
    'koubi'     => array(
      'url'     => $url . '/static/images/smilies/koubi.gif',
      'title'   => '抠鼻'
    ),
    'ku'        => array(
      'url'     => $url . '/static/images/smilies/ku.gif',
      'title'   => '酷'
    ),
    'kuaikule'  => array(
      'url'     => $url . '/static/images/smilies/kuaikule.gif',
      'title'   => '快哭了'
    ),
    'kulou'     => array(
      'url'     => $url . '/static/images/smilies/kulou.gif',
      'title'   => '骷髅'
    ),
    'kun'       => array(
      'url'     => $url . '/static/images/smilies/kun.gif',
      'title'   => '困'
    ),
    'leiben'    => array(
      'url'     => $url . '/static/images/smilies/leiben.gif',
      'title'   => '泪奔'
    ),
    'lenghan'   => array(
      'url'     => $url . '/static/images/smilies/lenghan.gif',
      'title'   => '冷汗'
    ),
    'liuhan'    => array(
      'url'     => $url . '/static/images/smilies/liuhan.gif',
      'title'   => '流汗'
    ),
    'liulei'    => array(
      'url'     => $url . '/static/images/smilies/liulei.gif',
      'title'   => '流泪'
    ),
    'qiaoda'    => array(
      'url'     => $url . '/static/images/smilies/qiaoda.gif',
      'title'   => '敲打'
    ),
    'qinqin'    => array(
      'url'     => $url . '/static/images/smilies/qinqin.gif',
      'title'   => '亲亲'
    ),
    'saorao'    => array(
      'url'     => $url . '/static/images/smilies/saorao.gif',
      'title'   => '骚扰'
    ),
    'shuai'     => array(
      'url'     => $url . '/static/images/smilies/shuai.gif',
      'title'   => '衰'
    ),
    'shui'      => array(
      'url'     => $url . '/static/images/smilies/shui.gif',
      'title'   => '睡'
    ),
    'tiaopi'    => array(
      'url'     => $url . '/static/images/smilies/tiaopi.gif',
      'title'   => '调皮'
    ),
    'touxiao'   => array(
      'url'     => $url . '/static/images/smilies/touxiao.gif',
      'title'   => '偷笑'
    ),
    'tu'        => array(
      'url'     => $url . '/static/images/smilies/tu.gif',
      'title'   => '吐'
    ),
    'tuosai'    => array(
      'url'     => $url . '/static/images/smilies/tuosai.gif',
      'title'   => '托腮'
    ),
    'weiqu'     => array(
      'url'     => $url . '/static/images/smilies/weiqu.gif',
      'title'   => '委屈'
    ),
    'wozuimei'  => array(
      'url'     => $url . '/static/images/smilies/wozuimei.gif',
      'title'   => '我最美'
    ),
    'wunai'     => array(
      'url'     => $url . '/static/images/smilies/wunai.gif',
      'title'   => '无奈'
    ),
    'xia'       => array(
      'url'     => $url . '/static/images/smilies/xia.gif',
      'title'   => '吓'
    ),
    'xiaojiujie'=> array(
      'url'     => $url . '/static/images/smilies/xiaojiujie.gif',
      'title'   => '小纠结'
    ),
    'xiaoku'   => array(
      'url'     => $url . '/static/images/smilies/xiaoku.gif',
      'title'   => '笑哭'
    ),
    'xieyanxiao'=> array(
      'url'     => $url . '/static/images/smilies/xieyanxiao.gif',
      'title'   => '斜眼笑'
    ),
    'xu'        => array(
      'url'     => $url . '/static/images/smilies/xu.gif',
      'title'   => '嘘'
    ),
    'yinxian'   => array(
      'url'     => $url . '/static/images/smilies/yinxian.gif',
      'title'   => '阴险'
    ),
    'yiwen'     => array(
      'url'     => $url . '/static/images/smilies/yiwen.gif',
      'title'   => '疑问'
    ),
    'zuohengheng'=> array(
      'url'     => $url . '/static/images/smilies/zuohengheng.gif',
      'title'   => '左哼哼'
    ),
    'youhengheng'=> array(
      'url'     => $url . '/static/images/smilies/youhengheng.gif',
      'title'   => '右哼哼'
    ),
    'yun'       => array(
      'url'     => $url . '/static/images/smilies/yun.gif',
      'title'   => '晕'
    ),
    'zaijian'   => array(
      'url'     => $url . '/static/images/smilies/zaijian.gif',
      'title'   => '再见'
    ),
    'zhayanjian'=> array(
      'url'     => $url . '/static/images/smilies/zhayanjian.gif',
      'title'   => '眨眼睛'
    ),
    'zhemo'     => array(
      'url'     => $url . '/static/images/smilies/zhemo.gif',
      'title'   => '折磨'
    ),
    'zhouma'    => array(
      'url'     => $url . '/static/images/smilies/zhouma.gif',
      'title'   => '咒骂'
    ),
    'zhuakuang' => array(
      'url'     => $url . '/static/images/smilies/zhuakuang.gif',
      'title'   => '抓狂'
    ),
    'aini'      => array(
      'url'     => $url . '/static/images/smilies/aini.gif',
      'title'   => '爱你'
    ),
    'baoquan'   => array(
      'url'     => $url . '/static/images/smilies/baoquan.gif',
      'title'   => '抱拳'
    ),
    'gouyin'    => array(
      'url'     => $url . '/static/images/smilies/gouyin.gif',
      'title'   => '勾引'
    ),
    'qiang'     => array(
      'url'     => $url . '/static/images/smilies/qiang.gif',
      'title'   => '强'
    ),
    'OK'        => array(
      'url'     => $url . '/static/images/smilies/OK.gif',
      'title'   => 'OK'
    ),
    'quantou'   => array(
      'url'     => $url . '/static/images/smilies/quantou.gif',
      'title'   => '拳头'
    ),
    'shengli'   => array(
      'url'     => $url . '/static/images/smilies/shengli.gif',
      'title'   => '胜利'
    ),
    'aixin'     => array(
      'url'     => $url . '/static/images/smilies/aixin.gif',
      'title'   => '爱心'
    ),
    'bangbangtang'=> array(
      'url'     => $url . '/static/images/smilies/bangbangtang.gif',
      'title'   => '棒棒糖'
    ),
    'baojin'    => array(
      'url'     => $url . '/static/images/smilies/baojin.gif',
      'title'   => '爆筋'
    ),
    'caidao'    => array(
      'url'     => $url . '/static/images/smilies/caidao.gif',
      'title'   => '菜刀'
    ),
    'chi'       => array(
      'url'     => $url . '/static/images/smilies/chi.gif',
      'title'   => '吃'
    ),
    'dan'       => array(
      'url'     => $url . '/static/images/smilies/dan.gif',
      'title'   => '蛋'
    ),
    'haobang'   => array(
      'url'     => $url . '/static/images/smilies/haobang.gif',
      'title'   => '好棒'
    ),
    'hecai'     => array(
      'url'     => $url . '/static/images/smilies/hecai.gif',
      'title'   => '喝彩'
    ),
    'hexie'     => array(
      'url'     => $url . '/static/images/smilies/hexie.gif',
      'title'   => '河蟹'
    ),
    'juhua'     => array(
      'url'     => $url . '/static/images/smilies/juhua.gif',
      'title'   => '菊花'
    ),
    'pijiu'     => array(
      'url'     => $url . '/static/images/smilies/pijiu.gif',
      'title'   => '啤酒'
    ),
    'shouqiang' => array(
      'url'     => $url . '/static/images/smilies/shouqiang.gif',
      'title'   => '手枪'
    ),
    'xiaoyanger'=> array(
      'url'     => $url . '/static/images/smilies/xiaoyanger.gif',
      'title'   => '小样儿'
    ),
    'xigua'     => array(
      'url'     => $url . '/static/images/smilies/xigua.gif',
      'title'   => '西瓜'
    ),
    'yangtuo'   => array(
      'url'     => $url . '/static/images/smilies/yangtuo.gif',
      'title'   => '羊驼'
    ),
    'youling'   => array(
      'url'     => $url . '/static/images/smilies/youling.gif',
      'title'   => '幽灵'
    )
  );
  echo urldecode(json_encode($array));
?>
