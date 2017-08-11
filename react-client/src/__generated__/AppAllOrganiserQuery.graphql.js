/**
 * @flow
 * @relayHash 8022509c6368621f63b76e0a790dda49
 */

/* eslint-disable */

'use strict';

/*::
import type {ConcreteBatch} from 'relay-runtime';
export type AppAllOrganiserQueryResponse = {|
  +viewer: ?{| |};
|};
*/


/*
query AppAllOrganiserQuery {
  viewer {
    ...OrganiserList_viewer
    id
  }
}

fragment OrganiserList_viewer on User {
  organisers(first: 3, after: "YXJyYXljb25uZWN0aW9uOjE=") {
    edges {
      cursor
      node {
        ...Organiser_organiser
        id
      }
    }
  }
}

fragment Organiser_organiser on Organiser {
  id
  name
  slug
}
*/

const batch /*: ConcreteBatch*/ = {
  "fragment": {
    "argumentDefinitions": [],
    "kind": "Fragment",
    "metadata": null,
    "name": "AppAllOrganiserQuery",
    "selections": [
      {
        "kind": "LinkedField",
        "alias": null,
        "args": null,
        "concreteType": "User",
        "name": "viewer",
        "plural": false,
        "selections": [
          {
            "kind": "FragmentSpread",
            "name": "OrganiserList_viewer",
            "args": null
          }
        ],
        "storageKey": null
      }
    ],
    "type": "Query"
  },
  "id": null,
  "kind": "Batch",
  "metadata": {},
  "name": "AppAllOrganiserQuery",
  "query": {
    "argumentDefinitions": [],
    "kind": "Root",
    "name": "AppAllOrganiserQuery",
    "operation": "query",
    "selections": [
      {
        "kind": "LinkedField",
        "alias": null,
        "args": null,
        "concreteType": "User",
        "name": "viewer",
        "plural": false,
        "selections": [
          {
            "kind": "LinkedField",
            "alias": null,
            "args": [
              {
                "kind": "Literal",
                "name": "after",
                "value": "YXJyYXljb25uZWN0aW9uOjE=",
                "type": "String"
              },
              {
                "kind": "Literal",
                "name": "first",
                "value": 3,
                "type": "Int"
              }
            ],
            "concreteType": "OrganiserConnection",
            "name": "organisers",
            "plural": false,
            "selections": [
              {
                "kind": "LinkedField",
                "alias": null,
                "args": null,
                "concreteType": "OrganiserEdge",
                "name": "edges",
                "plural": true,
                "selections": [
                  {
                    "kind": "ScalarField",
                    "alias": null,
                    "args": null,
                    "name": "cursor",
                    "storageKey": null
                  },
                  {
                    "kind": "LinkedField",
                    "alias": null,
                    "args": null,
                    "concreteType": "Organiser",
                    "name": "node",
                    "plural": false,
                    "selections": [
                      {
                        "kind": "ScalarField",
                        "alias": null,
                        "args": null,
                        "name": "id",
                        "storageKey": null
                      },
                      {
                        "kind": "ScalarField",
                        "alias": null,
                        "args": null,
                        "name": "name",
                        "storageKey": null
                      },
                      {
                        "kind": "ScalarField",
                        "alias": null,
                        "args": null,
                        "name": "slug",
                        "storageKey": null
                      }
                    ],
                    "storageKey": null
                  }
                ],
                "storageKey": null
              }
            ],
            "storageKey": "organisers{\"after\":\"YXJyYXljb25uZWN0aW9uOjE=\",\"first\":3}"
          },
          {
            "kind": "ScalarField",
            "alias": null,
            "args": null,
            "name": "id",
            "storageKey": null
          }
        ],
        "storageKey": null
      }
    ]
  },
  "text": "query AppAllOrganiserQuery {\n  viewer {\n    ...OrganiserList_viewer\n    id\n  }\n}\n\nfragment OrganiserList_viewer on User {\n  organisers(first: 3, after: \"YXJyYXljb25uZWN0aW9uOjE=\") {\n    edges {\n      cursor\n      node {\n        ...Organiser_organiser\n        id\n      }\n    }\n  }\n}\n\nfragment Organiser_organiser on Organiser {\n  id\n  name\n  slug\n}\n"
};

module.exports = batch;
