import React, { Component } from 'react';

class About extends Component {
    constructor(props) {
        super(props);

    }

    render() {
        return (
                <div className="container" style={{marginTop:50}}>
                    <div className="theme-card card text-xs-center">
                        <div className="card-header"><h4>About</h4></div>
                        <div className="card-block">
                            <h5 className="card-text">
                                Imgup is an image hosting platform that is based on the popular host Imgur.
                            </h5>
                            <div className="card-block">
                                <h5 className="card-text">
                                    This project is built with: ReactJS, Bootstrap4, PHP 5 & AWS
                                </h5>
                            </div>
                            <h6 className="card-text">
                                This project is for educational purposes only.
                            </h6>

                        </div>
                    </div>
                </div>
        );
    }
}

export default About;
