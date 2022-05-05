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
      /** icon  */
      icon?: string
    }
    type PageBreadCrumbs = Array<PageBreadCrumb>

    interface SmartTableParams {
      /** Laravel API endpoint */
      route: string

      /** list of columns */
      columns: Array<SmartTableColumn>

      /** table default behaviors */
      defaults: SmartTableDefaults

      /** query params to send along with API  */
      query?: object

      /** does table need checkbox ability */
      checkable?: Checkable

      /** does table need actions column */
      actions?: boolean
    }

    interface SmartTableColumn {
      /** display name */
      label?: string

      /** field from Laravel API */
      field: string

      /** column types */
      type: 'text'|'date'|'link'|'checkbox'|'slot'

      /** can this field be sorted */
      sortable?: boolean

      /** can this field be filtered */
      filterable?: boolean
    }

    interface SmartTableDefaults {
      /** column to order by */
      order: string

      /** column order by direction */
      direction: 'desc' | 'asc',

      /** columns to always show by default */
      columns: Array<string>

      /** default query parameters */
      query?: { perpage: 10, page: 1 },
    }

    interface Checkable {
      /** Give slot control */
      slot?: boolean,

      /** callback function */
      callback?: {(): void},
    }

    interface SmartTableFetchParams {
      /** current page */
      page: number

      /** order by key */
      order?: string

      /** order by direction */
      direction?: 'asc' | 'desc'

      /** search string */
      search?: string

      /** filterable fields */
      filterFields?: Array<string>

      /** filterable input values */
      filterInputs?: Array<string>
    }

    interface SmartTableFilter {
      /** Column being fileted */
      column: SmartTableColumn

      /** filter input */
      input: string
    }
    type SmartTableFilters = Array<SmartTableFilter>

  }
}
