import BaseService from "~/utils/service/base.service";
import type {IServiceList} from "~/utils/interface/service.list.interface";
import type {IApiListResponseInterface} from "~/plugins/router/api.list.response.interface";
import type {IWalletItem} from "~/modules/wallet/wallet.item.interface";

export class WalletService extends BaseService implements IServiceList<any> {

    constructor() {
        super();
    }

    get(id: number): Promise<IWalletItem> {
        const item = this.api.wallet.get(id)
        return item.data
    }

    list(page: number, perPage: number, search: string, orderBy: string, order: string, filters: string): Promise<IApiListResponseInterface<any>> {
        return this.api.wallet.list(page, perPage, search, orderBy, order, filters)
    }
}
