import React, { Component } from 'react';
import Env from '../../utilities/env';
import CheckLogin from '../../utilities/checkLogin';

import 'whatwg-fetch'


class Login extends Component {
    constructor(props) {
        super(props);
        this.state = {
            authenticated: false,
            user: {},
            username: ""
        };
        this.checkLogin = this.checkLogin.bind(this);
    }

    checkLogin(){
        let user = CheckLogin();
        if (user){
            this.setState({authenticated:true});
            console.log("Authenticated");
        } else {
            this.setState({authenticated:false});
        }

    }

    /*
     * Called on accounts button click
     */
    login (){
        let form = document.querySelector('form');
        fetch(Env.login, {
            method: 'POST',
            body: new FormData(form),
            mode: 'cors'
        }).then(function(response) {
            return response.json();
        }).then(function(j) {
            console.log(j);
            localStorage.setItem("jwt",JSON.stringify(j));
            this.props.checkLogin()
        }.bind(this));
    }

    /*
     * Called on component load to check if the user is authenticated
     */
    componentDidMount(){
        this.checkLogin();
    }

    render() {
        return (
                <div className="container" style={{marginTop:50}}>
                    <div className="theme-card card text-xs-center">
                        <div className="card-header">
                            <div className="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups" style={{margin:"auto"}}>
                                <div className="btn-group" role="group" aria-label="First group">
                                    <button type="button" className="btn-primary active">Login</button>
                                    <button type="button" className="btn-secondary" onClick={this.props.switchMode}>Register</button>
                                </div>
                            </div>
                        </div>
                        <div className="card-block">
                            <div className="card-title">Welcome&nbsp;{this.state.username}</div>
                            <form>
                                <label for="i1">Username</label>
                                <input id="i1" className="theme-input" name="username" type="text"
                                       value={this.state.username} onChange={(event) => {this.setState({username:event.target.value})}}
                                /><br/>
                                <label for="i2">Password</label>
                                <input id="i2" className="theme-input" name="password" type="password" />
                            </form>
                            <button className="theme-button" onClick={() => {
                                this.login();
                            }}>Login</button>
                        </div>
                    </div>
                </div>
        );
    }
}

export default Login;

