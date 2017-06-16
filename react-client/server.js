const http = require('http')
const fs = require('fs')

const static = require('node-static')

const port = 3000

const app = require('./build/app.node.js')

const html = fs.readFileSync('./build/index.html', 'utf8')

const file = new static.Server('./build')

const staticFileExts = ['.css', '.js', '.png', '.jpg']

function isStatic(url) {
  for (const ext of staticFileExts) {
    if (url.endsWith(ext)) {
      return true
    }
  }

  return false
}

const requestHandler = (req, res) => {
  if (isStatic(req.url)) {
    file.serve(req, res)
    return
  }

  app.default(req.url).then(
    (document) => {

      const rendered = html.replace('<div id="App"></div>', `<div id="App">${ document }</div>`)
      
      res.end(rendered)
    },
    (err) => {
      res.end('error: ', err)
    }
  )
}

const server = http.createServer(requestHandler)

server.listen(port, (err) => {  
  if (err) {
    return console.log('something bad happened', err)
  }

  console.log(`server is listening on ${port}`)
})
