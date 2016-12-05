import React, { Component } from 'react';


class Album extends Component {
    constructor(props) {
        super(props);

    }

    render() {
        return (
            <div className="theme-card card">
                <div className="card-block">
                    <div className="row">
                        {this.props.uploads}
                    </div>
                </div>
            </div>
        );
    }
}

export default Album;

