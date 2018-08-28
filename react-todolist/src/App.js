import React, { Component } from 'react';
import TodoListLi from './TodoListLi';
import logo from './logo.svg';
import './App.css';

class App extends Component {

  /**
   * 构造函数
   * @param {*} props 
   */
  constructor(props){
    super(props);
    this.state = {
      list:[
        '冒泡','快速','哈希'
      ],
      inputValue:''
    }
  }

  handlerBtnClick = ()=>{
    this.setState({
      list:[...this.state.list,this.state.inputValue],
      inputValue:''
    })
  }

  handlerInputChange = (e)=>{
    this.setState({
      inputValue: e.target.value
    })
  }

  handlerLiClick = (k)=>{
    let list = [...this.state.list];
    list.splice(k,1);
    this.setState({list});
  }

  getTodoList = () =>{
    return (
      this.state.list.map((v,k)=>{
        //父组件通过属性向子组件传递参数、函数
        return <TodoListLi handlerLiClick={this.handlerLiClick}  key={k} liK={k} liV={v}/>
    }));
  }


  render() {

    return (
      <div className="App">
        <header className="App-header">
          <img src={logo} className="App-logo" alt="logo" />
          <h1 className="App-title">Welcome to React</h1>
        </header>
        <div>
          <input value={this.state.inputValue} onChange={this.handlerInputChange}/>
          <button className='' style={{background:'red',color:'#FFF'}} onClick={this.handlerBtnClick}>add</button>
        </div>
        <ul>{this.getTodoList()}</ul>
      </div>
    );
  }
}

export default App;
