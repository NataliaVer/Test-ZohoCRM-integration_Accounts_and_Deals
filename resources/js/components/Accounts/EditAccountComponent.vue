<template>
    <tr :class="this.$parent.isEdit(account.id) ? '' : 'd-none'">
        <td scope="row" class="d-none">{{ account.id }}</td>
        <td>
            <input type="text" v-model="Account_Name" class="form-control">
            <div class="alert alert-danger" v-if="this.$parent.errors && this.$parent.errors.Account_Name">{{ this.$parent.errors.Account_Name }}</div>
        </td>
        <td>
            <input type="text" v-model="Phone" class="form-control">
            <div class="alert alert-danger" v-if="this.$parent.errors && this.$parent.errors.Phone">{{ this.$parent.errors.Phone }}</div>
        </td>
        <td>
            <input type="text" v-model="Website" class="form-control">
            <div class="alert alert-danger" v-if="this.$parent.errors && this.$parent.errors.Website">{{ this.$parent.errors.Website }}</div>
        </td>
        <td>
            <a href="#" @click.prevent="updateAccount(account.id)" class="btn btn-success mx-3">Update</a>
            <a href="#" @click.prevent="hideEditAccount" class="btn btn-secondary">Close</a>
        </td>
    </tr>
</template>

<script>
export default {
    name: "EditAccountComponent",

    props: [
        'account'
    ],

    data() {
        return {
            Account_Name: null,
            Phone: null,
            Website: null,
        }
    },

    mounted() {
    },

    methods: {

        updateAccount(id) {
            
            axios.put(`/api/account/${id}`, { Account_Name: this.Account_Name, Website: this.Website, Phone: this.Phone })
                .then(data => {
                    this.$parent.editAccountId = null;
                    this.$parent.$parent.$parent.showSaccess();
                    // console.log(data.data);
                    this.$parent.getAccounts();
                })
                .catch(error => {
                    console.log(error);
                    this.$parent.errors = error.response.data.errors;
                    // console.log(this.$parent.errors);
                });
        },
        hideEditAccount() {
            // console.log(id);
            this.$parent.editAccountId = null;
        },

    },
    components: {
    }
}
</script>

<style scoped></style>
