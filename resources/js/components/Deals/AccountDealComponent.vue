<template>
    <template v-for="account in this.$parent.$parent.accounts">
        <option :value="account.id">{{ account.Account_Name }}</option>
    </template>
</template>

<script>
export default {
    name: "AccountDealComponent",

    data() {
        return {
            
        }
    },

    mounted() {
    },

    methods: {

    },
}
</script>
