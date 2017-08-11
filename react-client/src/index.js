import React from 'react';
import ReactDOM from 'react-dom';
import BrowserProtocol from 'farce/lib/BrowserProtocol';
import queryMiddleware from 'farce/lib/queryMiddleware';
import { createFarceRouter, createRender } from 'found';
import { Resolver } from 'found-relay';

import environment from './Environment'
import routes from './routes';
import registerServiceWorker from './registerServiceWorker';

const Router = createFarceRouter({
  historyProtocol: new BrowserProtocol(),
  historyMiddlewares: [queryMiddleware],
  routeConfig: routes,

  render: createRender({}),
});

ReactDOM.render(
  <Router resolver={new Resolver(environment)} />,
  document.getElementById('root')
);
registerServiceWorker();
