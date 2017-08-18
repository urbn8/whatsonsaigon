import makeRouteConfig from 'found/lib/makeRouteConfig';
import Route from 'found/lib/Route';
import React from 'react';
import { graphql } from 'react-relay';

import { OrganiserListContainer } from './components/OrganiserList'
import { OrganiserFormContainer } from './components/OrganiserForm'

const AppAllOrganiserQuery = graphql`
  query routes_OrganiserList_Query($count: Int!, $cursor: String) {
    viewer {
      ...OrganiserList_viewer
    }
  }
`

export default makeRouteConfig(
  <Route
    path="/"
  >
    <Route
      Component={ OrganiserListContainer }
      query={ AppAllOrganiserQuery }
      prepareVariables={params => ({ ...params, count: 5 })}
    />
    <Route
      path='organisers/new'
      Component={ OrganiserFormContainer }
      query={ graphql`
        query routes_ViewerId_Query {
          viewer {
            id
          }
        }
      ` }
    />
  </Route>,
);