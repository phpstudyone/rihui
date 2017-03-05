<?php
namespace core;
/**
 * Created by PhpStorm.
 * User: rihuizhang
 * Date: 17-2-12
 * Time: 下午4:21
 */
class Controller extends Object {
    /**
     * 获取请求组件
     * @var object
     */
    public $request;

    /**
     * 获取post参数
     * @var array
     */
    public $post;

    /**
     * 获取get参数
     * @var array
     */
    public $get;

    public function __construct()
    {
        parent::__construct();
        $this->request = new Request();
        $this->post = $this->request->post();
        $this->get = $this->request->get();
    }
}