import React, { Component } from 'react';


class Load extends Component {
    constructor(props) {
        super(props);

    }

    render() {
        return (
            <div className="card-footer text-xs-center">
                <button id="loadMore" onClick={this.props.more}><strong>Load More</strong></button>
            </div>

        );
    }
}

export default Load;