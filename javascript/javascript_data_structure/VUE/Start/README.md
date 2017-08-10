# VUE渲染列表页面

===
VUE的官网有这么一段话:

    所有的元素都是响应式的。
如何理解这句话呢？看下面代码的效果

```html
<div id="app-6">
  <p>{{ message }}</p>
  <input v-model="message">
</div>
```

```javascript
var app6 = new Vue({
  el: '#app-6',
  data: {
    message: 'Hello Vue!'
  }
})
```

![1.gif](https://raw.githubusercontent.com/phpstudyOne/rihui/master/javascript/javascript_data_structure/VUE/Start/images/1.gif)

很牛逼的一个功能，vue渲染的页面的是 `数据驱动` ，修改VUE对象的data数据，那么页面会跟着改变。

基于这个特性，那么做一个列表页面就非常简单了。

html代码：

```html
<div id="data">
    <table class="table table-striped table-hover">
        <tr v-for="todo in datas">
            <td>{{todo.title}}</td>
            <td>{{todo.learn_name}}</td>
            <td>{{todo.is_exist}}</td>
            <td>{{todo.is_download}}</td>
        </tr>
    </table>
    <button  v-bind:class="[{ 'btn btn-success': list.is_show ,'btn btn-info': !list.is_show }]" v-for="list in lists" v-on:click="clickEvent(list.no)">{{list.no}}</button>
</div>
```

js代码：

```js
    var cache = {};
    var url = '<?php echo Yii::$app->urlManager->createUrl("/collect-data-copy/vue")?>';
    var ajaxGetData = function (page) {
        if(page in cache){
            data.datas = cache[page].data;
            data.lists = cache[page].list;
        }else{
            Vue.http.post(url, {page:page,'<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>'},
                {'emulateJSON':true}).then(function (res) {
                data.datas = res.body.data;
                data.lists = res.body.list;
                cache[page] = res.body;
            });
        }
    };
    var data = new Vue({
        el:'#data',
        data:{
            datas:{},
            lists:{}
        },
        created:function(){
            ajaxGetData(45);
        },
        methods:{
            clickEvent:function (page) {
                ajaxGetData(page);
            }
        }
    });
```

实现的效果：
![gif.gif](https://raw.githubusercontent.com/phpstudyOne/rihui/master/javascript/javascript_data_structure/VUE/Start/images/GIF.gif)

可以看到，不到50行的代码就实现了这些效果。
如果使用js/jQuery来实现这些效果要怎么做：

* Ajax请求json数据，遍历数据操作dom。
* Ajax请求后台处理好的分页页面数据，直接把页面返回，把页面插入到table所在的div。
* Pjaxq请求分页页面替换原dom。

其中第一种方式对dom的操作最繁杂，后两种方式又会对后台操作做额外的处理。