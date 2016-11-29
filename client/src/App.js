import React, { Component } from 'react';
import 'whatwg-fetch'
import MyNavbar from './components/navbar';

import logo from './logo.svg';
import './App.css';



class App extends Component {

    render() {
    return (
        <div>
            <MyNavbar/>
            <main className="container-fluid">
                {this.props.children}
            </main>
        </div>
    );
  }
}

export default App;
