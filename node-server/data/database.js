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

export const DBUser = bookshelf.Model.extend({
  tableName: 'users',
  organisers() {
    return this.belongsToMany(DBOrganiser).through(DBUserOrganiserJuntor, 'user_id')
  }
})

export const DBUserOrganiserJuntor = bookshelf.Model.extend({
  tableName: 'urbn8_wos_organiser_user_joins',
})

export const DBOrganiser = bookshelf.Model.extend({
  tableName: 'urbn8_wos_organisers',
  users() {
    return this.belongsToMany(DBUser).through(DBUserOrganiserJuntor, 'organiser_id')
  }
})

export default knex