/**
 * @flow
 * @relayHash 7a085b16207d6458cb0e40b11588e1db
 */

/* eslint-disable */

'use strict';

/*::
import type {ConcreteBatch} from 'relay-runtime';
export type OrganiserFormViewerQueryResponse = {|
  +viewer: ?{|
    +id: string;
  |};
|};
*/


/*
query OrganiserFormViewerQuery {
  viewer {
    id
  }
}
*/

const batch /*: ConcreteBatch*/ = {
  "fragment": {
    "argumentDefinitions": [],
    "kind": "Fragment",
    "metadata": null,
    "name": "OrganiserFormViewerQuery",
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
            "kind": "ScalarField",
            "alias": null,
            "args": null,
            "name": "id",
            "storageKey": null
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
  "name": "OrganiserFormViewerQuery",
  "query": {
    "argumentDefinitions": [],
    "kind": "Root",
    "name": "OrganiserFormViewerQuery",
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
  "text": "query OrganiserFormViewerQuery {\n  viewer {\n    id\n  }\n}\n"
};

module.exports = batch;
