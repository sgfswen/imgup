import React, { Component } from 'react';
import Env from '../../utilities/env';

import 'whatwg-fetch'


class Signup extends Component {
    constructor(props) {
        super(props);
        this.state = {
            username: "",
            usernameError: false,
            usernameMessage:"",
            usernameSuccess:"",
            password1: "",
            password2: "",
            passwordMessage: "",
            passwordError: false,
            success: "",
            failure: ""
        }

    }


    /*
     * Called on accounts button click
     */
    register (){
        let form = document.querySelector('form');
        fetch(Env.register, {
            method: 'POST',
            body: new FormData(form),
            mode: 'cors'
        }).then(function(response) {
            return response.json();
        }).then(function(j) {
            console.log(j);
            if (j.status === "success"){
                this.setState({
                    usernameError: false,
                    usernameMessage:"",
                    usernameSuccess:"",
                    password1: "",
                    password2: "",
                    passwordMessage: "",
                    passwordError: false,
                    success: "Congrats "+this.state.username+" Your Account Has Been Created!"
                });
            } else {
                this.setState({
                    failure:"Yikes...Something Went Wrong!"
                })
            }


        }.bind(this));
    }

    checkUsername(){
        if (this.state.username == 0){
            this.setState({
                usernameSuccess: "",
                usernameMessage:"You must enter a username",
                usernameError: true
            })
        } else {
            let form = document.querySelector('form');
            fetch(Env.username, {
                method: 'POST',
                body: new FormData(form),
                mode: 'cors'
            }).then(function(response) {
                return response.json();
            }).then(function(j) {
                console.log(j);
                if (j.status === "success"){
                    this.setState({
                        usernameSuccess:"Welcome Aboard " + this.state.username,
                        usernameMessage:"",
                        usernameError: false
                    });
                } else {
                    this.setState({
                        usernameSuccess: "",
                        usernameMessage:"This username is taken :(",
                        usernameError: true
                    });
                }

            }.bind(this));
        }

    }

    checkPassword(){
        if (this.state.password1 != this.state.password2){
            this.setState({
                passwordMessage: "Passwords Do Not Match",
                passwordError:true
            });
        } else {
            this.setState({
                passwordMessage: "",
                passwordError: false
            });
        }
    }

    /*
     * Called on component load to check if the user is authenticated
     */
    componentDidMount(){
        this.props.checkLogin();
    }



    render() {
        return (
            <div className="container" style={{marginTop:50}}>
                <div className="theme-card card text-xs-center">
                    <div className="card-header">
                        <div className="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups" style={{margin:"auto"}}>
                            <div className="btn-group" role="group" aria-label="First group">
                                <button type="button" className="btn-secondary" onClick={this.props.switchMode}>Login</button>
                                <button type="button" className="btn-primary active">Register</button>
                            </div>
                        </div>
                    </div>
                    <div className="card-block">
                        <h4 className="text-success">{this.state.success}</h4>
                        <h4 className="text-danger">{this.state.failure}</h4>
                        <div className="text-success">{this.state.usernameSuccess}</div>
                        <div className="text-warning">{this.state.usernameMessage}</div>
                        <form>
                            <label for="i1">Username</label>
                            <input id="i1" className="theme-input" name="username" type="text"
                                   value={this.state.username}
                                   onChange={(event) => {this.setState({username:event.target.value})}}
                                   onBlur={this.checkUsername.bind(this)}
                            /><br/>
                            <label for="i2">Password</label>
                            <input id="i2" className="theme-input" name="password" type="password" value={this.state.password1}
                                   onChange={(event) => {
                                       this.setState({password1:event.target.value});
                                   }}
                                   onBlur={(event) => {
                                       this.setState({password1:event.target.value});
                                       this.checkPassword();
                                   }}
                            /><br/>
                            <label for="i3">Password</label>
                            <input id="i3" className="theme-input" name="password" type="password"
                                   onChange={(event) => {
                                       this.setState({password2:event.target.value});
                                       }}
                                   onBlur={(event) => {
                                       this.setState({password2:event.target.value});
                                       this.checkPassword();
                                   }}
                            />
                            <div className="text-warning">{this.state.passwordMessage}</div>
                        </form>
                        <button className="theme-button"
                          onClick={this.register.bind(this)}>Welcome</button>
                    </div>
                </div>
            </div>
        );
    }
}

export default Signup;


