import dayjs from 'dayjs'
import relativeTime from 'dayjs/plugin/relativeTime.js'

export default defineNuxtPlugin(() => {
  dayjs.extend(relativeTime)
  return { provide: { dayjs } }
})
