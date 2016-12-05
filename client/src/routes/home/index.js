import React, { Component } from 'react';
import CheckLogin from '../../utilities/checkLogin';
import Env from '../../utilities/env';

import 'whatwg-fetch'

import Viewer from '../viewer/index';
import Load from './components/load';
import Title from './components/title';

/*
 gallery
 id : number of page
 type: new, top
 photos:
    {
     id: pk of the photo
     uploader: uploader of the photo
     original: original link
     up: number of thumbs up
     down: number of thumbs down
     views : number of views
    }
    ...
 */

class Home extends Component {
    constructor(props) {
        super(props);
        this.state = {
            page: 1,
            filter: "new",
            hot: false,
            views: false,
            new: true,
            authenticated: false,
            userName: "",
            userId: 0,
            encoded: "",
            links: [],
            gallery: [],
            single: false,

        }
    }


    componentWillMount(){
        //var j = this.getGallery();
       // console.log(j);
    }

    getGallery(){
        let url = Env.gallery + "?filter="+this.state.filter+"&page="+this.state.page;
        console.log(url);
        fetch(url, {
                method: 'GET',
            }
        ).then(function(response) {
            console.log(response);
            return response.json();
        }).then(function(j) {
            console.log(j);
            let links = j.img;
            let strings = [];
            let images = [];
            for (var i = 0; i<links.length;i++){
                let temp = (links[i]);
                strings.push(temp);
                images.push(
                    <div key={i} className="col-sm-6 col-md-4 col-lg-2">
                        <div className="theme-preview card text-xs-center fade-in one" style={{height:200}}>
                            <img onClick={() => this.transitionView(temp)} className="card-img img-fluid" src={temp.source} style={{width:"100%", height:"100%"}}/>
                        </div>
                    </div>
                )
            }
            this.setState({gallery:images, links:strings});
        }.bind(this));
    }

    componentDidMount(){
        let user = CheckLogin();
        if (user){console.log("authenticated");}
        this.getGallery();

    }

    transitionView(imgObject) {
        console.log(imgObject);
        this.setState({
            selected: imgObject,
            single: true
        });
    }
    transitionGallery(){
        this.setState({
            selected:0,
            single:false
        });
    }

    changeNew(){
        // If in hot mode and switching to new
        this.setState({
                new: true,
                hot: false,
                views: false,
                filter: "new"
            });
        // Update the gallery
        this.getGallery();
    }

    changeHot(){
        // If in hot mode and switching to new
        this.setState({
            new: false,
            hot: true,
            views: false,
            filter: "hot"
        });
        // Update the gallery
        this.getGallery();
    }

    changeViews(){
        // If in hot mode and switching to new
        this.setState({
            new: false,
            hot: false,
            views: true,
            filter: "views"
        });
        // Update the gallery
        this.getGallery();
    }



    loadMore(){
        console.log("more");
    }

    render() {
        return (
        <div className="container" style={{marginTop:50}}>
            <div className="theme-card card">
                {!this.state.single && <Title/>}
                <div className="card-block text-xs-center" style={{backgroundColor:"rgba(25,236,187,.6)", color:"white"}}>
                    <label className="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-1">
                        <input type="radio" id="option-1" className="mdl-radio__button" name="options" value="1"
                               checked={this.state.new}
                               onClick={this.changeNew.bind(this)}
                        />
                            <span className="mdl-radio__label">Most Recent</span>
                    </label>
                    <label className="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-2" style={{marginLeft:10}}>
                        <input type="radio" id="option-2" className="mdl-radio__button" name="options" value="2"
                               checked={this.state.hot}
                               onClick={this.changeHot.bind(this)}
                        />
                            <span className="mdl-radio__label">Top Voted</span>
                    </label>
                    <label className="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-3" style={{marginLeft:10}}>
                        <input type="radio" id="option-3" className="mdl-radio__button" name="options" value="3"
                               checked={this.state.views}
                               onClick={this.changeViews.bind(this)}
                        />
                        <span className="mdl-radio__label">Most Views</span>
                    </label>
                </div>
                <div className="card-block">
                    <div className="row">
                        {!this.state.single && this.state.gallery}
                        {this.state.single && <Viewer
                                        img={this.state.selected}
                                        back={this.transitionGallery.bind((this))}
                        />}
                    </div>
                </div>
                {!this.state.single && <Load more={this.loadMore.bind(this)}/>}
            </div>
        </div>

        );
    }
}

export default Home;
