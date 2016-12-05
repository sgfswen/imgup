import React, { Component } from 'react';
import {Link} from 'react-router';




class LoginNav extends Component {

    render() {
        return (
            <li className="nav-item"><Link to="/login" className="nav-link">Login</Link></li>
        );
    }
}
export default LoginNav;
