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
  forwardConnectionArgs,
  connectionDefinitions
} from 'graphql-relay'

import knex from './database'
import { nodeInterface } from './Node'

import BlogPost from './BlogPost'

const User = new GraphQLObjectType({
  description: 'a stem contract account',
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
    }
  })
})

const { connectionType: UserConnection } = connectionDefinitions({ nodeType: User })

export default User 

