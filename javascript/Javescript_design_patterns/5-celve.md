# 第五章 策略模式

## 5.1 使用策略模式计算奖金

很多公司的年终奖是根据员工的工资基数和年底绩效的情况来发放的。例如，绩效为S的人年终奖有4倍工资，绩效为A的人年终奖有3倍工资，而绩效为B的人年终奖是2倍工资。假设财务部要求我们提供一段代码，来方便计算员工的年终奖。

### 1.最初的代码

``` javascript
var calculateBonus = function ( performancelevel , salary) {
    if ( performancelevel === 'S' ){
        return salary * 4;
    }

    if( performancelevel === 'A' ){
        return salary * 3;
    }

    if(performancelevel === 'B' ){
        return salary * 2;
    }
};

calculateBonus( 'B' , 20000 );           //输出40000
calculateBonus( 'S' , 6000 );            //输出24000
```

这段代码比较简单，但是存在着缺点

- `calculateBonus` 函数比较庞大，包含了很多 `if-else` 语句，这些语句需要覆盖所有的逻辑分之
- `calculateBonus` 函数缺乏弹性，如果增加一种新的绩效等级C，或者想把绩效S的奖金系数改为5，那么必须深入`calculateBonus` 函数的内部实现，违背了开闭原则。
- 算法的复用性差，如果在程序的其他地方需要重用这些计算奖金的算法，我们只能复制粘贴代码~

### 2.使用组合函数重构代码

``` javascript
var performanceS = function ( salary ) {
    return salary * 4;
};

var performanceA = function ( salary ) {
    return salary * 3;
};

var performanceB = function ( salary ) {
    return salary * 2;
};

var calculateBonus = function ( performanceLeverl , salary ) {

    if(performanceLeverl === 'S' ){
        return performanceS(salary);
    }

    if(performanceLeverl === 'A' ){
        return performanceA(salary);
    }

    if(performanceLeverl === 'B' ){
        return performanceB(salary);
    }
};

calculateBonus( 'A' , 10000);           //输出30000
```

这个代码得到了一定的改善，但是非常有限，依然没有解决最重要的问题 ：calculateBonus　函数有可能越来越庞大，而且在系统变化的时候缺乏弹性

### 3.使用策略模式重构代码

#### 模拟传统面向对象语言（静态语言）

定义绩效的计算规则的策略类

``` javascript
var performanceS = function () {};

performanceS.prototype.calculate = function ( salary ) {
    return salary * 4;
};

var performanceA = function () {};

performanceA.prototype.calculate = function ( salary ) {
    return salary * 3;
};

var performanceB = function () {};

performanceB.prototype.calculate = function ( salary ) {
    return salary * 2;
};
```

定义奖金类 `Bonus`

``` javascript
var Bonus = function () {
    this.salary = null;                 //原始工资
    this.strategy = null;               //绩效等级对应的策略对象
};

Bonus.prototype.setSalary = function ( salary ) {
    this.salary = salary;               //设置员工的原始工资
};

Bonus.prototype.setStrategy = function ( strategy ) {
    this.strategy = strategy;           //设置员工绩效等级对应的策略对象
};

/**
 * 取得奖金数额
 */
Bonus.prototype.getBouns = function () {
    return this.strategy.calculate( this.salary );          //把计算奖金的操作委托为对应的策略对象
```

创建`bonus`对象，给`bonus`对象设置一些原始数据，比如员工的原始工资数额。接下来把某个计算奖金的策略对象也传入`bonus`对象内部保存起来。当调用 `bonus.getBonus()` 来计算奖金的时候，`bonus` 对象本身并没有能力进行计算，而是把请求委托给了之前保存好的策略对象。

``` javascript
var bonus = new Bonus();

bonus.setSalary( 10000 );
bonus.setStrategy( new performanceS() );            //设置策略对象

console.log( bonus.getBouns() );                    //输出40000

bonus.setStrategy( new performanceA() );
console.log( bonus.getBouns() );                    //输出30000
```

#### javaScript 版本的策略模式

