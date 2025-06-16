export default class TabsDto {
    public label: string
    public icon?: string
    public slot: string
    public value: string
    public disabled: boolean

    constructor(label: string, slot: string, disabled?: boolean, icon?: string) {
        this.label = label;
        this.slot = slot;
        this.icon = icon;
        this.value = slot;
        this.disabled = disabled || false;
    }
}
