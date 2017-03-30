/**
 * Created by apple on 2017/3/30.
 * 公共的js方法
 */
var commonFun = {
    /**
     * 生成length位 m~n 之间的随机数数组
     * 
     * @param  int m      [description]
     * @param  int n      [description]
     * @param  int length [description]
     * @return array        [description]
     */
    randonm :  (m,n,length) => {
        var arr = [];
        var a = m > n ? m : n;
        var b = a == m ? n : m;
        for (var i = 0; i < length ; i++){
            arr[i] = Math.round(Math.random() * (a - b ) + b);
        }
        return arr;
    },
    swapDiv : (div1.div2) => {

    }
};