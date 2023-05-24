<template>
    <tr :class="this.$parent.isEdit(account.id) ? 'd-none' : ''">
        <td scope="row" class="d-none">{{ account.id }}</td>
        <td>{{ account.Account_Name }}</td>
        <td>{{ account.Phone }}</td>
        <td>{{ account.Website }}</td>
        <td>
            <a href="#" @click.prevent="changeEditAccountId(account.id, account.Account_Name, account.Phone, account.Website)"
                class="btn btn-success mx-3">Edit</a>
            <a href="#" @click.prevent="this.$parent.deleteAlertClick(account.id)" class="btn btn-danger">Delete</a>
        </td>
        <!-- <td><a href="#" @click.prevent="deleteAccount(account.id)" class="btn btn-danger">Delete</a></td> -->
    </tr>
</template>

<script>
export default {
    name: "ShowAccountComponent",

    props: [
        'account'
    ],

    data() {
        return {
        }
    },

    mounted() {
    },

    methods: {

        changeEditAccountId(id, Account_Name, Phone, Website) {
            // console.log(id);
            this.$parent.editAccountId = id;
            let editName = `editAccount_${id}`;
            let fullEditName = this.$parent.$refs[editName][0];
            fullEditName.Account_Name = Account_Name;
            fullEditName.Phone = Phone;
            fullEditName.Website = Website;
            this.$parent.errors = null;
            this.$parent.$refs.createAccount.AddId = null;
        },

    },
    components: {

    }
}
</script>

<style scoped>

</style>
