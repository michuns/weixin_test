<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/19
 * Time: 14:58
 */

namespace wxchat;


class wxapi
{
    //微信API域名
    const WX_URL = 'https://api.weixin.qq.com/';

    //页面授权
    const SNSAPI_BASE = "snsapi_base";
    const SNSAPI_USERINFO = "snsapi_userinfo";

    // 开发者中心
    protected $appId;
    protected $appSecret;

    // 微信支付商户号，商户申请微信支付后，由微信支付分配的商户收款账号
    protected $mchId;

    // access_token的方法
    protected $get_access_token;
    protected $set_access_token;

    // jsapi_ticket的方法
    protected $get_jsapi_ticket;
    protected $set_jssapi_ticket;

    // 错误信息
    protected $errMsg;

    // 自动载入的
    public function __construct( $_config)
    {
        $this->appId     = isset($_config['app_id']) ? $_config['app_id'] : '';
        $this->appSecret = isset($_config['app_secret']) ? $_config['app_secret'] : '';
    }

    /**
     * 获取 token
     * @return null|string
     */
    public function getAccessToken( )
    {
        // 如果是企业号用以下URL获取access_token
        $url = self::WX_URL . "cgi-bin/token?grant_type=client_credential&appid={$this->appId}&secret={$this->appSecret}";

        // 请求
        $curl = new HttpCurl();
        $data =   $curl->get($url, 'json');

        //  异常处理: 获取access_token网络错误
        if(empty($data)){
            $this->errMsg = 'information error';
            return false;
        }

        //
        if (!isset($data->access_token)) {
            $this->errMsg =  json_encode($data);
            return false;
        }

        $data->expires_in += time();
        return $data;
    }

    /**
     * 网页授权  通过code 获取token
     * @param string $code 网页授权的code
     * @return object object
     */
    public function oauth2token($code)
    {
        $url = self::WX_URL . '/sns/oauth2/access_token';
        $url = $url . "?appid={$this->appId}&secret={$this->appSecret}&code={$code}&grant_type=authorization_code";

        // 请求
        $curl = new HttpCurl();
        $data = $curl->get( $url);

        return $data;
    }


    /**
     * 通过网面授权 得到access_token 和  openId, 获取得用户信息
     * @param $token  string
     * @param $openId string
     * @return object
     */
    public function getUserInfo( $token, $openId)
    {

        $url = self::WX_URL . '/sns/userinfo';
        $url = $url . "?access_token={$token}&openid={$openId}&lang=zh_CN";

        // 请求
        $curl = new HttpCurl();
        $data = $curl->get($url);
        return $data;
    }


    /**
     * 获取用户基本信息
     * @param $token string
     * @param $openId string
     * @return object
     */
    public function getUser( $token, $openId)
    {
        $url = self::WX_URL . "cgi-bin/user/info?access_token={$token}&openid={$openId}&lang=zh_CN";

        // 请求
        $curl = new HttpCurl();
        $data = $curl->get($url);
        return $data;
    }

    // 获取 微信Ip
    public function wxip($token)
    {
        $url = self::WX_URL . 'cgi-bin/getcallbackip?access_token='. $token;
        return $url;
    }



    // ========== =========== =========== ==========
    /**
     * 获取 错误提示
     * @return mixed
     */
    public function getError()
    {
        return $this->errMsg;
    }

}