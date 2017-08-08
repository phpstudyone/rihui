# 使用Authorize.net的SDK实现符合PCI标准的支付流程

PCI 标准是为了最大限度保护持卡人数据的一套标准。要求很多，可以看 [PCI标准](https://www.authorize.net/resources/pcicompliance/) 站点了解。要求挺多，对于程序猿来说，要保证的是用户的任何支付信息，都不走自己的服务器，不保存在自己的数据库。

## 一. 前期准备工作

### 1.1 注册一个沙盒环境账号 (必须)

[沙盒环境](https://sandbox.authorize.net/)账号，可以用来在[api文档页面](http://developer.authorize.net/api/reference/index.html)直接调试各种接口，也可以在沙盒里面查看各种扣款记录。

### 1.2 下载Authorize.net SDK （非必须）

下载[SDK 的地址](https://packagist.org/packages/authorizenet/authorizenet)到项目。

```sh
cd /your_php_project_path
composer require authorizenet/authorizenet
```

再在项目中引入即可（如何引入可以看上面地址的介绍，这里不再重复）。

该项目的GITHUB地址：[AuthorizeNet/sdk-php](https://github.com/AuthorizeNet/sdk-php) 可以在上面搜索、提出你的issues

使用SDK的php案列：[AuthorizeNet/sample-code-php](https://github.com/AuthorizeNet/sample-code-php)

Authorizenet官方实现的一个符合PCI标准的案列[AuthorizeNet/accept-sample-app](https://github.com/AuthorizeNet/accept-sample-app) （这个没有使用SDK）

### 1.3 不使用Authorize.net SDK （非必须）

因为Authorize.net SDK 要求 php: >=5.5 ， 所以只能自己封装api请求了，具体如何封装个人自便，但要说明的一点是，Authorize.net 的api，如果选择的是json格式：

```php
header("Content-type:text/json;charset=utf-8");
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $this->authorizeUrl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_COOKIESESSION, true);
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode($data));
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
// curl_setopt($curl, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain')); //xml request
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
$result    = curl_exec($curl);
$curlErrno = curl_errno($curl);
$curlError = curl_error($curl);
curl_close($curl);
```

返回的数据也是JSON格式，but。。。。，这个返回的json数据，是无法用

```php
json_decode($result,true)
```

来解析的，需要

```php
json_decode(substr($result, 3), true);
```

来解析。究其原因，应该是它返回的数据带了BOM头，详细请移步 [json-decode-returns-null](https://stackoverflow.com/questions/689185/json-decode-returns-null-after-webservice-call)

XML格式我没有去写代码测试，各位有兴趣可以自行测试，也可以在沙盒环境直接测试。

### 1.4 各种环境地址

| 内容           | 测试环境   |生产环境|
| :------        | :------        | :------|
|api请求地址         | [apitest url](https://apitest.authorize.net/xml/v1/request.api)         | [api url](https://api.authorize.net/xml/v1/request.api)|
|Accept.js       | [Accept jstest url](https://jstest.authorize.net/v1/Accept.js)      |  [Accept js url](https://js.authorize.net/v1/Accept.js)|
|请求支付表单| [test payment/payment](https://test.authorize.net/payment/payment)          |  [accept payment/payment](https://accept.authorize.net/payment/payment)|
|Manage Profiles| [Manage Profiles](https://accept.authorize.net/customer/manage ) |[Manage Profiles](https://accept.authorize.net/customer/manage)|
|Add Payment Profile| [Add Payment Profile](https://accept.authorize.net/customer/addPayment) |[Add Payment Profile](https://accept.authorize.net/customer/addPayment)|
|Add Shipping Profile| [Add Shipping Profile](https://accept.authorize.net/customer/addShipping) |[Add Shipping Profile](https://accept.authorize.net/customer/addShipping)|
|Edit Payment Profile| [Edit Payment Profile](https://accept.authorize.net/customer/editPayment) |[Edit Payment Profile](https://accept.authorize.net/customer/editPayment)|
|Edit Shipping Profile| [Edit Shipping Profile](https://accept.authorize.net/customer/editShipping) |[Edit Shipping Profile](https://accept.authorize.net/customer/editShipping)|
