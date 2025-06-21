import axios, {type AxiosResponse, HttpStatusCode} from "axios";
import {TimeEnum} from "~/utils/enum/time.enum";
import type {LoginFormInterface} from "~/modules/auth/login/login.form.interface";
import type {NotificationInterface} from "~/composables/notification/notify.interface";
import {useAuthStore} from "~/modules/auth/auth.store";
import {RouteUtil} from "~/utils/route/route.util";
import type {IApiListResponseInterface} from "~/plugins/router/api.list.response.interface";
import type {IApiResponseInterface} from "~/plugins/router/api.get.response.interface";
import type {IWalletItem} from "~/modules/wallet/wallet.item.interface";
import type {IMovementItem} from "~/modules/movement/movement.item.interface";

export function createApi(notify: NotificationInterface) {
    const config = useRuntimeConfig()
    const baseApiUrl = config.public.API_URL
    const route = useRoute();
    const store = useAuthStore();

    axios.defaults.timeout = TimeEnum.tenSecondsInMs
    axios.interceptors.response.use(response => {
        return response
    }, async (error) => {
        let notificated = false
        if (error.response) {
            const status = error.response.status
            const loginPage = PagesMap.page.auth.login
            if (status === HttpStatusCode.Unauthorized) {
                notificated = true
                notify.error('Você não está logado!', 'Faça login novamente!')
                store.logout()
                RouteUtil.redirect(loginPage)
            } else if (status === HttpStatusCode.Forbidden) {
                notificated = true
                notify.error(error.response.data.data, 'Sem Permissão!')
            } else if (status === HttpStatusCode.ServiceUnavailable) {
                notificated = true
                notify.error('Estamos atualizando o sistema! Vai demorar só um pouquinho, prometo!', 'Tente novamente daqui a apouco!')
            } else if (status === HttpStatusCode.BadRequest) {
                badRequestError(error)
                return error.response
            } else if (route.fullPath === loginPage.route) {
                notificated = true
                notify.error('Nome de usuário e/ou senha está incorreto', 'Credenciais inválidas!')
            } else if (status === HttpStatusCode.NotFound) {
                notificated = true
                notify.error('Não conseguimos encontrar o item solicitado!', 'Não encontrado!')
            }
        }
        if (error.message.includes("timeout of ")) {
            notificated = true
        }
        if (!notificated) {
            notify.error('Entre em contato com o administrador do sistema!', 'Ocorreu um erro!')
        }
        return Promise.reject(error)
    })

    function badRequestError(error: any): void {
        const loginPage = PagesMap.page.auth.login
        if (route.fullPath === loginPage.route) {
            notify.error('Nome de usuário e/ou senha está incorreto', 'Credenciais inválidas!')
            return
        }

        const rawData = error.response.data?.data
        let parsedData
        try {
            parsedData = JSON.parse(rawData)
        } catch {
            parsedData = rawData
        }

        if (typeof parsedData === 'object' && !Array.isArray(parsedData)) {
            notify.error(formatValidationErrors(parsedData), 'Erro de validação!')
        } else if (Array.isArray(parsedData)) {
            notify.error(parsedData[0], 'Erro de validação!')
        } else {
            notify.error(parsedData ?? 'Erro de requisição!')
        }
    }

    function formatValidationErrors(errors: Record<string, string[]>): string {
        return Object.entries(errors).map(([field, messages]) => {
            if (Array.isArray(messages)) {
                return `• ${field}: ${messages.join(', ')}`
            }
            return `• ${field}: Erro desconhecido`
        }).join('\n')
    }

    function mountApiV1Url(uri: string, id: null | number = null): string {
        const url: string = `${baseApiUrl}v1/${uri}`
        return id ? `${url}/${id}` : url
    }

    function mountApiV1ListUrl(uri: string, page: number, perPage: number, search: string, orderBy: string, order: string, extraParams: string = ''): string {
        let url: string = `${baseApiUrl}v1/${uri}`
        url = `${url}?page=${page}&search=${search}&order_by=${orderBy}&order_direction=${order}&per_page=${perPage}`
        if (extraParams.length > 0) {
            url = `${url}${extraParams}`
        }
        return url
    }

    function makeJsonHeaders(): object {
        return {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${store.token}`,
            }
        }
    }

    function makeMultipartHeaders(): object {
        return {
            headers: {
                'Content-Type': 'multipart/form-data',
                'Accept': 'application/json',
                'Authorization': `Bearer ${store.token}`,
            }
        }
    }

    async function baseCreate(uri: string, data: any, jsonHeader: boolean = true): Promise<any> {
        const url: string = mountApiV1Url(uri)
        let headers = makeJsonHeaders()
        if (!jsonHeader) {
            headers = makeMultipartHeaders()
        }
        const result: AxiosResponse = await axios.post(url, data, headers)
        return result.data
    }

    async function baseGet(uri: string, itemId: number): Promise<any> {
        const url: string = mountApiV1Url(uri, itemId)
        const response: AxiosResponse = await axios.get(url, makeJsonHeaders())
        return response.data
    }

    async function baseList(uri: string, page: number = 1, perPage: number = 10, search: string = '', orderBy: string = 'id', order: string = 'asc', extraParams: string = ''): Promise<any> {
        const url: string = mountApiV1ListUrl(uri, page, perPage, search, orderBy, order, extraParams)
        const response: AxiosResponse = await axios.get(url, makeJsonHeaders())
        return response.data
    }

    async function baseUpdate(uri: string, itemId: number, data: any): Promise<any> {
        const url: string = mountApiV1Url(uri, itemId)
        const result: AxiosResponse = await axios.put(url, data, makeJsonHeaders())
        return result.data
    }

    async function baseDelete(uri: string, itemId: number): Promise<boolean> {
        const url: string = mountApiV1Url(uri, itemId)
        const response: AxiosResponse = await axios.delete(url, makeJsonHeaders())
        return response.data.status === HttpStatusCode.Ok
    }

    return {
        authentication: {
            login: async function (data: LoginFormInterface) {
                const url = `${baseApiUrl}auth/login`
                const headers = {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    }
                }
                const response: AxiosResponse = await axios.post(url, data, headers)
                return response.data
            },
        },
        wallet: {
            list: async function (page: number = 1, perPage: number = 10, search: string = '', orderBy: string = 'id', order: string = 'desc', extraParams: string = ''): Promise<IApiListResponseInterface<IWalletItem>> {
                return await baseList('wallet', page, perPage, search, orderBy, order, extraParams)
            },
            get: async function (id: number): Promise<IApiResponseInterface<IWalletItem>> {
                return await baseGet('wallet', id)
            },
            create: async function (data: any): Promise<IApiResponseInterface<IWalletItem>> {
                return await baseCreate('wallet', data)
            },
            update: async function (data: any, id: number): Promise<IApiResponseInterface<IWalletItem>> {
                return await baseUpdate('wallet', id, data)
            },
            delete: async function (id: number): Promise<boolean> {
                return await baseDelete('wallet', id)
            },
        },
        movement: {
            list: async function (page: number = 1, perPage: number = 10, search: string = '', orderBy: string = 'id', order: string = 'desc', extraParams: string = ''): Promise<IApiListResponseInterface<IMovementItem>> {
                return await baseList('movement', page, perPage, search, orderBy, order, extraParams)
            },
            get: async function (id: number): Promise<IApiResponseInterface<IMovementItem>> {
                return await baseGet('movement', id)
            },
        },
    }
}
