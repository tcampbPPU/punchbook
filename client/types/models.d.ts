export {}
declare global {
  export namespace models {

    export interface Contact {
      // columns
      id: number
      name: string
      phone: string
      email?: string
      created_at?: Date
      updated_at?: Date
      deleted_at?: Date
      // mutators
      first_name: string
      avatar: string
    }
    export type Contacts = Array<Contact>

    export interface Provider {
      // columns
      id: number
      user_id: number
      avatar?: string
      name: string
      payload: string
      created_at?: Date
      updated_at?: Date
    }

    export type Providers = Array<Provider>

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

    export type Sessions = Array<Session>
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

    export interface User {
      // columns
      id: number
      email: string
      name?: string
      avatar?: string
      stripe?: string
      is_sub: boolean
      created_at?: Date
      updated_at?: Date
      // mutators
      is_trial: boolean
      first_name: string
      has_active_session: boolean
      session: Session
      location: SessionLocation
      // relations
      providers: Providers
      sessions: Sessions
    }

    export type Users = Array<User>
  }
}
