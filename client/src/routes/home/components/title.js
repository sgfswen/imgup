import React, { Component } from 'react';


class Title extends Component {
    constructor(props) {
        super(props);

    }

    render() {
        return (
            <div className="card-header text-xs-center">
                <h4 style={{fontFamily:"Rubik"}}>The Simply Purfect Image Host</h4>
            </div>

        );
    }
}

export default Title;