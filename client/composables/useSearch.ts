import { useState } from '#app'

export const useSearch = (value = '') => {
  return useState('search', () => value)
}
