# GIT操作
### 查看本地所有分支
```sh
git branch
```
### 切换到对应分支
```sh
git checkout bug/#136147581_fix_the_idle_time_to_6_months
```

### 新建分支
```sh
git checkout -b branchName
```

### 删除本地分支
```sh
git branch -D branchName
```
### 拉去远程分支到本地
```sh
git fetch origin branchName:branchName
```

### 拉去远程分支更新到本地
```sh
git pull origin branchName
```

### 本地分支建立到远程分支的跟踪（这样只需要执行git pull 就可以拉取更新）
```sh
git branch --set-upstream-to=origin/branchName branchName
```

### 推送本地分支到远程
```sh
git push origin branchName
```

### 为推送当前分支并建立与远程上游的跟踪，使用
```sh
git push --set-upstream origin develop
```

### 进行rebase操作
```sh
git rebase origin/develop
```
### 进行push操作
```sh
git push -f
```
### 忽略文件权限 ###
``` sh
git config core.filemode false
```
### 使全局忽略文件生效 ###
``` sh
git config --global core.excludesfile ~/.gitignoreglobal (注意路径)
```
### 查看某个人的提交历史 ###
``` sh
git log --author=Jason
```
### 查看最近20条提交历史 ###
``` sh
git log -20 --pretty=oneline
```

### 将其他人提交的分支代码检出到自己本地分支中 ###
``` sh
git cherry-pick...
```
### 合并最近的两次提交 ###
``` sh
git rebase -i HEAD~2
```

### 追加提交 ###
``` sh
git commit --amend
```

### 重置到该次提交 ###
``` sh
git reset --hard 01d8df0e94b8e5ed2fff1388d8bd41c21cc1d4e0
```

### 重置最近三次提交 ###
``` sh
git reset --hard HEAD~3
```

### 本地代码不对文件做版本控制 ###
``` sh
git update-index --assume-unchanged app/webroot/index.php
```

    git checkout HEAD~3 --Gemfile.lock
    git branch -m changes_base_on_feedback feature/117409005_changes_base_on_feedback
    git push origin :category_mobile
    git push origin feature/114939315_category_article_lazy_load_mobile
    git branch -u origin/feature/114939315_category_article_lazy_load_mobile
