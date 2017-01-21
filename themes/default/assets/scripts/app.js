const bc = 'asdfasdf'
console.log(`hey yeah ${ bc }`)

import log from './log'

import * as ReactDOM from 'react-dom'
import * as React from 'react'

import Hello from './Hello'

ReactDOM.render(
    <Hello/>,
    document.getElementById('root')
)
