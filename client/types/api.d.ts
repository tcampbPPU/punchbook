export {}
declare global {
  export namespace api {
    export interface MetApiResponse {
      success: boolean
      message: string
      type: 'success' | 'failure'
      data: unknown
    }

    export interface MetApiResults {
      benchmark: number
      status: 'success' | 'failure'
      query: {
        options: Record<string, unknown>
        params: Record<string, unknown>
      }
      paginate?: MetApiPaginate
      data: unknown
    }

    export interface MetApiPaginate {
      current_page: number
      first_item: number
      last_item: number
      last_page: number
      pages: Array<number>
      per_page: number
      total: number
    }

    export interface Session {
      token: string
      user_id: number
      source: string
      ip: string
      agent: string
      location: SessionLocation
      device: SessionDevice
      current: boolean
      created_at: Date
      updated_at: Date
    }

    export interface SessionLocation {
      ip: string
      country: string
      city: string
      state: string
      postal_code: number
      lat: string
      lon: string
      timezone: string
      currency: string
    }

    export interface SessionDevice {
      string: string
      platform: string
      browser: string
      name: string
      desktop: boolean
      mobile: boolean
    }

    export type Sessions = Array<Session>
  }
}
