import BaseService from "~/utils/service/base.service";
import type {ExpenseSchemaType} from "~/modules/expensse/expense.schema";
import {ExpenseTypeEnum} from "~/modules/expensse/expense.type.enum";
import {DateUtil} from "~/utils/date/date.util";
import type {FormSubmitEvent} from "@nuxt/ui";
import {HttpStatusCode} from "axios";
import {RouteUtil} from "~/utils/route/route.util";

export class ExpenseService extends BaseService {
    constructor() {
        super();
    }

    public makeState(): ExpenseSchemaType {
        return {
            amount: 0,
            type: ExpenseTypeEnum.oneTime,
            dateStart: DateUtil.nextMonth(DateUtil.getTodayIso8601Format()),
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
}
