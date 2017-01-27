import { provideSingleton } from "../IOC"
import {
  observable, extendObservable, runInAction, action,
  IObservableArray,
} from 'mobx'

interface BizType {
  slug: string
  name: string
}

@provideSingleton(BizTypeStore)
export class BizTypeStore {
  @observable loading = false
  @observable items: IObservableArray<BizType> = observable([])

  @action public async generateSamples(): Promise<IObservableArray<BizType>> {
    this.loading = true
    const generatedItems: BizType[] = []

    for (let i = 0; i < 100; i++) {
      generatedItems.push({
        slug: 'type-' + i,
        name: 'Type ' + i,
      })
    }

    // runInAction(() => {
      this.items.replace(generatedItems)
      this.loading = false
    // })

    return this.items
  }
}