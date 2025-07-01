import BaseService from "~/utils/service/base.service";
import type {ExpenseSchemaType} from "~/modules/expensse/expense.schema";
import {ExpenseTypeEnum} from "~/modules/expensse/expense.type.enum";
import {DateUtil} from "~/utils/date/date.util";
import type {FormSubmitEvent} from "@nuxt/ui";
import {HttpStatusCode} from "axios";
import {RouteUtil} from "~/utils/route/route.util";
import type {IServiceList} from "~/utils/interface/service.list.interface";
import type {IApiListResponseInterface} from "~/plugins/router/api.list.response.interface";
import type {ExpenseItem} from "~/modules/expensse/expense.item.interface";
import type {ExpensePaySchemaType} from "~/modules/expensse/expense.pay.schema";

export class ExpenseService extends BaseService implements IServiceList<ExpenseItem> {
    constructor() {
        super();
    }

    public async get(id: number): Promise<ExpenseItem> {
        const item = await this.api.expense.get(id)
        return item.data
    }

    public async list(page: number, perPage: number, search: string, orderBy: string, order: string, filters: string): Promise<IApiListResponseInterface<ExpenseItem>> {
        return this.api.expense.list(page, perPage, search, orderBy, order, filters)
    }

    public makeState(): ExpenseSchemaType {
        return {
            amount: 0,
            type: ExpenseTypeEnum.oneTime,
            dateStart: DateUtil.nextMonthDateStart(DateUtil.getTodayIso8601Format()),
            description: '',
            installments: 1,
            variable: false,
            observations: null,
        }
    }

    public async create(event: FormSubmitEvent<ExpenseSchemaType>): Promise<void> {
        const result = await this.api.expense.create(event.data)
        if (result.status === HttpStatusCode.Created) {
            this.notify.success(`Despesa criada com sucesso!`)
            RouteUtil.redirect(PagesMap.page.expense.manage)
        }
    }

    public makePayState(): ExpensePaySchemaType {
        return {
            amount: 0,
            installmentId: 0,
            walletId: 0,
            expenseId: 0,
            bankSlip: null
        }
    }

    public async pay(data: ExpensePaySchemaType): Promise<void> {
        const result = await this.api.expense.pay(data)
        if (result.status === HttpStatusCode.Created) {
            this.notify.success(`Despesa paga com sucesso!`)
        }
    }
}
