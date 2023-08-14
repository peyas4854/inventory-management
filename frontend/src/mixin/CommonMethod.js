export default {
    data : () => ({

    }),
    methods:{
        numberFormat(value) {
            return Number.parseFloat(value).toFixed(2);
        },
    }
}
