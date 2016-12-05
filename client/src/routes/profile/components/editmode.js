import React, { Component } from 'react';


class EditMode extends Component {
    constructor(props) {
        super(props);

    }

    render() {
        return (
            <div className="theme-card card">
                  <div className="card-block text-xs-center">
                    <form>
                        <input name="tagline" className="theme-input" type="text" value={this.props.tagline} onChange={this.props.updateTagline}/><br/>
                        <textarea name="bio" className="theme-input" type="text" value={this.props.bio} onChange={this.props.updateBio}/><br/>
                    </form>
                  </div>
            </div>
        );
    }
}

export default EditMode;
