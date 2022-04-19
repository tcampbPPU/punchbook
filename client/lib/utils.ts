export default class Utils {

  /**
   * Perform a sleep as a Promise
   * ex: await this.$sleep(200)
   * @param milliseconds
   */
  sleep (milliseconds: number) {
    return new Promise(resolve => setTimeout(resolve, milliseconds))
  }

  /**
   * Generate a random integer similar to php's rand()
   * @see https://www.php.net/rand
   * @param min - The lowest value to return
   * @param max - The highest value to return
   */
  rand (min: number, max: number): number {
    return Math.floor(Math.random() * (max - min + 1)) + min
  }

  ucFirst (string: string) {
    return string.charAt(0).toUpperCase() + string.slice(1)
  }

  /**
   * Returns a function, that, as long as it continues to be invoked, will not
   * be triggered. The function will be called after it stops being called for
   * N milliseconds. If `immediate` is passed, trigger the function on the
   * leading edge, instead of the trailing.
   */
  debounce (func: () => never, wait: number, immediate?: boolean) {
    let timeout: number | undefined = undefined
    return function () {
      // eslint-disable-next-line prefer-rest-params
      const args = arguments
      const later = () => {
        timeout = undefined
        if (!immediate) func.apply(this, args)
      }
      const callNow = immediate && !timeout
      clearTimeout(timeout)
      timeout = setTimeout(later, wait) as unknown as number
      if (callNow) func.apply(this, args)
    }
  }

  /**
   * @desc Smooth scroll to an element
   * @param {String} id
   * @returns void
   */
  properScroll (id: string): void {
    const el = document.getElementById(id)
    if (!el) return
    const { top, left } = el.getBoundingClientRect()
    window.scrollTo({top, left, behavior: 'smooth'})
  }

  /**
   * @desc Determines if the text color should be black or white based on the given color
   * @param {String} color
   * @returns boolean
   */
  textContrast (color: string): boolean {
    color = (color.charAt(0) === '#') ? color.substring(1, 7) : color

    const r = parseInt(color.substring(0, 2), 16)
    const g = parseInt(color.substring(2, 4), 16)
    const b = parseInt(color.substring(4, 6), 16)

    return (((r * 0.299) + (g * 0.587) + (b * 0.114)) > 186)
  }

  /**
   * Obtains a string and reduces it's length and concat '...' to the end
   * @param {String} str - String being shortened
   * @param {Number} len - n number of characters to show
   * @param {Boolean} regex - Optional for replacing content of string
   * @returns string
   */
  shortStr (str: string, len: number, regex = true): string {
    const currentStr = str
    if (!str) return ''
    str = regex ? currentStr.replace(/<[^>]+>/g, '') : currentStr
    str = str.replace(/&nbsp;/gi, ' ')
    if (str.length > len) str = str.substring(0, len) + '...'

    return str
  }

}
