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

export const Post = bookshelf.Model.extend({
  tableName: 'rainlab_blog_posts'
})

export const User = bookshelf.Model.extend({
  tableName: 'users',
  posts: function() {
    return this.hasMany(Post);
  },
})

