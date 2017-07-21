const knex = require('knex')({
  client: 'mysql',
  connection: {
    host: '127.0.0.1',
    user: 'root',
    password: '',
    database: 'whatsonsaigon',
  },
})

const bookshelf = require('bookshelf')(knex)

export const DBOrganiser = bookshelf.Model.extend({
  tableName: 'urbn8_wos_organisers'
})

export default knex