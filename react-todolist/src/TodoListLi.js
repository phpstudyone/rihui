import React, { Component } from 'react';

class TodoListLi extends Component {
    /**
     * 删除li
     */
    handlerLiClick = ()=>{
        //子组件通过函数向父组件传递参数
        this.props.handlerLiClick(this.props.liK);
    }
    render(){
        return (
            <li key={this.props.liK} onClick={this.handlerLiClick} >{this.props.liV}</li>
        );
    }
}

export default TodoListLi;