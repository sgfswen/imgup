import React, { Component } from 'react';
import Dashboard from './components/dashboard';
import jwt_decode from 'jwt-decode';
import Login from '../accounts/login';
import Signup from '../accounts/signup';

import 'whatwg-fetch'

class Profile extends Component {
    constructor(props) {
        super(props);
        this.state = {
            authenticated: false,
            userName : "",
            userId : 0,
            loginMode: true,
            signupMode: false
        }
    }

    /*
     * Called on render and after a accounts attempt
     * This sets the state to true if a legit jwt is found.
     */
    checkLogin(){
        // Check if there is a jwt value in local storage
        if (localStorage.getItem("jwt")){
            var decoded = jwt_decode(JSON.parse(localStorage.getItem("jwt")).jwt);
            if (decoded){
                console.log(decoded);
                this.setState({
                    authenticated:true,
                    userName : decoded.data.userName,
                    id : decoded.data.userId,
                    loginMode: false,
                    signupMode: false
                });

            }
        }
    }

    switchMode(){
        if (this.state.signupMode){
            this.setState({
                signupMode:false,
                loginMode:true
            });
        } else {
            this.setState({
                signupMode:true,
                loginMode:false
            })
        }
    }

    logout(){
        if (localStorage.getItem("jwt")){
            localStorage.removeItem("jwt");
            this.setState({
                authenticated: false,
                userName : "",
                userId : 0,
                loginMode: true,
                signupMode: false
            });
        }

    }



    /*
     * Called on component load to check if the user is authenticated
     */
    componentDidMount(){
        this.checkLogin();
    }



    render() {
        return (
            <div className="container">
                {this.state.authenticated && <Dashboard
                    logout={this.logout.bind(this)}
                />}
                {!this.state.authenticated && this.state.loginMode && <Login
                    checkLogin={this.checkLogin.bind(this)}
                    switchMode={this.switchMode.bind(this)}
                />}
                {!this.state.authenticated && this.state.signupMode && <Signup
                    checkLogin={this.checkLogin.bind(this)}
                    switchMode={this.switchMode.bind(this)}
                />}

            </div>
        );
    }
}

export default Profile;
