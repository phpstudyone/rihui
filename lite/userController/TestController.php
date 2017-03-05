<?php
/**
 * Created by PhpStorm.
 * User: rihuizhang
 * Date: 17-2-11
 * Time: 下午10:04
 */
namespace userController;
use base\BaseController;

class TestController extends BaseController  {
    /**
     * 测试方法
     * @param string $param1
     * @param string $param2
     */
    public function TestAction(){
        $send = $this->sendEmail('aaaaa','cccc','517690962@qq.com');
        dump($send);die;
        dump($this->request->get());
        dump($this);
    }

    public function SendAction(){
//        $url = "http://api.51yund.com/sport/get_phone_registerd";
        $url = "http://api.51yund.com/sport/send_phone_verify_code";
//        $data = [
//            'device_id_type' => 1,
//            'screen_densityDpi' => 480,
//            'sdk' => 24,
//            'sign' => 'NQT8ck2FyfZgtIPH8SQ2kLO1VXk=',
//            'source' => 'android_app',
//            'mac' => '02:00:00:00:00:00',
//            'phone' => '18071877510',
//            'screen_density' => '3.0',
//            'client_user_id' => -1,
//            'os' => '7.0',
//            'screen_height' => '1080',
//            'phone_type' => 'huawei_huaweinxt-al10_7.0',
//            'channel' => 'channel_huawei',
//            'ver' => '3.1.2.9.656'
//        ];

//        $data = 'screen_densityDpi=480&sdk=24&sign=9SQMTPWwslE5Kv0sqKI7GsRYYnI%3D&source=android_app&mac=02%3A00%3A00%3A00%3A00%3A00&phone=18071877530&screen_density=3.0&client_user_id=-1&os=7.0&device_id_type=1&screen_height=1812&device_id=860983039344714&xyy=&language=zh&screen_width=1080&phone_type=huawei_huaweinxt-al10_7.0&channel=channel_huawei&ver=3.1.2.9.656';
        $data ='screen_densityDpi=480&sdk=24&sign=YbicIDSx85tXw5vVGa8YvO8s8Bw%3D&source=android_app&mac=02%3A00%3A00%3A00%3A00%3A00&phone=18071877530&screen_density=3.0&client_user_id=-1&os=7.0&device_id_type=1&screen_height=1812&device_id=860983039344714&xyy=&language=zh&screen_width=1080&phone_type=huawei_huaweinxt-al10_7.0&channel=channel_huawei&ver=3.1.2.9.656';
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);			// 执行之后不直接打印出来
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 这样能够让cURL支持页面链接跳转
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("application/x-www-form-urlencoded; charset=utf-8",
            "Content-length: ".strlen($data)
        ));
        $content = curl_exec($ch);
        curl_close($ch);
        dump($content);die;
    }

    /**
     * 生成自定义控制器模板方法
     * @param $controllerName
     */
    public function CreateAction($controllerName=""){
        if(!$controllerName){
            echo "请不要忘记输入要生成的控制器名\r\n";
        }
        $controllerName = ucfirst(strtolower($controllerName)) . "Controller";
        $path = USER_CONTROLLER_PATH . $controllerName . ".php";
        $str = file_get_contents(CONFIG_PATH . 'createTemplet');
        $str = str_replace('HelloController',$controllerName,$str);
        file_put_contents($path,$str);
    }
}