<template>
    <div class="container">
        <table class="table table-bordered my-3">
            <thead>
                <tr>
                    <th scope="col" class="d-none">id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Website</th>
                    <th scope="col">Actions</th>
                    <!-- <th scope="col">Delete</th> -->
                </tr>
            </thead>
            <tbody>
                <template v-for="account in accounts">
                    <ShowAccountComponent :account="account" :ref="`showAccount_${account.id}`"></ShowAccountComponent>
                    <EditAccountComponent :account="account" :ref="`editAccount_${account.id}`"></EditAccountComponent>
                </template>
                <CreateAccountComponent ref="createAccount"></CreateAccountComponent>
            </tbody>
        </table>
        <div><a href="#" @click.prevent="OpenAddLine(1)" class="btn btn-success">Add Account</a></div>
    </div>
</template>

<script>
import CreateAccountComponent from "./CreateAccountComponent.vue";
import EditAccountComponent from "./EditAccountComponent.vue";
import ShowAccountComponent from "./ShowAccountComponent.vue";
// import Swal from 'sweetalert2';
export default {
    name: "AccountsComponent",

    data() {
        return {
            accounts: null,
            editAccountId: null,
            Account_Name: null,
            Phone: null,
            Website: null,
            errors: null,
        }
    },

    mounted() {
        this.getAccounts();
        // this.$swal('Hello Vue world!!!');
    },

    methods: {
        getAccounts() {
            axios.get('/api/accounts')
                .then(data => {
                    // console.log(data.data);
                    this.accounts = data.data.data;
                })
                .catch(error => {
                    // console.log(error.response.data.message);
                    this.$parent.$parent.showIssue(error.response.data.message);
                })
        },

        OpenAddLine(id) {
            this.$refs.createAccount.AddId = id;
            this.editAccountId = null;
            this.errors = null;
        },

        isAddAccount() {
            // console.log(this.$refs);
            return this.$refs.createAccount.AddId;
        },

        isEdit(id) {
            return this.editAccountId === id;
        },

        deleteAlertClick(id) {
            this.$swal({
                title: 'Are you sure?',
                text: "Any associated lists will also be Deleted",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/api/account/${id}`)
                        .then(data => {
                            this.$swal(
                                'Deleted!',
                                'Account has been deleted.',
                                'success'
                            )
                            // console.log(data.data);
                            this.getAccounts();
                        })
                        .catch(error => {
                            // console.log(error);
                            this.$parent.$parent.showIssue(error.response.data.message);
                        })
                }
            });
        },
    },
    components: {
        CreateAccountComponent,
        EditAccountComponent,
        ShowAccountComponent
    }
}
</script>

<style scoped></style>
