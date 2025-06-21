import {IconEnum} from "~/utils/enum/icon.enum";

export type PageMap = {
    label: string;
    icon: string;
    route: string;
}

export type PageGroupMap = {
    label: string;
    icon: string;
}

export const PagesMap = {
    page: {
        home: {
            label: 'Início',
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
            create: {
                label: 'Cadastrar Carteira',
                icon: IconEnum.plus,
                route: 'carteira/cadastrar',
            },
            update: (id: number) => {
                return {
                    label: 'Atualizar Carteira',
                    icon: IconEnum.pencil,
                    route: `carteira/${id}/atualizar`,
                }
            }
        },
        movement: {
            manage: {
                label: 'Movimentações',
                icon: IconEnum.wallet,
                route: 'movimentacao',
            },
            create: {
                label: 'Cadastrar',
                icon: IconEnum.plus,
                route: 'movimentacao/cadastrar',
            },
        }
    }
}
