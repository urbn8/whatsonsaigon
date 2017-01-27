import * as mobx from 'mobx'
mobx.useStrict(true)

import { container } from '../IOC'

import { IBizTypeStore, BizTypeStore } from './BizTypeStore'

export default function start() {
  container.bind<IBizTypeStore>(BizTypeStore).to(BizTypeStore)
}
