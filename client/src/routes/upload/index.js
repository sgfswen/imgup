import React, { Component } from 'react';
import jwt_decode from 'jwt-decode';
import Env from '../../utilities/env';

import 'whatwg-fetch'

class Upload extends Component {
    constructor(props) {
        super(props);
        this.state = {
            authenticated: false,
            userName : "",
            userId : 0,
            status:""
        }
    }

    /*
     * Called on render and after a accounts attempt
     * This sets the state to true if a legit jwt is found.
     */
    checkLogin(){
        // Check if there is a jwt value in local storage
        if (localStorage.getItem("jwt")){
            let decoded = jwt_decode(JSON.parse(localStorage.getItem("jwt")).jwt);
            if (decoded){
                console.log(decoded);
                this.setState({
                    authenticated:true,
                    userName : decoded.data.userName,
                    id : decoded.data.userId
                });

            }
        }
    }

    uploadPhoto(){
        let form = document.querySelector('form');
        let token = JSON.parse(localStorage.getItem("jwt")).jwt;
        fetch(Env.upload, {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token
            },
            body: new FormData(form),
        }).then(function(response) {
            return response.json();
        }).then(function(j){
            if (j.status === "success"){
                this.setState({status:"Success, Your Awesome Photo was Uploaded!"})
            }
            console.log(j);

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
            <div>
                <div className="container text-xs-center" style={{marginTop:20}}>
                    <div className="theme-card card">
                        <div className="card-header">Upload an Image</div>
                        <div className="card-block">
                            <h4 className="text-success">{this.state.status}</h4>
                            <form>
                                <div id="upload1" className="form-group">
                                    <label for="title">Title</label><br/>
                                    <input name="title" type="type" className="form-control" id="title" placeholder="Enter your image title" style={{width:"90%", marginBottom:5}}/>
                                </div>
                                <div id="upload2" className="form-group" style={{marginTop:20}}>
                                    <label for="fileId">Image Input</label><br/>
                                    <input type="file" className="form-control-file" id="fileId" name="file" style={{marginBottom:5}}/>
                                </div>
                            </form>
                        </div>
                        <div className="card-block">
                            <button onClick={this.uploadPhoto.bind(this)} className="btn btn-lg theme-button">
                                <i className="material-icons">cloud_upload</i>&nbsp;Upload
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default Upload;
