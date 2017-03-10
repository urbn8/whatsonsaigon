import * as React from 'react'
import { render } from 'react-dom'
import { AppContainer } from 'react-hot-loader'

const HelloWorld = require('./HelloWorld').default

render(
    <AppContainer>
        <HelloWorld/>
    </AppContainer>,
    document.getElementById('root')
)

if (module.hot) {
  module.hot.accept('./HelloWorld', () => {
    const HelloWorld = require('./HelloWorld').default

    render(
        <AppContainer>
            <HelloWorld/>
        </AppContainer>,
        document.getElementById('root')
    )
  })
}