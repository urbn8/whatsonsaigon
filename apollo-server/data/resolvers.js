import { User, Post } from './connectors';

const resolveFunctions = {
  RootQuery: {
    async user(_, { email }){
      console.log('email', email)
      let where = { email };
      const user = await User.where(where).fetch();
      console.log('user', user.toJSON())
      return user.toJSON()
    },
    async users(_, {}){
      const users = await User.fetchAll();
      console.log('users', users.toJSON())
      return users.toJSON()
    },
    async posts(postsTable, { offset }) {
      console.log('postsTable', postsTable)
      const posts = await Post.fetchAll()
      return posts.toJSON()
    }
  },
  RootMutation: {
    // createAuthor: (root, args) => { return Author.create(args); },
    createPost: async (root, { userId, title, slug }) => {
      const post = await new Post({
        user_id: userId, title, slug
      }).save()
      console.log('created post' , post, post.toJSON())
      return post.toJSON()
    },
  },
  User: {
    async posts(user){
      user = await User.where('id', user.id).fetch({withRelated: ['posts']})
      const posts = user.related('posts')
      console.log('posts', posts.toJSON())
      return posts.toJSON()
    },
  },
  // Post: {
  //   author(post){
  //     return post.getAuthor();
  //   },
  //   tags(post){
  //     return post.tags.split(',');
  //   },
  //   views(post){
  //     return new Promise((resolve, reject) => {
  //       setTimeout( () => reject('MongoDB timeout when fetching field views (timeout is 500ms)'), 500);
  //       View.findOne({ postId: post.id }).then( (res) => resolve(res.views) );
  //     })
  //   }
  // }
}

export default resolveFunctions;
