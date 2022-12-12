import { IncomingMessage, ServerResponse } from 'http'

export default (req: IncomingMessage, res: ServerResponse) => {
  const token = useCookie(req, 'token')
  res.statusCode = 200
  res.end(token)
}
