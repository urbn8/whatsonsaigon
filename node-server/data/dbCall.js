export default async function dbCall(sql, knex, context) {
  // this is a little trick to help debugging and demo-ing. the client will display whatever is on the X-SQL-Preview header
  // DONT do something like this in production
  console.log('SQL: ', sql)
  // if (context && context.res) {
    // console.log('SQL: ', context.res.get('X-SQL-Preview') + '%0A%0A' + sql.replace(/%/g, '%25').replace(/\n/g, '%0A'))
    // context.set('X-SQL-Preview', context.response.get('X-SQL-Preview') + '%0A%0A' + sql.replace(/%/g, '%25').replace(/\n/g, '%0A'))
  // }
  // send the request to the database
  const result = await knex.raw(sql)
  console.log('result: ', JSON.stringify(sql))
  return result[0]
}
