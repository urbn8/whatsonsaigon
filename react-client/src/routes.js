import makeRouteConfig from 'found/lib/makeRouteConfig';
import Route from 'found/lib/Route';
import React from 'react';
import { graphql } from 'react-relay';

import { OrganiserListContainer } from './components/OrganiserList'
import { OrganiserForm } from './components/OrganiserForm'

const AppAllOrganiserQuery = graphql`
  query routes_OrganiserList_Query {
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
    />
    <Route
      path='organisers/new'
      Component={ OrganiserForm }
      query={ AppAllOrganiserQuery }
    />
  </Route>,
);