import {appAlert} from "~/composables/alert/alert";
import {useTheme} from "~/composables/theme/use.theme";

export const alertApi = {
    ask: async (title: string, text: string, iconColor: null|string, confirmColor: null|string, callback: () => Promise<boolean>): Promise<void> => {
        const { $swal } = useNuxtApp()
        const { currentTheme } = useTheme()
        const result = await $swal.fire({
            title: title,
            text: text,
            icon: 'question',
            iconColor: iconColor ?? currentTheme.value.primaryColorHex,
            confirmButtonColor: confirmColor ?? currentTheme.value.primaryColorHex,
            confirmButtonText: 'Sim, continuar',
            cancelButtonText: "Cancelar",
            showCancelButton: true,
        });
        if (result.isConfirmed) {
            await alertApi._callbackAction(callback)
        } else {
            await appAlert.error("Cancelado", "Ação Cancelada");
        }
    },
    askDoubleCallback: async (
        title: string,
        text: string,
        confirmText: string,
        denyText: string,
        disableDenyButton: boolean,
        callbackConfirm: () => Promise<boolean>,
        callbackDeny: () => Promise<boolean>,
        closeAfterClick: boolean = false
    ): Promise<void> => {
        const { $swal } = useNuxtApp()
        const { currentTheme } = useTheme()
        await $swal.fire({
            title: title,
            text: text,
            icon: 'question',
            iconColor: currentTheme.value.primaryColorHex,
            confirmButtonColor: currentTheme.value.primaryColorHex,
            confirmButtonText: confirmText,
            denyButtonColor: currentTheme.value.primaryColorHex,
            denyButtonText: denyText,
            showCancelButton: false,
            showDenyButton: true,
            showCloseButton: true,
            preConfirm: async (): Promise<boolean> => {
                await alertApi._callbackAction(callbackConfirm, false)
                return closeAfterClick
            },
            preDeny: async () : Promise<boolean> => {
                await alertApi._callbackAction(callbackDeny, false)
                return closeAfterClick
            },
            didOpen: (): void => {
                const denyButton = $swal.getDenyButton()
                if (denyButton) {
                    denyButton.disabled = disableDenyButton
                }
            }
        });
    },
    askDelete: async (callback: () => Promise<boolean>): Promise<void> => {
        return await alertApi.ask(
            'Deseja realmente deletar esse ítem?',
            'Uma vez deletado, não é possível recuperar esse ítem.',
            '#dc2a2a',
            '#dc2a2a',
            callback
        );
    },
    _callbackAction: async (callback: () => Promise<boolean>, showSuccess: boolean = true): Promise<void> => {
        try {
            if (await callback()) {
                if (showSuccess) {
                    await appAlert.success('Sucesso!', 'Ação executada com sucesso!')
                }
            }
        } catch {
            await appAlert.error("Erro", "Ocorreu um erro ao executar essa ação!");
        }
    }
}
