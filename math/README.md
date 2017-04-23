矩阵的逆及其应用
===

我们知道，一个数的倒数，乘以它本身，结果为 `1` 。 那么，矩阵有没有一个对应的“倒矩阵”，乘以本身等于1呢？

肯定是有的啦，这个“倒矩阵”，我们称之为 ==矩阵的逆==。

设矩阵 `A` , 那么可以使用 `$A^{-1}$` 来表示矩阵 `A` 的逆。

问题来了，既然是和倒数的性质类似，那为什么不能写成 `$\tfrac{1}{A}$` ？

其实原因很简单，主要是因为矩阵不能被除。不过 `$\tfrac{1}{8}$` 倒可以被写成 `$8^{-1}$` 。
那矩阵的逆和倒数还有其他相似之处吗？

当我们将一个数乘以它的倒数我们得到 `1` 。

```math
8 \times \tfrac{1}{8} = 1
```

当一个 `矩阵` 乘以该 `矩阵的逆` 时,我们得到了==单位矩阵==(而 `单位矩阵` ，其实也就是矩阵中的 `1` )。

```math
A \times A^{-1} = 1
```

而此时我们将 `矩阵的逆` 放在前面，很明显，结果还是一样的。

```math
\tfrac{1}{8} \times 8 = 1

A^{-1} \times A = 1
```

wait，刚刚讲的 `单位矩阵` 是什么东东？

关于单位矩阵，其实就是一个相当于数字 `1` 的矩阵：
```math
I = 
\left|
\begin{array}{lcr} 
1 & 0 & 0\\
0 & 1 & 0\\
0 & 0 & 1
\end{array}\right|
```

`3x3` 的单位矩阵,那怎样的矩阵才是单位矩阵呢？
1. 它是 `正方形`（行数与列数相同）；
2. 它的对角线上的数字都是 `1` ，其他地方都是 `0` 。

那问题又来了，我们该如何去计算 `矩阵的逆` 呢？

以 `二阶矩阵` 来说明：

```math
{\left|
\begin{array}{lcr} 
a & b \\
c & d
\end{array}\right|}^{-1} 
= 
\tfrac{1}{ad-bc}
{\left|
\begin{array}{lcr} 
d & -b \\
-c & a
\end{array}\right|} 
```
文字公式：
## 交换a和d的位置，将b和c置负，并将所有数除以行列式(ad-bc)

举个栗子：
```math
{\left|
\begin{array}{lcr} 
4 & 7 \\
2 & 6
\end{array}\right|}^{-1} 
= 
\tfrac{1}{4\times6-7\times2}
{\left|
\begin{array}{lcr} 
6 & -7 \\
-2 & 4
\end{array}\right|} 
=\tfrac{1}{10}
{\left|
\begin{array}{lcr} 
6 & -7 \\
-2 & 4
\end{array}\right|} 
={\left|
\begin{array}{lcr} 
0.6 & -0.7 \\
-0.2 & 0.4
\end{array}\right|} 
```

不过该如何去判断这是正确的答案呢？

那这个时候就要用到我们最开始讲的公式：
`$A \times A^{-1} = 1$`

所以，让我们检查一下，当我们将 `矩阵` 乘以 `矩阵的逆` 时，会是怎样的？

```math
{\left|
\begin{array}{lcr} 
4 & 7 \\
2 & 6
\end{array}\right|}
{\left|
\begin{array}{lcr} 
0.6 & -0.7 \\
-0.2 & 0.4
\end{array}\right|}

=
{\left|
\begin{array}{lcr} 
4\times0.6 + 7\times-0.2 & 4\times-0.7 + 7\times0.4 \\
2\times0.6 + 6\times-0.2 & 2\times-0.7 + 6\times0.4
\end{array}\right|} 

=
{\left|
\begin{array}{lcr} 
2.4 - 1.4 & -2.8 + 2.8 \\
1.2 - 1.2 & -1.4 + 2.4
\end{array}\right|} 
={\left|
\begin{array}{lcr} 
1 & 0 \\
0 & 1
\end{array}\right|} 
```

嘿嘿嘿嘿！我们最终得到了 `单位矩阵` ！

留个作业：试试这样，能不能得到 `单位矩阵` 呢？
```math
{\left|
\begin{array}{lcr} 
0.6 & -0.7 \\
-0.2 & 0.4
\end{array}\right|}
{\left|
\begin{array}{lcr} 
4 & 7 \\
2 & 6
\end{array}\right|}
={\left|
\begin{array}{lcr} 
 &  \\
 & 
\end{array}\right|}
```

讲完什么是`矩阵的逆`和`矩阵的逆`的计算公式,会不会有个疑问：为什么我们需要`矩阵的逆`？

其主要原因是：**矩阵没办法被除**。（这个各位可以回想一下：是不是从来都没看过`矩阵`被除）。
换句话说，`矩阵` 根本就没有被除的概念。

而 `矩阵的逆`，正好是被我们用来解决`矩阵除法`的问题。

假如我们没有`除法`这个规则，那当有人问你:如何把10分苹果平分给两个人。

想到怎么解答没？

