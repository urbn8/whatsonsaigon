import express from 'express';
import bodyParser from 'body-parser';

import { makeExecutableSchema } from 'graphql-tools'
import { graphqlExpress, graphiqlExpress } from 'graphql-server-express';

const graphqlHTTP = require('express-graphql')

import schema from './data/schema'

// const typeDefs = `
//   type Query {
//     hello: String
//   }
// `;

// const resolvers = {
//   Query: {
//     hello: (root, args, context) => {
//       return 'Hello world!';
//     },
//   },
// };

// const myGraphQLSchema = makeExecutableSchema({
//   typeDefs,
//   resolvers,
// });

const PORT = 3000;

const app = express();

// bodyParser is needed just for POST.
// app.use('/graphql', bodyParser.json(), graphqlExpress({ schema: myGraphQLSchema, graphiql: true }));

// app.use('/graphql', graphqlHTTP({
//   schema: schema,
//   graphiql: true
// }))

app.use('/graphql', bodyParser.json(), graphqlExpress({ schema }));
app.use('/graphiql', graphiqlExpress({ endpointURL: '/graphql' }));

app.listen(PORT, () => {
  console.log('started')
})
