# docker 基本操作命令

## 安装mysql镜像

```sh
docker pull mysql
```

## 查看镜像

```sh
docker images
```

## 创建并运行容器

```sh
docker run --name mysql-2 -e MYSQL_ROOT_PASSWORD=123456 -p 172.26.10.124:3306:3306 -d mysql:latest
```

## 查看运行的容器

```sh
docker ps
```

## 查看所有的容器

```sh
docker ps -a
```

## 进入容器

```sh
docker exec -ti mysql-2  bash
```

## 停止容器

```sh
docker stop 27
```

## 删除容器

```sh
docker rm xxx
```

## 重启容器

```sh
docker start xxxx
```

## 登录容器

```sh
docker login -u username -p password domain
```

## docker 打包推送到hub.docker.com

### 登录

```docker
docker login
```

### 打包要push的容器为一个镜像

```docker
docker commit -m"包含tbl完整数据的数据库" 624288e04ad2 mysql-jason:1.02
```

### 给images打tag

```docker
docker tag b58a58b5eeae  phpstudy/mysql-tbl:1.03
```

### 推送

```docker
docker push phpstudy/mysql-tbl:1.03
```
