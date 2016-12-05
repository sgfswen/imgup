import React, { Component } from 'react';


class Reports extends Component {
    constructor(props) {
        super(props);
        this.state = {
            rows: [],
            account: "",
            message: ""
        }

    }

    createTable(){
        let data = this.props.reports;
        console.log(data);
        let rows = [];
        for (var i = 0; i<data.length; i++){
            let id = parseInt(data[i].id);
            let uploader = parseInt(data[i].uploader);
            let imageLink = data[i].source;
            let upvotes = parseInt(data[i].up);
            let downvotes = parseInt(data[i].down);
            let views = parseInt(data[i].views);
            let reports = parseInt(data[i].reports);


            rows.push(
                <tr key={i} className="text-xs-center">
                    <th scope="row" className="text-xs-center">{i}</th>
                    <td>{id}</td>
                    <td>{uploader}</td>
                    <td><a href={imageLink}>AWS LINK</a></td>
                    <td>{upvotes}</td>
                    <td>{downvotes}</td>
                    <td>{views}</td>
                    <td>{reports}</td>
                </tr>
            );
        }

        this.setState({
            rows: rows,
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
                        <th className="text-xs-center">Photo ID</th>
                        <th className="text-xs-center">Uploader ID</th>
                        <th className="text-xs-center">Image Link</th>
                        <th className="text-xs-center">Upvotes</th>
                        <th className="text-xs-center">Downvotes</th>
                        <th className="text-xs-center">Views</th>
                        <th className="text-xs-center">Reports</th>
                    </tr>
                    </thead>
                    <tbody>
                    {this.state.rows}
                    </tbody>
                </table>
            </div>

        );
    }
}

export default Reports;