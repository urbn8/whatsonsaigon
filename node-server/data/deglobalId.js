import {
  fromGlobalId,
} from 'graphql-relay'

export default function(req, res) {
  console.log('req', req)
  const globalId = res.params.id
  res.send(fromGlobalId(globalId))
}
