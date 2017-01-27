import * as React from 'react'
import { observer } from 'mobx-react'
import { style } from "typestyle"

import { inject } from '../../IOC'
import { IBizTypeStore, BizTypeStore } from '../../stores/BizTypeStore'

const textStyle = style({color: 'red'})

@observer
export class BizTypeList extends React.Component<{}, {}>{

  @inject(BizTypeStore)
  private store: IBizTypeStore

  componentDidMount() {
    this.store.generateSamples()
  }

  render() {
    return (
      <ul>
        { this.store.items.map((item) => (
          <li key={ item.slug }> { item.name } </li>
        )) }
      </ul>
    )
  }
}
