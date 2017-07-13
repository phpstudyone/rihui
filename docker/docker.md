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