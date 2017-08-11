import React, { Component } from 'react'
import {
  QueryRenderer,
  createFragmentContainer,
  graphql
} from 'react-relay'

import environment from '../Environment'
import CreateOrganiserMutation from '../CreateOrganiserMutation'

const CreatePageViewerQuery = graphql`
  query OrganiserFormViewerQuery {
    viewer {
      id
    }
  }
`

export class OrganiserForm extends Component {
  state = {
    name: '',
    desc: '',
    website: '',
  }

  _handlePost = (viewerId) => {
    const {name, desc, website} = this.state
    CreateOrganiserMutation(viewerId, name, desc, website, () => this.props.router.replace('/'))
  }

  render() {
    return (
      <QueryRenderer
        environment={environment}
        query={CreatePageViewerQuery}
        render={({error, props}) => {
          if (error) {
            return <div>{error.message}</div>
          } else if (props) {
            return (
              <div>
                <input
                  value={this.state.name}
                  placeholder='Name'
                  onChange={(e) => this.setState({name: e.target.value})}
                />
                <input
                  value={this.state.desc}
                  placeholder='Desc'
                  onChange={(e) => this.setState({desc: e.target.value})}
                />
                <input
                  value={this.state.website}
                  placeholder='Website'
                  onChange={(e) => this.setState({website: e.target.value})}
                />
                <button onClick={() => this._handlePost(props.viewer.id)}>OK</button>
              </div>
            )
          }

          return <div>Loading</div>
      }}
      />
    )
  }
}