在上面，我们让 `strategy` 对象从各个策略类中创建而来，这是模拟一些传统面向对象语言的实现。实际上在 `javascript` 语言中，函数也是对象，所以更简单和直接的做法是把 `strategy` 直接定义为函数：

``` js
var strategies = {
    'S' : function ( salary ) {
        return salary * 4;
    },
    'A' : function ( salary ) {
        return salary * 3;
    },
    'B' : function ( salary ) {
        return salary * 2;
    }
};

var calculateBonus = function ( level , salary ) {
    return strategies[ level ]( salary );
};

console.log( calculateBonus( 'S' , 20000 ) );           //输出80000
console.log( calculateBonus( 'A' , 10000 ) );           //输出30000
```

## 5.2 表单校验

假设我们正在编写一个注册的页面，在点击注册按钮之前，有如下几条校验逻辑。

- 用户名不能为空
- 密码长度不能少于6位
- 手机号码必须符合格式

### 表单校验的第一个版本

``` html
<html>
<body>
    <form action="http://www.bai.com" id="registerForm" method="post">
        请输入用户名：<input type="text" name="userName" />
        请输入密码：<input type="text" name="password" />
        请输入手机号：<input type="text" name="phoneNumber" />
        <input type="button" value="提交" />
    </form>
<script>
    var registerForm = document.getElementById( 'registerForm' );
    registerForm.onsubmit = function () {
        if ( registerForm.userName.value === '' ){
            alert( '用户名不能为空' );
            return false;
        }

        if ( registerForm.password.value.length < 6 ){
            alert( '密码长度不能少于6位' );
            return false;
        }

        if ( !/(^1[3|5|8][0-9]{9}$)/.test( registerForm.phoneNumber.value ) ){
            alert( '手机号码格式不正确' );
            return false;
        }
    }
</script>
</body>
</html>
```

这是最常见的一种编写方式，它的缺点和计算奖金的最初版本一模一样。

- `registerForm.onsubmit` 函数比较庞大，包含了很多 `if-else` 语句，这些语句需要覆盖所有的校验规则。
- `registerForm.onsubmit` 函数缺乏弹性，如果增加了一种新的校验规则，或者想把密码的长度校验从 6 改为 8 ，我们都必须深入 `registerForm.onsubmit` 函数的内部实现，这是违反开闭原则的
- 算法的复用性差，如果在程序中增加了另外一个表单，这个表单也需要进行一些类似的校验，那我们很可能将这些校验逻辑复制的漫山遍野

### 用策略模式重构表单校验

将检验逻辑都封装成策略对象

``` js
    var strategies = {
        isNonEmpty: function ( value , errorMsg ) {                   //不为空
            if( value === '' ){
                return errorMsg;
            }
        },
        minLength: function ( value , length , errorMsg) {          //限制最小长度
            if( value.length < length ){
                return errorMsg;
            }
        },
        isMobile: function ( value , errorMsg ) {
            if ( !/(^1[3|5|8][0-9]{9}$)/.test( value ) ){
                return errorMsg;
            }
        }
    };

    var Validator = function () {
        this.cache = [];                    //保存校验规则
    };

    Validator.prototype.add = function ( dom , rule , errorMsg ) {
        var ary = rule.split( ':' );                //把strateg和参数分开
        this.cache.push( function () {              //把校验的步骤用空函数包装起来，并且放入cache
            var strategy = ary.shift();             //用户挑选的strategy
            ary.unshift( dom.value );               //把input的value添加进参数列表
            ary.push(errorMsg);                     //把errorMsg添加进参数列表
            return strategies[ strategy ].apply( dom , ary );
        });
    };

    Validator.prototype.start = function () {
        for ( var i = 0 , validatorFunc ; validatorFunc = this.cache[ i++] ; ){
            var msg = validatorFunc();              //开始校验，并取得检验后的返回信息
            if ( msg ){                             //如果有确切的返回值，说明校验没有通过
                return msg;
            }
        }
    };

    var validatorFunc = function () {
        var validator = new Validator();            //创建一个 validator 对象

        /******************添加一些校验规则********************/
        validator.add( registerForm.userName , 'isNonEmpty' , '用户名不能为空');
        validator.add( registerForm.password , 'minLength:6' , '密码长度不能少于6位');
        validator.add( registerForm.phoneNumber , 'isMobile' , '手机号码格式不正确');

        var errorMsg = validator.start();           //获取校验结果
        return errorMsg;
    };

    var registerForm = document.getElementById( 'registerForm' );
    registerForm.onsubmit = function () {
        var errorMsg = validatorFunc();             //如果errorMsg有确切的返回值，说明未通过校验
        if (errorMsg ){
            alert(errorMsg);
            return false;                           //阻止表单提交
        }
    };
```

