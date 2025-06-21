import BaseService from "~/utils/service/base.service";
import type {IServiceList} from "~/utils/interface/service.list.interface";
import type {IApiListResponseInterface} from "~/plugins/router/api.list.response.interface";
import type {IMovementItem} from "~/modules/movement/movement.item.interface";
import type {MovementSchemaType, MovementTransferSchemaType} from "~/modules/movement/movement.schema";
import type {TMovement} from "~/modules/movement/type/movement.type";
import type {FormSubmitEvent} from "@nuxt/ui";
import {HttpStatusCode} from "axios";
import {RouteUtil} from "~/utils/route/route.util";

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

    public makeState(type: TMovement): MovementSchemaType {
        return {
            amount: 0,
            description: '',
            type: type,
            wallet_id: 0,
        }
    }

    public makeStateByItem(item: IMovementItem): MovementSchemaType {
        return {
            amount: item.amount,
            description: item.description,
            type: item.type,
            wallet_id: item.wallet_id,
        }
    }

    public makeTransferState(): MovementTransferSchemaType {
        return {
            amount: 0,
            from_id: 0,
            to_id: 0,
        }
    }

    public async create(event: FormSubmitEvent<MovementSchemaType>): Promise<void> {
        const result = await this.api.movement.create(event.data)
        if (result.status === HttpStatusCode.Created) {
            this.notify.success(`Movimentação criada com sucesso!`)
            RouteUtil.redirect(PagesMap.page.movement.manage)
        }
    }

    public async createTransfer(event: FormSubmitEvent<MovementTransferSchemaType>): Promise<void> {
        const result = await this.api.movement.transfer.create(event.data)
        if (result.status === HttpStatusCode.Created) {
            this.notify.success(`Movimentação criada com sucesso!`)
            RouteUtil.redirect(PagesMap.page.movement.manage)
        }
    }
}
