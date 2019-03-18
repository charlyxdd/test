export default class Functions {
    serialize(arr) {
        let res = 'a:' + arr.length + ':{';
        for (let i = 0; i < arr.length; i++) {
            res += 'i:' + i + ';s:' + arr[i].length + ':"' + arr[i] + '";';
        }
        res += '}';

        return res;
    }

    date_format(date, t = false) {
        const y = date.getFullYear();
        const m = (((date.getMonth() + 1).toString().length === 1) ? '0' : '') + (date.getMonth() + 1).toString();
        const d = (date.getDate().toString().length === 1 ? '0' : '') + date.getDate().toString();
        let r = y + '-' + m + '-' + d;
        if (t) {
            r += ' ';
            const h = (date.getHours().toString().length === 1 ? '0' : '') + date.getHours().toString();
            const i = (date.getMinutes().toString().length === 1 ? '0' : '') + date.getMinutes().toString();
            const s = (date.getSeconds().toString().length === 1 ? '0' : '') + date.getSeconds().toString();
            r += h + ':' + i + ':' + s;
        }
        return r;
    }
}