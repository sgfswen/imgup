import React, { Component } from 'react';
import 'whatwg-fetch'
import {Link} from 'react-router';
import jwt_decode from 'jwt-decode';
import EditMode from './editmode';
import Album from './album';

import API_POST from '../../../utilities/api';
import Env from '../../../utilities/env';


class Dashboard extends Component {
    constructor(props) {
        super(props);
        this.state = {
            authenticated: false,
            userName : "",
            userId : 0,
            tagline: "Tag Line",
            bio: "Bio",
            location:"Location",
            age: 0,
            edit: false,
            editText:"Edit Profile",
            album: false,
            albumText: "Show Uploads",
            uploads: []
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
                    userId : decoded.data.userId,
                    isAdmin: parseInt(decoded.data.admin),
                });

            }
        }
    }


    /*
     * Called on component load to check if the user is authenticated
     */
    componentDidMount(){
        this.checkLogin();
        this.getProfile();
        this.getAlbum();
    }

    editMode(){
        // If in edit mode, save changes, then exit
        if (this.state.edit){
            this.setState({
                edit:!this.state.edit,
                editText:"Edit Profile"
            });
            this.saveChanges();
        } else {
            this.setState({
                edit:!this.state.edit,
                editText:"Save Changes"
            });
        }
    }

    updateTagline(event){
        this.setState({
            tagline: event.target.value
        })
    }

    updateBio(event){
        this.setState({
            bio: event.target.value
        })
    }

    saveChanges(){
        this.setState({
            edit:false
        });
        let form = document.querySelector('form');
        let token = JSON.parse(localStorage.getItem("jwt")).jwt;
        API_POST(form,token,Env.profile);
    }

    albumMode(){
        // If in edit mode, save changes, then exit
        if (this.state.album){
            this.setState({
                album:!this.state.album,
                albumText:"Show Uploads"
            });
        } else {
            this.setState({
                album:!this.state.album,
                albumText:"Hide Uploads"
            });
        }

    }

    getProfile() {
        let token = JSON.parse(localStorage.getItem("jwt")).jwt;
        fetch(Env.account, {
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token
            }
        }).then(function (response) {
            return response.json();
        }).then(function (response) {
            console.log(response);
            this.setState({
                bio: response.profile.bio,
                tagline: response.profile.tagline
            });
        }.bind(this))
    }

    getAlbum(){
        let token = JSON.parse(localStorage.getItem("jwt")).jwt;
        fetch(Env.album, {
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token
            }
        }).then(function (response) {
            return response.json();
        }).then(function (response) {
            console.log(response);
            let images = [];
            for (var i=0;i<response.photos.length;i++){
                let temp = (response.photos[i]);
                images.push(
                    <div key={i} className="col-sm-6 col-md-4 col-lg-2">
                        <div className="theme-preview card text-xs-center fade-in one" style={{height:200}}>
                            <img  className="card-img img-fluid" src={temp.source} style={{width:"100%", height:"100%"}}/>
                        </div>
                    </div>
                );
            }

            this.setState({
                uploads: images,
            });
        }.bind(this))

    }



        render() {
        return (
            <div className="container" style={{marginTop:30}}>
                    <div className="theme-card card text-xs-center">
                        <div className="card-header">
                            <span className="card-title">
                                {this.state.userName}
                                <i onClick={this.props.logout} className="material-icons float-xs-right" style={{cursor:"pointer"}}>power_settings_new</i>
                            </span>
                        </div>

                        <div className="card-block">
                           <div className="card-text">{this.state.tagline}
                        </div>
                        <div className="card-block">
                            <div className="card-text">{this.state.bio}</div>
                        </div>
                        <div className="card-footer">
                            <button onClick={this.editMode.bind(this)} className="theme-button">
                                <i className="material-icons">edit</i>&nbsp;{this.state.editText}
                            </button>
                            <button onClick={this.albumMode.bind(this)} className="theme-button">
                                <i className="material-icons">collections</i>&nbsp;{this.state.albumText}
                            </button>
                            {this.state.isAdmin && <Link to="/admin"><button className="theme-button">
                                <i className="material-icons">assignment_ind</i>&nbsp;Admin Panel</button></Link>}
                        </div>
                    </div>
                </div>
                {this.state.edit && <EditMode
                    tagline={this.state.tagline}
                    bio={this.state.bio}
                    updateTagline={this.updateTagline.bind(this)}
                    updateBio={this.updateBio.bind(this)}
                />}
                {this.state.album  && <Album uploads={this.state.uploads}/>}

            </div>
        );
    }
}

export default Dashboard;
