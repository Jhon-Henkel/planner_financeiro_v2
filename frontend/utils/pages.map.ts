import {IconEnum} from "~/utils/enum/icon.enum";

export type PageMap = {
    label: string;
    icon: string;
    route: string;
}

function baseUpdateItem(id: number, baseRoute: string): PageMap {
    return {
        label: 'Atualizar',
        icon: IconEnum.pencil,
        route: `${baseRoute}/${id}/atualizar`,
    }
}

function baseCreateItem(baseRoute: string): PageMap {
    return {
        label: 'Cadastrar',
        icon: IconEnum.plus,
        route: `${baseRoute}/cadastrar`,
    }
}

export const PagesMap = {
    page: {
        home: {
            label: 'Home',
            icon: IconEnum.home,
            route: 'home',
        },
        develop: {
            label: 'Develop',
            icon: IconEnum.terminal,
            route: 'develop',
        },
        auth: {
            login: {
                label: 'Login',
                icon: '',
                route: 'login',
            },
        },
        wallet: {
            manage: {
                label: 'Carteiras',
                icon: IconEnum.wallet,
                route: 'carteira',
            },
            create: baseCreateItem('carteira'),
            update: (id: number): PageMap => {
                return baseUpdateItem(id, 'carteira')
            }
        },
        movement: {
            manage: {
                label: 'Movimentações',
                icon: IconEnum.wallet,
                route: 'movimentacao',
            },
            create: baseCreateItem('movimentacao'),
            update: (id: number): PageMap => {
                return baseUpdateItem(id, 'movimentacao')
            }
        },
        expense: {
            manage: {
                label: 'Despesas',
                icon: IconEnum.banknoteArrowDown,
                route: 'despesa',
            },
            create: baseCreateItem('despesa'),
            update: (expenseId: number, installmentId: number): PageMap => {
                return {
                    label: 'Atualizar',
                    icon: IconEnum.pencil,
                    route: `despesa/${expenseId}/${installmentId}/atualizar`,
                }
            }
        }
    }
}
