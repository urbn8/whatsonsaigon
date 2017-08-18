import React, { Component } from 'react'
import {
  createPaginationContainer,
  createFragmentContainer,
  graphql
} from 'react-relay'

import { OrganiserContainer } from './Organiser'

export class OrganiserList extends Component {
  _loadMore() {
    if (!this.props.relay.hasMore() || this.props.relay.isLoading()) {
      return;
    }

    this.props.relay.loadMore(
      5, // Fetch the next 10 feed items
      e => {
        console.log(e);
      },
    );
  }
  
  render() {
    console.log('this.props', this.props)
    return (
      <div>
        <a href="/organisers/new">New</a>
        <ul>
          {
            this.props.viewer.organisers.edges.map(({node}) => (
              <li key={ node.__id }>
                <OrganiserContainer organiser={node}/>
              </li>
            ))
          }
        </ul>
        <button
          type='button'
          onClick={() => this._loadMore()}
        >
        Load More
        </button>
      </div>
    )
  }
}

// export const OrganiserListContainer = createFragmentContainer(OrganiserList, graphql`
// fragment OrganiserList_viewer on User {
//   organisers(first: 10) @connection(key: "OrganiserList_organisers") {
//     edges {
//       cursor
//       node {
//         ...Organiser_organiser
//       }
//     }
//   }
// }
// `)

export const OrganiserListContainer = createPaginationContainer(OrganiserList,
  {
    viewer: graphql`
      fragment OrganiserList_viewer on User {
        organisers(first: $count, after: $cursor) @connection(key: "OrganiserList_organisers") {
          edges {
            cursor
            node {
              ...Organiser_organiser
            }
          }
          pageInfo {
            endCursor
            hasNextPage
          }
        }
      }
    `
  },
  {
    direction: 'forward',
    getConnectionFromProps(props) {
      console.log('props', props)
      return props.viewer && props.viewer.organisers;
    },
    getFragmentVariables(prevVars, totalCount) {
      console.log('getFragmentVariables', prevVars, totalCount)
      return {
        ...prevVars,
        count: totalCount,
      };
    },
    getVariables(props, {count, cursor}, fragmentVariables) {
      console.log('getVariables', props, {count, cursor}, fragmentVariables)
      return {
        count: count || 10,
        cursor,
      };
    },
    query: graphql`
      query OrganiserListPaginationQuery(
        $count: Int!
        $cursor: String
      ) {
        viewer {
          ...OrganiserList_viewer
        }
      }
    `,
  }
)
