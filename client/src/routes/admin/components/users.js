import React, { Component } from 'react';

const ACTIONS = ["Delete"];

class Users extends Component {
    constructor(props) {
        super(props);
        this.state = {
            rows: [],
            account: "",
            message: ""
        }

    }

    createTable(){
        let data = this.props.users;
        console.log(data);
        let rows = [];
        let accounts = [];
        for (var i = 0; i<data.length; i++){
            let id = parseInt(data[i].id);
            let username = data[i].username;
            let isAdmin = parseInt(data[i].isAdmin);
            rows.push(
                <tr key={i} className="text-xs-center">
                    <th scope="row" className="text-xs-center">{i}</th>
                    <td>{id}</td>
                    <td>{username}</td>
                    <td>{isAdmin}</td>
                </tr>
            );

        }

        this.setState({
            rows: rows,
            accounts: accounts
        });

    }



    componentDidMount() {
        this.createTable();

    }

    render() {
        return (
           <div>
            <table className="table table-bordered table-inverse">
                <thead>
                <tr>
                    <th className="text-xs-center">#</th>
                    <th className="text-xs-center">ID</th>
                    <th className="text-xs-center">Username</th>
                    <th className="text-xs-center">Admin Status</th>
                </tr>
                </thead>
                <tbody>
                    {this.state.rows}
                </tbody>
            </table>
               <form>
                   <input name="userid" className="theme-input" placeholder="Enter id"/>

                   <input name="username" className="theme-input" placeholder="Enter username" value={this.state.account}
                          onChange={(event)=>{this.setState({account:event.target.value})}}/>
               </form>
               <button className="btn btn-lg btn-danger" onClick={this.props.delete}>Delete: {this.state.account}</button>
           </div>

        );
    }
}

export default Users;

