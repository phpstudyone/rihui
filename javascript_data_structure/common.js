/**
 * Created by apple on 2017/3/30.
 * 公共的js方法
 */
let commonFun = {
    /**
     * 生成length位 m~n 之间的随机数数组
     * 
     * @param  int m      [description]
     * @param  int n      [description]
     * @param  int length [description]
     * @return array        [description]
     */
    randonm :  ( m , n , length ) => {
        let arr = [];
        let a = m > n ? m : n;
        let b = a == m ? n : m;
        for (let i = 0; i < length ; i++){
            arr[i] = Math.round(Math.random() * (a - b ) + b);
        }
        return arr;
    },
    /**
     * 两个div互换位置
     * @param div1id
     * @param div2id
     */
    swapDiv :  ( div_1_id ,div_2_id ) => {
        let div_1 = $('#'+div_1_id);
        let div_2 = $('#'+div_2_id);
        div_1.children().children().css({'border':'2px solid red'});
        div_2.children().children().css({'border':'2px solid red'});
        let t = document.getElementById(div_1_id).innerHTML;
        document.getElementById(div_1_id).innerHTML=document.getElementById( div_2_id ).innerHTML;
        document.getElementById(div_2_id).innerHTML=t;
        div_1.children().children().css({'border':'none'});
        div_2.children().children().css({'border':'none'});
    },


};

/**
 * 排序类
 * @type {{}}
 */
let sorts = {
    /**
     * 冒泡排序
     * @param data 要排序的数组
     * @param bool true 升序，false 降序
     * @param callback 回调函数
     * @returns {*} array 排序后的数组
     */
    bubbleSort : ( data , bool , callback ) => {
        let length = data.length;
        for (  let i = 0 ; i < length ; i++ ){
            for ( let j = 0 ; j < length - i - 1 ; j++ ){
                let flag = bool ? data[ j ] > data[ j + 1 ] : data[ j ] < data[ j + 1 ] ;
                if ( flag ){
                    let temp = data[ j ];
                    data[ j ] = data [ j + 1 ] ;
                    data [ j + 1] = temp;
                    if( typeof callback === 'function' ){
                        callback( j , j + 1 , 'div' );
                    }
                }
            }
        }
        return data;
    },

    /**
     * 选择排序
     * @param data 要排序的数组
     * @param bool bool true 升序，false 降序
     * @param callback 回调函数
     * @returns {*} array 排序后的数组
     */
    selectionSort : ( data , bool , callback ) => {
        let length = data.length;
        for ( let i = 0 ; i < length ; i++ ){
            for ( let j = i + 1 ; j < length ; j++ ){
                let flag = bool ? data[ i ] > data[ j ] : data[ i ] < data[ j ] ;
                if ( flag ){
                    let temp = data[ i ];
                    data [ i ] = data [ j ];
                    data [ j ] = temp;
                    if( typeof callback === 'function' ){
                        callback( i , j , 'div_' );
                    }
                }
            }
        }
        return data;
    }
};

/**
 * 供排序使用的回调函数
 * @param i
 * @param j
 * @param name
 */
let sortCallback = (i , j , name) => {
    let div_1 = name + '_' + i;
    let div_2 = name + '_' + j;
    commonFun[ 'swapDiv' ]( div_1 , div_2 );
};