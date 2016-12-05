import React, { Component } from 'react';
import {browserHistory} from 'react-router';
import CheckLogin from '../../utilities/checkLogin';
import Env from '../../utilities/env';

import Uploads from './components/uploads';
import Users from './components/users';
import Reports from './components/reports';



/*
 * adminInfo:
 *      uploads: []
 *      users: []
 *
 */

class AdminPanel extends Component {
    constructor(props) {
        super(props);
        this.state = {
            usersView: false,
            uploadsView: false,
            reportsView: false,
            users: [],
            uploads: [],
            reports: []
        }

    }

    getAdminContent(){
        let token = JSON.parse(localStorage.getItem("jwt")).jwt;
        fetch(Env.admin, {
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token
            }
        }).then(function (response) {
            return response.json();
        }).then(function (response) {
            console.log(response);
            this.setState({
                users:   response.users,
                uploads: response.uploads,
                reports: response.reports
            });
        }.bind(this))
    }

    componentDidMount() {
        let user = CheckLogin();
        if (user && user.isAdmin) {
            console.log("authenticated");
            this.getAdminContent();
        } else {
            browserHistory.push("/");
        }
    }

    changeUsers(){
        this.setState({
            usersView: true,
            uploadsView: false,
            reportsView: false
        });
    }

    changeUploads(){
        this.setState({
            usersView: false,
            uploadsView: true,
            reportsView: false
        });
    }

    changeReports(){
        this.setState({
            usersView: false,
            uploadsView: false,
            reportsView: true
        });
    }

    deleteAccount(){
        let form = document.querySelector('form');
        let token = JSON.parse(localStorage.getItem("jwt")).jwt;
        fetch(Env.admin , {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token
            },
            body: new FormData(form),
        }).then(function (response) {
            return response.json();
        }).then(function (response) {
            console.log(response);
        }.bind(this))
    }



    render() {
        return (
            <div className="container" style={{marginTop:50}}>
                <div className="theme-card card">
                    <div className="card-header text-xs-center">
                        <h4 className="card-title">Imgup Admin Panel</h4>
                    </div>
                    <div className="card-block">
                        <div className="row">
                            <div className="col-xs-12 col-md-6 col-lg-4">
                                <div className="card-block text-xs-center"
                                     onClick={this.changeUsers.bind(this)}
                                     style={{backgroundColor:"#4CAF50", color:"white", marginTop:10,cursor:"pointer"}}>
                                    <h5 className="card-title">Total Users</h5>
                                    <h5 className="card-text">{this.state.users.length}</h5>
                                </div>
                            </div>
                            <div className="col-xs-12 col-md-6 col-lg-4">
                                <div className="card-block text-xs-center"
                                     onClick={this.changeUploads.bind(this)}
                                     style={{backgroundColor:"#FFC107", color:"white", marginTop:10, cursor:"pointer"}}>
                                    <h5 className="card-title">Total Uploads</h5>
                                    <h5 className="card-text">{this.state.uploads.length}</h5>
                                </div>
                            </div>
                            <div className="col-xs-12 col-md-6 col-lg-4">
                                <div className="card-block text-xs-center"
                                     onClick={this.changeReports.bind(this)}
                                     style={{backgroundColor:"#F44336", color:"white", marginTop:10, cursor:"pointer"}}>
                                    <h5 className="card-title">Total Reports</h5>
                                    <h5 className="card-text">{this.state.reports.length}</h5>
                                </div>
                            </div>
                        </div>
                        <div className="card-block">
                            {this.state.usersView && <Users users={this.state.users} delete={this.deleteAccount.bind(this)}/>}
                            {this.state.uploadsView && <Uploads uploads={this.state.uploads}/>}
                            {this.state.reportsView && <Reports reports={this.state.reports}/>}
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default AdminPanel;

