/**
 * @flow
 */

/* eslint-disable */

'use strict';

/*::
import type {ConcreteFragment} from 'relay-runtime';
export type OrganiserList_viewer = {|
  +organisers: ?{|
    +edges: ?$ReadOnlyArray<?{|
      +cursor: string;
      +node: ?{| |};
    |}>;
  |};
|};
*/


const fragment /*: ConcreteFragment*/ = {
  "argumentDefinitions": [],
  "kind": "Fragment",
  "metadata": {
    "connection": [
      {
        "count": null,
        "cursor": null,
        "direction": "forward",
        "path": [
          "organisers"
        ]
      }
    ]
  },
  "name": "OrganiserList_viewer",
  "selections": [
    {
      "kind": "LinkedField",
      "alias": "organisers",
      "args": null,
      "concreteType": "OrganiserConnection",
      "name": "__OrganiserList_organisers_connection",
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
                  "kind": "FragmentSpread",
                  "name": "Organiser_organiser",
                  "args": null
                }
              ],
              "storageKey": null
            }
          ],
          "storageKey": null
        }
      ],
      "storageKey": null
    }
  ],
  "type": "User"
};

module.exports = fragment;
