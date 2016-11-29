import React, { Component } from 'react';
import Dashboard from './components/dashboard';
import 'whatwg-fetch'




class Home extends Component {
    constructor(props) {
        super(props);
        this.state = {
            authenticated: false
        }
    }


    checkLogin(){
        // Check if there is a jwt value in local storage
        if (localStorage.getItem("jwt")){
            console.log(localStorage.getItem("jwt"));
        }

    }


    login (){
        var form = document.querySelector('form');
        fetch('http://127.0.0.1:80/login.php', {
            method: 'POST',
            body: new FormData(form),
            mode: 'cors'
        }).then(function(response) {
            return response.json();
        }).then(function(j) {
            localStorage.setItem("jwt",JSON.stringify(j));
            this.checkLogin();
        });
    }

    render() {
        return (
        <div>
            <div className="jumbotron jumbotron-fluid text-xs-center">
                <div className="container">
                    <h1 className="display-3">Imgup</h1>
                    <p className="lead">This simply beautiful image host</p>
                </div>
            </div>
            <div className="container">
                <form><input name="username" value="runequant"/><input name="password" value="Walker1a"/></form>
                <button onClick={this.login}>Test</button>
            </div>
            {this.state.authenticated && <Dashboard/>}
            </div>
        );
    }
}

export default Home;
