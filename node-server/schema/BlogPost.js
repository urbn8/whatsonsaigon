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
  // where: (blogPostsTable, args, context) => { // eslint-disable-line no-unused-vars
  //   console.log('where from blogPost', blogPostsTable, args)
  // },
  // resolve: async (post, args, context, resolveInfo) => {
  //   console.log('blogPost resolve', post, args)
  //   return []
  // },
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
        // console.log(context)
        const result = await knex.from('rainlab_translate_attributes').where({
          locale: 'en',
          model_id: post.id,
          // model_type: 'RainLab\Blog\Models\Post'
        })

        const data = result[0].attribute_data
        const translation = JSON.parse(data)
        return translation[resolveInfo.fieldName]
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

