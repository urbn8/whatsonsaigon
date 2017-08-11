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
  offsetToCursor,
} from 'graphql-relay'

import slugify from 'slug'

import { DBOrganiser, DBUser } from './database'
import logger from './logger'

import { GraphQLOrganiser, GraphQLOrganiserEdge, OrganiserConnection } from './types/Organiser'

function objToCursor(obj) {
  const str = JSON.stringify(obj)
  return new Buffer(str).toString('base64')
}

// mutation abc {
//  	addOrganiser(input: {website: "a", name: "ab4", desc: "desc"}) {
//  	  clientMutationId
//   	organiser {
//       id
//       name
//     }
//     organiserEdge {
//       cursor
//     }
//     viewer {
//       id
//       name
//     }
//  	}
// }
const GraphQLAddOrganiserMutation = mutationWithClientMutationId({
  name: 'AddOrganiser',
  inputFields: {
    name: { type: new GraphQLNonNull(GraphQLString) },
    website: { type: new GraphQLNonNull(GraphQLString) },
    desc: { type: new GraphQLNonNull(GraphQLString) },
  },
  outputFields: {
    edge: { // ???
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
      resolve: async (source, b, c, d) => {
        logger.debug('organiser resolve arguments', JSON.stringify(source.entity))
        return source.entity.toJSON()
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
    const entity = await new DBOrganiser({name, slug, website, desc}).save()

    // const entities = await DBOrganiser.fetchAll()
    
    // const user = new DBUser({id: 1})
    const globalId = toGlobalId('Organiser', entity.id)
    logger.debug('entity', entity, 'globalId', globalId)
    await new DBOrganiser({id: entity.id}).users().attach(2)

    return {entity, edge: {
      // cursor: cursorForObjectInConnection(entities, entities.find((item) => item.id === entity.id)),
      cursor: objToCursor({id: entity.id}),
      node: entity.toJSON(),
    }}
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

    logger.debug('entityId', entityId)
    const user = new DBUser({id: 1})
    await new DBOrganiser({id: entityId}).users().attach(1)
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
