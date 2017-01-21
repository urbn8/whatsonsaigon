import * as React from 'react'
import Hello from './Hello'
const World = require('./World').default

const HelloWorld = () => (
    <div>
        <Hello/>
        <World/>
    </div>
)

export default HelloWorld
