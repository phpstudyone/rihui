import React, { Component } from 'react';
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

  render() {

    return (
      <div className="App">
        <header className="App-header">
          <img src={logo} className="App-logo" alt="logo" />
          <h1 className="App-title">Welcome to React</h1>
        </header>
        <div>
          <input value={this.state.inputValue} onChange={this.handlerInputChange}/>
          <button onClick={this.handlerBtnClick}>add</button>
        </div>
        <ul>
          {
            this.state.list.map(v=>{
              return (<li key={v}>{v}</li>);
            })
          }
        </ul>
      </div>
    );
  }
}

export default App;
