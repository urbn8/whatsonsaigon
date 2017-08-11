import React, { Component } from 'react';

import './App.css';

import {
  QueryRenderer,
  graphql
} from 'react-relay'
import environment from './Environment'

import { OrganiserListContainer } from './components/OrganiserList'

const AppAllOrganiserQuery = graphql`
  query AppAllOrganiserQuery {
    viewer {
      ...OrganiserList_viewer
    }
  }
`

class App extends Component {
  render() {
    return (
      <QueryRenderer
        environment={environment}
        query={AppAllOrganiserQuery}
        render={({error, props}) => {
          if (error) {
            return <div>{error.message}</div>
          } else if (props) {
            return <OrganiserListContainer viewer={props.viewer} />
          }
          return <div>Loading</div>
        }}
      />
    )
  }
}

export default App;
