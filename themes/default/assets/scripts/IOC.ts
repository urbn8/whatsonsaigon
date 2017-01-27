import { Container, interfaces } from "inversify"
import { makeFluentProvideDecorator } from 'inversify-binding-decorators'
import getDecorators from 'inversify-inject-decorators'

export const container = new Container()

const provide = makeFluentProvideDecorator(container)

export function provideInstance(identifier: string|symbol|interfaces.Newable<any>|interfaces.Abstract<any>) {
  return provide(identifier).done();
}

export function provideSingleton(identifier: string|symbol|interfaces.Newable<any>|interfaces.Abstract<any>) {
  return provide(identifier).inSingletonScope().done();
}

export const inject = getDecorators(container).lazyInject
