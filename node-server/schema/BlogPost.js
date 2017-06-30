import {
  GraphQLObjectType,
  GraphQLList,
  GraphQLString,
  GraphQLInt,
  GraphQLFloat,
  GraphQLID
} from 'graphql'

import {
  globalIdField,
  connectionArgs,
  forwardConnectionArgs,
  connectionDefinitions
} from 'graphql-relay'

import knex from './database'
import { nodeInterface } from './Node'

const BlogPost = new GraphQLObjectType({
  description: 'a stem contract account',
  name: 'BlogPost',
  sqlTable: 'rainlab_blog_posts',
  uniqueKey: 'id',
  // This implements the node interface
  interfaces: [ nodeInterface ],
  fields: () => ({
    id: {
      description: 'The global ID for the Relay spec',
      // all the resolver for the globalId needs is the id property
      ...globalIdField(),
      sqlDeps: [ 'id' ]
      // type: GraphQLID,
      // sqlColumn: 'id'
    },
    title: {
      type: GraphQLString,
      sqlColumn: 'title',
      resolve: async (post, args, context, resolveInfo) => {
        const result = await knex.from('rainlab_translate_attributes').where({
          locale: 'en',
          model_id: post.id,
        })

        const data = result[0].attribute_data
        const translation = JSON.parse(data)
        return translation.title
      }
    },
    slug: {
      type: GraphQLString,
      // sqlColumn: 'slug'
    },
  })
})

const { connectionType: BlogPostConnection } = connectionDefinitions({ nodeType: BlogPost })

export default BlogPost 

