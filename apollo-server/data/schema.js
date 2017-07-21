import {
  makeExecutableSchema,
  // addMockFunctionsToSchema,
} from 'graphql-tools';
// import mocks from './mocks'
import resolvers from './resolvers'

import typeDefs from './schema.graphql'

const schema = makeExecutableSchema({
  typeDefs,
  resolvers,
});

// addMockFunctionsToSchema({ schema, mocks });

export default schema;
