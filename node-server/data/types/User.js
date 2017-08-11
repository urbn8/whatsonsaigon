import {
  GraphQLObjectType,
  GraphQLList,
  GraphQLString,
  GraphQLInt,
  GraphQLFloat
} from 'graphql'

import {
  globalIdField,
  connectionArgs,
  forwardConnectionArgs, // => for LIMIT, OFFSET based pagination. Can jump to middle page. Can get total items easily
  connectionDefinitions
} from 'graphql-relay'

import knex from '../database'
import { nodeInterface } from '../Node'

import BlogPost from '../BlogPost'
import { GraphQLOrganiser, OrganiserConnection } from './Organiser'

// to navigate to any page in the middle:
// import { offsetToCursor } from 'graphql-relay'
// let cursor = offsetToCursor(9)

/*
query ABC {
  viewer {
    organisers(first: 3, after: "YXJyYXljb25uZWN0aW9uOjE=") {
      pageInfo {
        endCursor
      }
      total
      edges {
        cursor
        node {
          id
          name
          slug
        }
      }
    }
  }
}
*/

export const GraphQLUser = new GraphQLObjectType({
  description: 'a user',
  name: 'User',
  sqlTable: 'users',
  uniqueKey: 'id',
  // This implements the node interface
  interfaces: [ nodeInterface ],
  fields: () => ({
    id: {
      description: 'The global ID for the Relay spec',
      // all the resolver for the globalId needs is the id property
      ...globalIdField(),
      sqlDeps: [ 'id' ]
    },
    name: {
      type: GraphQLString,
      sqlColumn: 'name'
    },
    email: {
      type: GraphQLString,
      sqlColumn: 'email'
    },
    posts: {
      type: new GraphQLList(BlogPost),
      // this is a one-to-many relation
      // this function tells join monster how to join these tables
      sqlJoin: (userTable, postTable) => `${userTable}.id = ${postTable}.user_id`,
    },
    organisers: {
      type: OrganiserConnection,
      // type: new GraphQLList(GraphQLOrganiser),
      args: connectionArgs,
      sqlPaginate: true,
      orderBy: {
        id: 'desc'
      },
      junction: {
        // name the table that holds the two foreign keys
        sqlTable: 'urbn8_wos_organiser_user_joins',
        uniqueKey: [ 'organiser_id', 'user_id' ],
        sqlBatch: {
          // the matching column in the junction table
          thisKey: 'user_id',
          // the column to match in the user table
          parentKey: 'id',
          // sortKey: {
          //   order: 'desc',
          //   key: [ 'organiser_id' ]
          // },
          // how to join the related table to the junction table
          sqlJoin: (junctionTable, organiserTable) => `${junctionTable}.organiser_id = ${organiserTable}.id`
        }
        // sqlJoins: [
        //   // first the parent table to the junction
        //   (userTable, junctionTable, args) => `${userTable}.id = ${junctionTable}.user_id`,
        //   // then the junction to the child
        //   (junctionTable, organiserTable, args) => `${junctionTable}.organiser_id = ${organiserTable}.id`
        // ]
      }
      // sqlJoin: (userTable, organiserTable) => `${userTable}.id = ${organiserTable}.user_id`,
    }
  })
})

const { connectionType: UserConnection } = connectionDefinitions({ nodeType: GraphQLUser })


