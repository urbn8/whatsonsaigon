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

import knex from '../database'
import { nodeInterface } from '../Node'

const GraphQLOrganiser = new GraphQLObjectType({
  description: 'a stem contract account',
  name: 'Organiser',
  sqlTable: 'urbn8_wos_organisers',
  uniqueKey: 'id',
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
    slug: {
      type: GraphQLString,
      sqlColumn: 'slug'
    },
    website: {
      type: GraphQLString,
      sqlColumn: 'website'
    },
    phone: {
      type: GraphQLString,
      sqlColumn: 'phone'
    },
    email: {
      type: GraphQLString,
      sqlColumn: 'email'
    },
    facebook: {
      type: GraphQLString,
      sqlColumn: 'facebook'
    },
    twitter: {
      type: GraphQLString,
      sqlColumn: 'twitter'
    },
    address: {
      type: GraphQLString,
      sqlColumn: 'address'
    },
    desc: {
      type: GraphQLString,
      sqlColumn: 'desc'
    },
    status: {
      type: GraphQLInt,
      sqlColumn: 'status'
    },
  })
})

export const {
  connectionType: OrganiserConnection,
  edgeType: GraphQLOrganiserEdge,
} = connectionDefinitions({ nodeType: GraphQLOrganiser })

export default GraphQLOrganiser
