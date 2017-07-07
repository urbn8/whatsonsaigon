import {
  GraphQLList,
  GraphQLObjectType,
  GraphQLString,
  GraphQLInt
} from 'graphql'

import joinMonster from 'join-monster'

import knex from './database'
import BlogPost from './BlogPost'
import User from './User'
import Organiser from './types/Organiser'

import { nodeField } from './Node'
import dbCall from './dbCall'

const options = { dialect: 'mysql' }

export default new GraphQLObjectType({
  description: 'global query object',
  name: 'Query',
  fields: () => ({
    version: {
      type: GraphQLString,
      resolve: () => joinMonster.version
    },
    // implement the Node type from Relay spec
    node: nodeField,
    user: {
      type: User,
      args: {
        id: {
          type: GraphQLInt
        }
      },
      where: (usersTable, args, context) => { // eslint-disable-line no-unused-vars
        console.log('user args.id', args.id, usersTable)
        if (args.id) return `${usersTable}.id = ${args.id}`
      },
      resolve: (parent, args, context, resolveInfo) => {
        console.log('====resolving')
        // if (knex.client.config.client !== 'mysql') {
        //   throw new Error('This schema requires PostgreSQL. A data dump is provided in /data.')
        // }
        return joinMonster(resolveInfo, context, sql => dbCall(sql, knex, context), options)
      }
    },
    blogPost: {
      type: new GraphQLList(BlogPost),
      args: {
        id: {
          type: GraphQLInt
        }
      },
      where: (blogPostsTable, args, context) => { // eslint-disable-line no-unused-vars
        console.log('args.id', args.id)
        if (args.id) return `${blogPostsTable}.id = ${args.id}`
      },
      resolve: (parent, args, context, resolveInfo) => {
        // if (knex.client.config.client !== 'mysql') {
        //   throw new Error('This schema requires PostgreSQL. A data dump is provided in /data.')
        // }
        return joinMonster(resolveInfo, context, sql => dbCall(sql, knex, context), options)
      }
    },
    organisers: {
      type: new GraphQLList(Organiser),
      args: {
        id: {
          type: GraphQLInt
        }
      },
      resolve: (parent, args, context, resolveInfo) => {
        return joinMonster(resolveInfo, context, sql => dbCall(sql, knex, context), options)
      }
    }
  })
})
