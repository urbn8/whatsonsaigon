// import { provideSingleton } from "../IOC"
import { injectable } from "inversify"
import {
  observable, extendObservable, action,
  IObservableArray,
} from 'mobx'

interface BizType {
  slug: string
  name: string
}

export interface IBizTypeStore {
  items: IObservableArray<BizType>
  generateSamples(): Promise<IObservableArray<BizType>>
}

@injectable()
export class BizTypeStore implements IBizTypeStore {
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

    this.items.replace(generatedItems)
    this.loading = false

    return this.items
  }
}