export const StringUtil = {
    capitalizeFirstLetters: function (string: string): string {
        return string.split(' ').map(word => {
            return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
        }).join(' ')
    }
}
