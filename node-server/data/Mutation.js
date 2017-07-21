import {
  GraphQLBoolean,
  GraphQLID,
  GraphQLInt,
  GraphQLList,
  GraphQLNonNull,
  GraphQLObjectType,
  GraphQLSchema,
  GraphQLString,
} from 'graphql'

import {
  connectionArgs,
  connectionDefinitions,
  connectionFromArray,
  cursorForObjectInConnection,
  fromGlobalId,
  globalIdField,
  mutationWithClientMutationId,
  nodeDefinitions,
  toGlobalId,
} from 'graphql-relay'

import slugify from 'slug'

import { DBOrganiser } from './database'
import logger from './logger'

import GraphQLOrganiser, { GraphQLOrganiserEdge } from './types/Organiser'

const GraphQLAddOrganiserMutation = mutationWithClientMutationId({
  name: 'AddOrganiser',
  inputFields: {
    name: { type: new GraphQLNonNull(GraphQLString) },
    website: { type: new GraphQLNonNull(GraphQLString) },
    desc: { type: new GraphQLNonNull(GraphQLString) },
  },
  outputFields: {
    organiserEdge: {
      type: GraphQLOrganiserEdge,
      // resolve: (entity) => {
      //   // var todo = getTodo(id);
      //   return {
      //     // cursor: cursorForObjectInConnection(getTodos(), todo),
      //     node: entity,
      //   };
      // },
    },
    organiser: {
      type: GraphQLOrganiser,
      resolve: async (a, b, c, d) => {
        logger.debug('organiser resolve arguments', JSON.stringify(a.organiser))
        return a.organiser
      },
    },
    viewer: {
      type: GraphQLOrganiser,
      resolve: async () => {
        return {name: 'b'}
      },
    },
  },
  mutateAndGetPayload: async ({name, website, desc}) => {
    const slug = slugify(name)
    const organiser = await new DBOrganiser({name, slug, website, desc}).save()
    logger.debug('organiser', organiser)
    return {organiser}
  },
})

const GraphQLUpdateOrganiserMutation = mutationWithClientMutationId({
  name: 'UpdateOrganiser',
  inputFields: {
    id: { type: new GraphQLNonNull(GraphQLID) },
    name: { type: new GraphQLNonNull(GraphQLString) },
  },
  outputFields: {
    organiser: {
      type: GraphQLOrganiser,
      resolve: async (payload, b, c, d) => {
        logger.debug('organiser resolve payload.entity.id', payload.entity.id)
        const entity = await payload.entity.fetch()
        logger.debug('organiser resolve entity', JSON.stringify(entity))
        return entity.toJSON()
      },
    },
  },
  mutateAndGetPayload: async ({id, name}) => {
    const entityId = fromGlobalId(id).id
    const slug = slugify(name)
    const entity = await new DBOrganiser({id: entityId}).save({name, slug}, {patch: true})
    // const entity = await new DBOrganiser({id: entityId, name}).save()
    return {entity}
  },
})

const Mutation = new GraphQLObjectType({
  name: 'Mutation',
  fields: {
    addOrganiser: GraphQLAddOrganiserMutation,
    updateOrganiser: GraphQLUpdateOrganiserMutation,
  },
})

export default Mutation