那我们是不是可以采取`2`的倒数（`$\tfrac{1}{2} = 0.5$`）来计算，那答案就很清晰啦：
也就是每个人 `$0.5 \times 10 = 5$` 个苹果。

那我们是不是也可以将同样的方法应用到矩阵上呢？

那故事就这么开始了，

---
假设 **矩阵A** 和 **矩阵B** ，**矩阵x** ,满足：`$xA = B$` 。求 **矩阵X** 。

---

### 最好的办法是等式两边处以 `A`，得到 `$x = \tfrac{B}{A}$`  , BUT ... 矩阵是没有除法的，我们不能直接除以 `矩阵A`

但是我们却可以在等式两边都乘以 `矩阵A的逆`:

```math
xAA^{-1} = BA^{-1}
```
因为我们都知道`$AA^{-1} = 1$`，所以也就能得到
```math
x = BA^{-1}
```
所以呢，此时我们只要知道怎么计算 `$A^{-1}$` ，那就可以直接算出 `矩阵X` （而对于计算 `$A^{-1}$` 早已解决）。

再举个栗子：
```
有一个几个家庭组团出去旅行，出发的时候是乘坐大巴，每位儿童3元，每个大人3.2元，一共花费了118.4元。
在回程时，他们选择乘坐火车，每名儿童3.5元，每名成人3.6元，总计135.20元。
```
那问题叒来了，这里边有多少个小孩和大人呢？

虽然这道题用线性方程组来解很简单，但这次我们尝试用矩阵思维来解答。

首先，我们设置好矩阵（此时要注意好矩阵的行和列是否正确）。

人物矩阵`$x$` (其中`$x_1$`表示儿童，`$x_2$`表示大人): 

```math
x = {\left|
\begin{array}{lcr} 
x_1 & x_2 
\end{array}\right|}
```
价格矩阵 A (其中第一列表示大巴的价格，第二列表示火车的价格。第一行表示儿童的价格，第二行表示成人的价格)（行列式 行列式，相信现在对什么是行列式有个更明确的表示了吧）:

```math
A = {\left|
\begin{array}{lcr} 
3 & 3.5 \\
3.2 & 3.6 
\end{array}\right|}
```
总价矩阵B：
```math
B = {\left|
\begin{array}{lcr} 
118.4 & 135.2
\end{array}\right|}
```
他们满足：
```math
xA = B
```
即：
```math
{\left|
\begin{array}{lcr} 
x_1 & x_2 
\end{array}\right|}
{\left|
\begin{array}{lcr} 
3 & 3.5 \\
3.2 & 3.6 
\end{array}\right|}={\left|
\begin{array}{lcr} 
118.4 & 135.2
\end{array}\right|}
```
根据公式
```math
x = BA^{-1}
```
首先得求出`矩阵A的逆`
```math
A^{-1}=
{\left|
\begin{array}{lcr} 
3 & 3.5 \\
3.2 & 3.6 
\end{array}\right|}{^-1}=
\tfrac{1}{3\times3.6-3.5\times3.2}
{\left|
\begin{array}{lcr} 
3.6 & -3.5 \\
-3.2 & 3
\end{array}\right|} 
={\left|
\begin{array}{lcr} 
-9 & 8.75 \\
8 & -7.5
\end{array}\right|} 
```
那么有:
```math
x={\left|
\begin{array}{lcr} 
x_1 & x_2 
\end{array}\right|}
={\left|
\begin{array}{lcr} 
118.4 & 135.2
\end{array}\right|}
{\left|
\begin{array}{lcr} 
-9 & 8.75 \\
8 & -7.5
\end{array}\right|} 

={\left|
\begin{array}{lcr} 
118.4\times-9 + 135.2\times8 & 118.4\times8.75 + 165.2\times-7.5
\end{array}\right|} 

={\left|
\begin{array}{lcr} 
16 & 22
\end{array}\right|}
```
结果很明显，一共有16个孩子和22个大人！

---

BUT ....难道矩阵的存在就是为了解决这种初中数学题么？

当然不是！

我们来看看这题，如果用线性方程组（一元二次方程组）如何做。

设儿童为`$x_1$`人，大人`$x_2$` , 依题有：
```math
3x_1 + 3.2x_2 = 118.4

3.5x_1 + 3.6x_2 = 135.2
```

看起来很好计算，那么如果我们用代码呢？

```php
for($i = 1 ; $i <= 118.4/3 ; $i++){
    for($j = 1 ; $j <= 118.4/3.2 ;$j++ ){
        if( ($i * 3 + $j * 3.2) == 118.4 && ($i * 3.5 + $j * 3.6 ) == 135.2 ){
            dump('儿童：' . $i . ' 人' , '成人：' . $j . ' 人');
        }
    }
}
```
![php_1](https://raw.githubusercontent.com/phpstudyOne/rihui/master/math/images/php_1.png)

可以看到，假设矩阵的阶为N，那么该方式的时间复杂度为`$O(N^2)$`
如果使用行列式来计算，公式是固定的，每次可以直接计算出结果，时间复杂度为`$O(1)$`