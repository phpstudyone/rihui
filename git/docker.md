安装mysql镜像
docker pull mysql

查看镜像
docker images

创建比运行容器
docker run --name mysql-2 -e MYSQL_ROOT_PASSWORD=123456 -p 172.26.10.124:3306:3306 -d mysql:latest

查看运行的容器
docker ps

进入容器
docker exec -ti mysql-2  bash

停止容器
docker stop 27