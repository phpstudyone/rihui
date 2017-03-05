<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/2/16
 * Time: 18:36
 */
namespace core;

class Object{

    /**
     * 获取配置组件
     * @var object
     */
    public $config;

    /**
     * 命名空间
     * @var string
     */
    public $namespace;

    /**
     * 类名(完整类名)
     * @var string
     */
    public $className;

    /**
     * 类名(去掉命名空间的类名)
     * @var string
     */
    public $shortName;

    /**
     * Object constructor.
     */
    public function __construct()
    {
        $class = get_called_class();
        $class = new \ReflectionClass($class);
        $this->namespace = $class->getNamespaceName();
        $this->className = $class->getName();
        $this->shortName = $class->getShortName();
        $this->request = new Request();
        $this->post = $this->request->post();
        $this->get = $this->request->get();
        $this->config = Config::getConfig();
    }
}