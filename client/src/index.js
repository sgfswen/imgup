import React from 'react';
import ReactDOM from 'react-dom';
import {Router, Route, browserHistory, IndexRoute} from 'react-router';

import App from './App';
import Home from './routes/home/';
import About from './routes/about';
import Profile from './routes/profile';
import Upload from './routes/upload';
import AdminPanel from './routes/admin';
import './index.css';

ReactDOM.render(
    <Router history={browserHistory}>
        <Route path="/" component={App}>
            <IndexRoute component={Home}/>
            <Route path="/about" component={About} />
            <Route path="/profile" component={Profile} />
            <Route path="/upload" component={Upload} />
            <Route path="/admin" component={AdminPanel} />
        </Route>
    </Router>,
  document.getElementById('root')
);
