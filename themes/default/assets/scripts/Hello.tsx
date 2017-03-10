import * as React from 'react'
import {style} from "typestyle"

const textStyle = style({color: 'red'})

const Hello = () => (
    <h3 className={ textStyle }> Hello there!</h3>
)

export default Hello
