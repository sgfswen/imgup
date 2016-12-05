import React, { Component } from 'react';
import CheckLogin from '../../utilities/checkLogin';
import API_POST from '../../utilities/api';
import Env from '../../utilities/env';


class Viewer extends Component {
    constructor(props) {
        super(props);
        this.state = {
            authenticated: false,
            user: {},
            up: 0,
            down: 0,
            views: 0,
            voted: false
        }
    }


    componentDidMount(){
        this.view(); // increment the view count
        let user = CheckLogin();
        if (user){
            this.setState({
                authenticated:true,
                user: user,
                up: parseInt(this.props.img.up),
                down: parseInt(this.props.img.down),
                views: parseInt(this.props.img.views) + 1,
                voted: false
            })
        }
    }





    upvote(){
        // If the user has not voted before
        if (!this.state.voted){
            // Check that the user is logged in, then proceed
            let user = CheckLogin();
            if (user){
                this.setState({
                    up: this.state.up + 1,
                    voted: true
                });
                let form = document.querySelector('form');
                let token = JSON.parse(localStorage.getItem("jwt")).jwt;
                let response = API_POST(form, token, Env.upvote);
                console.log(response);
            }
        }
    }

    downvote(){
        // If the user has not voted before
        if (!this.state.voted){
            // Check that the user is logged in, then proceed
            let user = CheckLogin();
            if (user){
                this.setState({
                    down: this.state.down + 1,
                    voted: true
                });
                let form = document.querySelector('form');
                let token = JSON.parse(localStorage.getItem("jwt")).jwt;
                let response = API_POST(form, token, Env.downvote);
                console.log(response);
            }
        }
    }


    view(){
        let form = document.querySelector('form');
        fetch(Env.view, {
            method: 'POST',
            body: new FormData(form),
        }).then(function(response) {
            return response;
        }).then(function(response) {
            console.log(response);
            return response;
        })
    }

    render() {
        return (
                <div className="theme-card card text-xs-center">
                    <div className="card-header">
                        <span className="card-title">{this.props.img.title}
                            <i onClick={this.props.back} className="material-icons float-xs-right">close</i>
                        </span>
                    </div>
                    <div className="card-block">
                        <img className="card-img img-fluid" src={this.props.img.source} style={{maxHeight:"40%"}}/>
                    </div>
                    <div className="card-footer">
                        <span>
                            <button onClick={this.downvote.bind(this)} className="theme-button-down">
                                {this.state.down} &nbsp;&nbsp;<i className="material-icons">thumb_down</i>
                            </button>
                        </span>
                        <span>
                            <button onClick={this.upvote.bind(this)} className="theme-button-up">
                                <i className="material-icons">thumb_up</i>&nbsp;&nbsp; {this.state.up}
                            </button>

                        </span>
                        <span className="float-xs-right">
                            <button disabled="true" className="theme-surface">
                               <strong>Views: {this.props.img.views}</strong>
                            </button>
                        </span>
                    </div>
                    <form style={{display:"none"}}>
                        <input name="photoid" value={this.props.img.id}/>
                    </form>
                </div>


        );
    }
}

export default Viewer;
