import * as React from 'react'
import { observer } from 'mobx-react'
import { style } from "typestyle"

import { inject } from '../../IOC'
import { BizTypeStore } from '../../stores/BizTypeStore'

const textStyle = style({color: 'red'})

@observer
export class BizTypeList extends React.Component<{}, {}>{

  @inject(BizTypeStore)
  private store: BizTypeStore

  componentDidMount() {
    console.log('generateSamples')
    this.store.generateSamples()
  }

  render() {
    return (
      <ul>
        { this.store.items.map((item) => (
          <li> { item.name } </li>
        )) }
      </ul>
    )
  }
}
