import React, { Component } from 'react';


class LogoutNav extends Component {

    logout(){
        if (localStorage.getItem("jwt")){
            localStorage.removeItem("jwt");
        }
    }

    render() {

        return (
            <li className="nav-item"><a className="nav-link" onClick={() => {this.logout(); this.props.refresh()}} >Logout</a></li>
        );
    }
}
export default LogoutNav;