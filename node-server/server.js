import express from 'express';
import bodyParser from 'body-parser';

import { makeExecutableSchema } from 'graphql-tools'
import { graphqlExpress } from 'graphql-server-express';

const graphqlHTTP = require('express-graphql')

import schema from './schema'

const typeDefs = `
  type Query {
    hello: String
  }
`;

const resolvers = {
  Query: {
    hello: (root, args, context) => {
      return 'Hello world!';
    },
  },
};

const myGraphQLSchema = makeExecutableSchema({
  typeDefs,
  resolvers,
});

const PORT = 3000;

const app = express();

// bodyParser is needed just for POST.
// app.use('/graphql', bodyParser.json(), graphqlExpress({ schema: myGraphQLSchema, graphiql: true }));

app.use('/graphql', graphqlHTTP({
  schema: schema,
  graphiql: true
}))

app.listen(PORT)
