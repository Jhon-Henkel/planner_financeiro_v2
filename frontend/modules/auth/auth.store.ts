import { defineStore } from 'pinia'
import type {AuthUserdataInterface} from "~/modules/auth/auth.userdata.interface";
import {RouteUtil} from "~/utils/route/route.util";

const expirationSessionTimeInSeconds = 14400

export const useAuthStore = defineStore('auth', {
    state: () => ({
        token: null as string|null,
        name: null as string|null,
        email: null as string|null,
        userId: null as number|null,
        expiresIn: null as number|null,
    }),
    persist: true,
    actions: {
        login(data: AuthUserdataInterface) {
            this.token = data.token
            this.name = data.name
            this.email = data.email
            this.userId = data.id
            this.expiresIn = Math.floor(Date.now() / 1000) + expirationSessionTimeInSeconds
        },
        logout() {
            this.token = null
            this.name = null
            this.email = null
            this.userId = null
            this.expiresIn = null
            RouteUtil.redirect(PagesMap.page.auth.login)
        }
    }
})
