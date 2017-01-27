import * as React from 'react'

import { Button } from 'semantic-ui-react'

import Hello from './Hello'
import { BizTypeList } from './components/BizTypeList/BizTypeList'

const World = require('./World').default

const HelloWorld = () => (
    <div>
        <Hello/>
        <World/>
        <Button primary>Primary</Button>
        <Button secondary>Secondary</Button>
        <BizTypeList/>
    </div>
)

export default HelloWorld
