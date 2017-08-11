import React, { Component } from 'react'
import {
  createFragmentContainer,
  graphql
} from 'react-relay'

import { OrganiserContainer } from './Organiser'

export class OrganiserList extends Component {
  render() {
    console.log('this.props', this.props)
    return (
      <div>
        <ul>
          {
            this.props.viewer.organisers.edges.map(({node}) => (
              <li key={ node.__id }>
                <OrganiserContainer organiser={node}/>
              </li>
            ))
          }
        </ul>
      </div>
    )
  }
}

export const OrganiserListContainer = createFragmentContainer(OrganiserList, graphql`
  fragment OrganiserList_viewer on User {
    organisers(first: 3, after: "YXJyYXljb25uZWN0aW9uOjE=") {
      edges {
        cursor
        node {
          ...Organiser_organiser
        }
      }
    }
  }
`)
