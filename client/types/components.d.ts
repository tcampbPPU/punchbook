export {}
declare global {
  export namespace components {
    interface PageTab {
      /** label name of tab */
      label: string
      /** path */
      to: string
      /** route name */
      route: string
    }
    type PageTabs = Array<PageTab>

    interface PageBreadCrumb {
      /* label name */
      label: string | undefined
      /* provide an optional route to redirect */
      route?: string
    }
    type PageBreadCrumbs = Array<PageBreadCrumb>

  }
}
