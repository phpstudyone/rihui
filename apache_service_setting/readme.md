
APACHE SERVICE SETTING
=====================

**apache关于安全和优化的一些设置**
***
###Disable HTTP TRACE Method for Apache
**禁用apache的http的trace方法**
***
###Disable web directory browsing for all directories and subdirectories
**禁止浏览项目目录**
***
###Use Digest Authentication
**使用digest Authentication**
***
###Disable insecure TLS/SSL protocol support AND Enable only TLS 1.2
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
![vim1](https://lh3.google.com/u/0/d/0B-rwyQbz4OanSVFqTFlkeTcxbmM=w1920-h912-iv1)

其中 all -SSLv 表示支持所有所有类型的ssl，但是不支持SSLv3。
这里我们需要更改为 **`SSLProtocol  TLSv1.2`**

####2. 搜索SSLEngine,查看配置文件
```sh
grep -i -r "SSLEngine" /etc/apache2
```
或者在httpd搜索
```sh
grep -i -r "SSLEngine" /etc/httpd
```
如图示：![SSLEngine](https://lh3.google.com/u/0/d/0B-rwyQbz4OanRDVhVnExM1dsSjg=w1920-h491-iv1)

使用vim编辑器，进入到 `vim /etc/apache2/sites-enabled/qa-www-server-ssl.conf` 编辑以下部分
![vim2](https://lh3.google.com/u/0/d/0B-rwyQbz4OanSk1vN0cwanpuSkE=w1920-h491-iv1)

####3. 重启apache服务器
``` sh
service apache2 restart
```
参考资料：[Apache Module mod_ssl](http://httpd.apache.org/docs/2.4/mod/mod_ssl.html#sslengine)
***
