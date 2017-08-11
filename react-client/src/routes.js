import makeRouteConfig from 'found/lib/makeRouteConfig';
import Route from 'found/lib/Route';
import React from 'react';
import { graphql } from 'react-relay';

import { OrganiserListContainer } from './components/OrganiserList'

const AppAllOrganiserQuery = graphql`
  query AppAllOrganiserQuery {
    viewer {
      ...OrganiserList_viewer
    }
  }
`

export default makeRouteConfig(
  <Route
    path="/"
    Component={ OrganiserListContainer }
    query={ AppAllOrganiserQuery }
  >
  </Route>,
);