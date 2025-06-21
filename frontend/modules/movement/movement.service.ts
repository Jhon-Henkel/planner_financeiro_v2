import BaseService from "~/utils/service/base.service";
import type {IServiceList} from "~/utils/interface/service.list.interface";
import type {IApiListResponseInterface} from "~/plugins/router/api.list.response.interface";
import type {IMovementItem} from "~/modules/movement/movement.item.interface";

export class MovementService extends BaseService implements IServiceList<IMovementItem> {
    constructor() {
        super();
    }

    public async get(id: number): Promise<IMovementItem> {
        const item = await this.api.movement.get(id)
        return item.data
    }

    public async list(page: number, perPage: number, search: string, orderBy: string, order: string, filters: string): Promise<IApiListResponseInterface<IMovementItem>> {
        return this.api.movement.list(page, perPage, search, orderBy, order, filters)
    }
}
