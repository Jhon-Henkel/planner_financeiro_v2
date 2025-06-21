import BaseService from "~/utils/service/base.service";
import type {IServiceList} from "~/utils/interface/service.list.interface";
import type {IApiListResponseInterface} from "~/plugins/router/api.list.response.interface";
import type {IWalletItem} from "~/modules/wallet/wallet.item.interface";
import type {FormSubmitEvent} from "@nuxt/ui";
import {HttpStatusCode} from "axios";
import {RouteUtil} from "~/utils/route/route.util";
import {alertApi} from "~/composables/alert/alert.api";
import type {WalletSchemaType} from "~/modules/wallet/wallet.schema";
import {StatusActiveInactiveEnum} from "~/utils/enum/status.active.inactive.enum";

export class WalletService extends BaseService implements IServiceList<IWalletItem> {

    constructor() {
        super();
    }

    public async get(id: number): Promise<IWalletItem> {
        const item = await this.api.wallet.get(id)
        return item.data
    }

    public async list(page: number, perPage: number, search: string, orderBy: string, order: string, filters: string): Promise<IApiListResponseInterface<IWalletItem>> {
        return this.api.wallet.list(page, perPage, search, orderBy, order, filters)
    }

    public async create(event: FormSubmitEvent<WalletSchemaType>): Promise<void> {
        const result = await this.api.wallet.create(event.data)
        if (result.status === HttpStatusCode.Created) {
            this.notify.success(`Carteira ${result.data.name} criada com sucesso!`)
            RouteUtil.redirect(PagesMap.page.wallet.manage)
        }
    }

    public async update(event: FormSubmitEvent<WalletSchemaType>, id: number): Promise<void> {
        const result = await this.api.wallet.update(event.data, id)
        if (result) {
            this.notify.success(`Carteira ${event.data.name} atualizada com sucesso!`)
            RouteUtil.redirect(PagesMap.page.wallet.manage)
        }
    }

    public async delete(id: number, tableRef: Ref<any>): Promise<void> {
        await alertApi.askDelete(async (): Promise<boolean> => {
            return await this.api.wallet.delete(id)
        })
        await tableRef.value?.refresh();
    }

    public makeState(): WalletSchemaType {
        return {
            name: '',
            status: StatusActiveInactiveEnum.active,
            amount: 0,
            hidden: false,
        }
    }

    public makeStateByItem(item: IWalletItem): WalletSchemaType {
        return {
            name: item.name,
            status: item.status,
            amount: item.amount,
            hidden: item.hidden,
        }
    }
}
