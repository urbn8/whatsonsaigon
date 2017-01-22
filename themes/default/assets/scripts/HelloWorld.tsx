import * as React from 'react'

import { Button } from 'semantic-ui-react'

import Hello from './Hello'

const World = require('./World').default

const HelloWorld = () => (
    <div>
        <Hello/>
        <World/>
        <Button primary>Primary</Button>
        <Button secondary>Secondary</Button>
    </div>
)

export default HelloWorld
