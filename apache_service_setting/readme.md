
APACHE SERVICE SETTING
=====================

**apache关于安全和优化的一些设置**
***
###一：Disable HTTP TRACE Method for Apache
**禁用apache的http的trace方法**

    在apache的配置文件中查找 TraceEnable 配置，如果有，改为 OFF ，不存在的话，在文件末尾添加
    TraceEnable off
####1. TraceEnable off 前的测试
执行
```sh
openssl s_client -connect local.tbl.com:443
```
输入以下语句两次按两次回车键

    TRACE / HTTP/1.0
    X-Test:abcde
结果返回 200 ，此时trace方法没有禁用。如图：
![trace_on](https://raw.githubusercontent.com/phpstudyOne/rihui/apache_service_setting/apache_service_setting/images/trace_on.png)
####2. TraceEnable off 后的测试
步骤同上，结果返回405，此时trace方法已被禁用。如图：
![trace_off](https://raw.githubusercontent.com/phpstudyOne/rihui/apache_service_setting/apache_service_setting/images/trace_off.png)
***
###二：Disable web directory browsing for all directories and subdirectories
**禁止浏览项目目录**

    修改 httpd-vhosts.conf 中 VirtualHost 的 Options 配置
    把   Options Indexes FollowSymLinks
    改为 Options FollowSymLinks
本地测试案例：  
有indexes 配置，在找不到 index 相关文件，输出目录
![noindexes](https://raw.githubusercontent.com/phpstudyOne/rihui/apache_service_setting/apache_service_setting/images/noindexes.png)

无 indexes 配置，在找不到 index 相关文件，返回 403
![indexes](https://raw.githubusercontent.com/phpstudyOne/rihui/apache_service_setting/apache_service_setting/images/indexes.png)

只有文件存在，才正常返回
![isexit](https://raw.githubusercontent.com/phpstudyOne/rihui/apache_service_setting/apache_service_setting/images/isexit.png)
***
###三：Use Digest Authentication
**使用digest Authentication**
***
###四：Disable insecure TLS/SSL protocol support AND Enable only TLS 1.2
**禁用不安全的TLS/SSL链接，只是用TLS version 1.2**

####  1.搜索SSLProtocol,查看配置文件
```sh
grep -i -r "SSLProtocol" /etc/apache2
```
或者在httpd搜索
```sh
grep -i -r "SSLProtocol" /etc/httpd
```
   如图示：![SSLProtocol](https://github.com/phpstudyOne/rihui/blob/apache_service_setting/apache_service_setting/images/sslProtocol.png)
   
使用vim编辑器，进入到 `vim /etc/apache2/mods-available/ssl.conf` 编辑以下部分
![vim1](https://github.com/phpstudyOne/rihui/blob/apache_service_setting/apache_service_setting/images/vim1.png)

    其中 all -SSLv 表示支持所有所有类型的ssl，但是不支持SSLv3。
    这里我们需要更改为 SSLProtocol  TLSv1.2

####2. 搜索SSLEngine,查看配置文件
```sh
grep -i -r "SSLEngine" /etc/apache2
```
或者在httpd搜索
```sh
grep -i -r "SSLEngine" /etc/httpd
```
如图示：![SSLEngine](https://raw.githubusercontent.com/phpstudyOne/rihui/apache_service_setting/apache_service_setting/images/sslengine.png)

使用vim编辑器，进入到 `vim /etc/apache2/sites-enabled/qa-www-server-ssl.conf` 编辑以下部分
![vim2](https://raw.githubusercontent.com/phpstudyOne/rihui/apache_service_setting/apache_service_setting/images/vim2.png)

####3. 重启apache服务器
``` sh
service apache2 restart
```
参考资料：[Apache Module mod_ssl](http://httpd.apache.org/docs/2.4/mod/mod_ssl.html#sslengine)
***
