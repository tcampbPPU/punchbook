import { IncomingMessage, ServerResponse } from 'http'

export default (req: IncomingMessage, res: ServerResponse) => {
  const token = useQuery(req).token as string
  setCookie(res, 'token', token, { path: '/', maxAge: 9999999999 })
  res.end('success')
}
