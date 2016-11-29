import React, { Component } from 'react';

class About extends Component {
    constructor(props) {
        super(props);
        this.state = {
            authenticated: false
        }
    }

    render() {
        return (
            <div>
                <div className="jumbotron jumbotron-fluid text-xs-center">
                    <div className="container">
                        <h1 className="display-3">About</h1>
                        <p className="lead">This simply beautiful image host</p>
                    </div>
                </div>
                <div className="container">
                    <div className="card">
                        <div className="card-block">
                            <div className="card-text">
                                Imgup is a minimal material design clone of the Imgur image hosting platform.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default About;
