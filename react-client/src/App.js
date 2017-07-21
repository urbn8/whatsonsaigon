import React, { Component } from 'react';
import logo from './logo.svg';
import './App.css';

import {
  QueryRenderer,
  graphql
} from 'react-relay'
import environment from './Environment'

import ListPage from './components/ListPage'

const AppAllPostQuery = graphql`
  query AppAllPostQuery {
    viewer {
      ...ListPage_viewer
    }
  }
`

class App extends Component {
  render() {
    /*return (
      <div className="App">
        <div className="App-header">
          <img src={logo} className="App-logo" alt="logo" />
          <h2>Welcome to React</h2>
        </div>
        <p className="App-intro">
          To get started, edit <code>src/App.js</code> and save to reload.
        </p>
      </div>
    );*/
    return (
      <QueryRenderer
        environment={environment}
        query={AppAllPostQuery}
        render={({error, props}) => {
          if (error) {
            return <div>{error.message}</div>
          } else if (props) {
            return <ListPage viewer={props.viewer} />
          }
          return <div>Loading</div>
        }}
      />
    )
  }
}

export default App;
