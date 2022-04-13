export const useSearch = (value = '') => {
  return useState('search', () => value)
}
