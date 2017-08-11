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
  "metadata": null,
  "name": "OrganiserList_viewer",
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
      "storageKey": "organisers{\"after\":\"YXJyYXljb25uZWN0aW9uOjE=\",\"first\":3}"
    }
  ],
  "type": "User"
};

module.exports = fragment;
