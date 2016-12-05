import React, { Component } from 'react';
import {Link} from 'react-router';
import CheckLogin from '../utilities/checkLogin';

import logo from '../assets/logo.png';



class MyNavbar extends Component {
    constructor(props) {
        super(props);
        this.state = {
            authenticated: false,
            user : {}
        }
    }


    /*
     * Called on component load to check if the user is authenticated
     */
    componentDidMount(){
        let user = CheckLogin();
        if (user){
            this.setState({
                authenticated:true,
                user:user
            })
        } else {
            this.setState({
                authenticated: false,
                user: {}
            })

        }
    }


    render() {
        return (
            <nav className="navbar navbar-dark theme-surface">
                <div className="container theme-navbar">
                    <Link to="/" className="nav-item">
                        <img className="img-fluid" src="https://s3.us-east-2.amazonaws.com/wfpublic/imgup/media/logo.d2549b39.png"/>
                    </Link>
                    <div className="float-xs-right">
                        <ul className="nav navbar-nav">
                            <li className="nav-item">
                                <Link to="/about" className="nav-link">
                                        About
                                </Link>
                            </li>
                            <li className="nav-item">
                                <Link to="/profile" className="nav-link">
                                        Account
                                </Link>
                            </li>
                            <li className="nav-item">
                                <Link to="/upload" className="nav-link">
                                        Upload
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        );
    }
}
export default MyNavbar;