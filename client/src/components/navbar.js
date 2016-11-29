import React, { Component } from 'react';
import {Link} from 'react-router';

class MyNavbar extends Component {
    render() {
        return (
            <nav className="navbar navbar-dark bg-primary">
                <div className="container">
                    <Link to="/" className="navbar-brand">Imgup</Link>
                    <ul className="nav navbar-nav">
                        <li className="nav-item">
                            <Link to="/home" className="nav-link" activeStyle={{color:'white', textDecoration: 'underline'}}>
                                Home
                            </Link>
                        </li>
                        <li className="nav-item">
                            <Link to="/about" className="nav-link" activeStyle={{color:'white', textDecoration: 'underline'}}>
                                About
                            </Link>
                        </li>
                        <li className="nav-item">
                            <Link to="/experience" className="nav-link" activeStyle={{color:'white', textDecoration: 'underline'}}>
                                Upload
                            </Link>
                        </li>
                        <li className="nav-item">
                            <Link to="/logout" className="nav-link" activeStyle={{color:'white', textDecoration: 'underline'}}>
                                Logout
                            </Link>
                        </li>
                    </ul>
                </div>
            </nav>
        );
    }
}
export default MyNavbar;