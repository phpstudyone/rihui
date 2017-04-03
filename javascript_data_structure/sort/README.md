排序算法的动态展示
===
此篇不讲排序算法的实现（实际我也不懂^..^），只是实现动态展示排序算法。
页面加载的时候

1. 生成10位随机数

`let data = commonFun['randonm'](0,50,10);`

其中`randonm`方法生成随机数数组。接受三个参数，第一二个参数确定生成的随机数范围，第三个参数确定返回的数组长度。
2. 初始化条形图

`init_bar_chart(data);`

该方法在页面初始化出一个条形图，参数为上一个函数返回的数组。
3. 实现动态展示排序效果

`sorts['selectionSort'](data,false,sortCallback);`

`selectionSort` 是 排序类`sorts`中的选择排序的实现，目前仅实现了选择排序和冒泡排序`bubbleSort`^.^。这两个方法都接受三个参数，第一个参数为需要排序的数组，第二个参数决定升降序，第三个参数为回调函数。

`sortCallback`是排序方法的一个回调函数，用来实现一些特定的效果：两个`div`互换

##具体效果：

###选择排序降序效果

![选择排序降序](https://raw.githubusercontent.com/phpstudyOne/rihui/master/javascript_data_structure/sort/images/selectSort.gif)

###冒泡排序升序效果

![冒泡排序升序](https://raw.githubusercontent.com/phpstudyOne/rihui/master/javascript_data_structure/sort/images/selectSort.gif)

___

其实一开始是想实现的效果还有交换两个`div`的同时，添加红色边框,交换完成后还原。但是这个效果，太难实现了。。。也放个效果图：

![心中想要的效果](https://raw.githubusercontent.com/phpstudyOne/rihui/master/javascript_data_structure/sort/images/fin.gif)

这个效果是在谷歌浏览器F12的`debug`单步调试下才能看到，究其原因，是`js`中的`for`是同步执行，但是回调函数是异步执行,balabala····

更专业的解释参考
[js 中for循环中延时执行问题](https://segmentfault.com/q/1010000008927977/a-1020000008929065)。

感谢 [cipchk](https://segmentfault.com/u/cipchk) 、[边城](https://segmentfault.com/u/jamesfancy) 两位大神的解惑~