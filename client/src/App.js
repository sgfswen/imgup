import React, { Component } from 'react';
import 'whatwg-fetch'
import MyNavbar from './components/navbar';




class App extends Component {

    render() {
    return (
        <div>
            <MyNavbar/>
            <div className="container-fluid">
                {this.props.children}
            </div>
        </div>
    );
  }
}

export default App;