此时，我们仅仅通过“配置”的方式就可以完成一个表单校验，这些校验规则也可以复用到程序的任何地方，还能作为插件的形式，方便的被移植到其他项目

在修改某个校验规则的时候，只需要编写或者改写少量的代码。比如我们想将用户名的检验规则改为不能少于10个字符。只需要将

``` js
validator.add( registerForm.userName , 'isNonEmpty' , '用户名不能为空');
```

改为：

``` js
validator.add( registerForm.userName , 'minLength:10' , '密码长度不能少于10位');
```

### 给某个文本输入框添加多种校验规则

上面的代码只能一个文本框对应一种校验规则，比如，用户名输入框只能校验输入是否为空：

``` js
validator.add( registerForm.userName , 'isNonEmpty' , '用户名不能为空');
```

如果我们既想校验他不能为空，又想校验它输入的文本长度不小于10呢？以下是代码实现

``` js
    /*************************************策略对象***************************************/
    var strategies = {
        isNonEmpty: function ( value , errorMsg ) {                   //不为空
            if( value === '' ){
                return errorMsg;
            }
        },
        minLength: function ( value , length , errorMsg) {          //限制最小长度
            if( value.length < length ){
                return errorMsg;
            }
        },
        isMobile: function ( value , errorMsg ) {
            if ( !/(^1[3|5|8][0-9]{9}$)/.test( value ) ){
                return errorMsg;
            }
        }
    };

    /*************************************Validator 类***************************************/
    var Validator = function () {
        this.cache = [];                    //保存校验规则
    };

    Validator.prototype.add = function ( dom , rules ) {
        var self = this;

        for ( var i= 0 , rule ; rule = rules [ i ++  ] ; ){
            ( function ( rule ) {
                var strategyAry = rule.strategy.split( ':' );
                var errorMsg = rule.errorMsg;
                self.cache.push(function () {
                    var strategy = strategyAry.shift();
                    strategyAry.unshift( dom.value );
                    strategyAry.push( errorMsg );
                    return strategies[ strategy ].apply( dom , strategyAry );
                });
            })( rule );
        }
    };



    Validator.prototype.start = function () {
        for ( var i = 0 , validatorFunc ; validatorFunc = this.cache[ i++] ; ){
            var msg = validatorFunc();              //开始校验，并取得检验后的返回信息
            if ( msg ){                             //如果有确切的返回值，说明校验没有通过
                return msg;
            }
        }
    };

    /*************************************客户调用代码***************************************/

    var registerForm = document.getElementById( 'registerForm' );

    var validatorFunc = function () {
        var validator = new Validator();            //创建一个 validator 对象
        validator.add( registerForm.userName , [{
            strategy : 'isNonEmpty',
            errorMsg : '用户名不能为空'
        },{
            strategy : 'minLength:10',
            errorMsg : '用户名长度不能少于10位'
        }]);

        validator.add( registerForm.password , [{
            strategy : 'minLength:6',
            errorMsg : '密码长度不能少于6位'
        }]);

        validator.add( registerForm.password , [{
            strategy : 'isMobile',
            errorMsg : '手机号码格式不正确'
        }]);

        var errorMsg = validator.start();           //获取校验结果
        return errorMsg;
    };


    registerForm.onsubmit = function () {
        var errorMsg = validatorFunc();             //如果errorMsg有确切的返回值，说明未通过校验
        if (errorMsg ){
            alert(errorMsg);
            return false;                           //阻止表单提交
        }
    };
```