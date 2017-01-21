import { AppContainer } from 'react-hot-loader'

const bc = 'asdfasdf'
console.log(`hey yeah ${ bc }`)

import log from './log'

import { render } from 'react-dom'
import * as React from 'react'

// const Hello = require('./Hello').default
const World = require('./World').default

render(
    <AppContainer>
        <World/>
    </AppContainer>,
    document.getElementById('root')
)

if (module.hot) {
  module.hot.accept('./World', () => {
    const World = require('./World').default

    render(
        <AppContainer>
            <World/>
        </AppContainer>,
        document.getElementById('root')
    )
  })
}