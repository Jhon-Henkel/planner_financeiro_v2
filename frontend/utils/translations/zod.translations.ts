import { ZodIssueCode } from 'zod';

export const translate = (issue: any, ctx: any) => {
    if (issue.code === ZodIssueCode.too_small) {
        if (issue.minimum === 1 || issue.minimum === 0.01) {
            return { message: 'Campo obrigatório' };
        }
        if (issue.type === 'string') {
            return { message: `Valor muito pequeno, deve conter mais de ${issue.minimum} caracteres` };
        }
        return { message: `Valor muito pequeno, o mínimo aceito é ${issue.minimum}` };
    }

    if (issue.code === ZodIssueCode.too_big) {
        if (issue.type === 'string') {
            return { message: `Valor muito grande, deve conter menos de ${issue.maximum} caracteres` };
        }
        return { message: `Valor muito grande, o máximo aceito é ${issue.maximum}` };
    }

    const translations: Record<string, string> = {
        [ZodIssueCode.invalid_type]: `Tipo inválido`,
        [ZodIssueCode.invalid_enum_value]: `Valor inválido`,
        [ZodIssueCode.invalid_date]: `Data inválida`,
    };

    const message = translations[issue.code] || ctx.defaultError;
    return { message };
};

