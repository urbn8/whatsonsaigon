import {
  commitMutation,
  graphql,
} from 'react-relay'
import {ConnectionHandler} from 'relay-runtime'
import environment from './Environment'

const mutation = graphql`
  mutation CreateOrganiserMutation($input: AddOrganiserInput!) {
    addOrganiser(input: $input) {
      organiser {
        id
        name
        slug
      }
      edge {
        cursor
        node {
          id
          name
          slug
        }
      }
    }
  }
`

let tempID = 1

export default (viewerId, name, desc, website, callback) => {

  const variables = {
    input: {
      name,
      desc,
      website,
    },
  }

  commitMutation(
    environment,
    {
      mutation,
      variables,
      // 6
      optimisticUpdater: (proxyStore) => {
        // 1 - create the `newPost` as a mock that can be added to the store
        const id = 'client:newOrganiser:' + tempID++
        const newPost = proxyStore.create(id, 'Post')
        newPost.setValue(id, 'id')
        newPost.setValue(name, 'name')
        newPost.setValue(desc, 'desc')
        newPost.setValue(website, 'website')
        console.log('viewerId', viewerId)
        // 2 - add `newPost` to the store
        const viewerProxy = proxyStore.get(viewerId)
        const connection = ConnectionHandler.getConnection(viewerProxy, 'OrganiserList_organisers')
        if (connection) {
          ConnectionHandler.insertEdgeBefore(connection, newPost)
        }
      },
      updater: (proxyStore) => {
        // 1 - retrieve the `newPost` from the server response
        const createOrganiserField = proxyStore.getRootField('addOrganiser')
        const newOrganiser = createOrganiserField.getLinkedRecord('edge')
        // 2 - add `newPost` to the store
        const viewerProxy = proxyStore.get(viewerId)
        console.log('newOrganiser', newOrganiser)
        console.log('viewerProxy', viewerProxy)
        console.log('cursor', newOrganiser.getType(), newOrganiser.getValue('cursor'))
        const cursor = newOrganiser.getValue('cursor')

        const connection = ConnectionHandler.getConnection(viewerProxy, 'OrganiserList_organisers')
        if (connection) {
          ConnectionHandler.insertEdgeBefore(connection, newOrganiser, cursor)
        }
      },
      // 7
      onCompleted: () => {
        callback()
      },
      onError: err => console.error(err),
    },
  )
}
