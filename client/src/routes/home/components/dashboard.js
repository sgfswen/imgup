import React, { Component } from 'react';
import 'whatwg-fetch'




class Dashboard extends Component {
    constructor(props) {
        super(props);
        this.state = {
            authenticated: false
        }
    }

    render() {
        return (
            <div>
                <div class="jumbotron jumbotron-fluid">
                    <div class="container">
                        <h1 class="display-3">Imgup</h1>
                        <p class="lead">This simply beautiful image host</p>
                    </div>
                </div>
                <div className="container">
                    <div className="card">
                        <div className="card-header">User name</div>
                        <div className="card-block">
                            Basic user info
                        </div>
                        <div className="card-block">
                            <button className="btn btn-lg btn-primary">Upload</button>
                            <button className="btn btn-lg btn-secondary">Gallery</button>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default Dashboard;
