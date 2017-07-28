import React, { Component } from 'react'
import {
  createFragmentContainer,
  graphql
} from 'react-relay'

import { OrganiserContainer } from './Organiser'

export class OrganiserList extends Component {
  render() {
    return (
      <div>
        <ul>
          {
            this.props.organisers.map((organiser) => (
              <li key={ organiser.id }>
                <OrganiserContainer organiser={organiser}/>
              </li>
            ))
          }
        </ul>
      </div>
    )
  }
}

export const OrganiserListContainer = createFragmentContainer(OrganiserList, graphql`
  fragment OrganiserList_viewer on Viewer {
    edges {
      node {
        ...Organiser_organiser
      }
    }
  }
`)
