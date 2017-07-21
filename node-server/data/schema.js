import { GraphQLSchema } from 'graphql'

import QueryRoot from './QueryRoot'
import Mutation from './Mutation'

export default new GraphQLSchema({
  query: QueryRoot,
  mutation: Mutation,
})
