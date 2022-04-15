export {}
declare global {
  export namespace api {
    export interface HarmonyResponse {
      success: boolean
      message: string
      type: 'success' | 'failure'
      data: unknown
    }

    export interface HarmonyResults {
      benchmark: number
      status: 'success' | 'failure'
      query: {
        options: Record<string, unknown>
        params: Record<string, unknown>
      }
      paginate?: HarmonyPaginate
      data: unknown
    }

    export interface HarmonyPaginate {
      current_page: number
      first_item: number
      last_item: number
      last_page: number
      pages: Array<number>
      per_page: number
      total: number
    }

  }
}
