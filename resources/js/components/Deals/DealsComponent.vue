<template>
    <div class="container">
        <table class="table my-3">
            <thead>
                <tr>
                    <th scope="col" class="d-none">id</th>
                    <th scope="col">Deal Name</th>
                    <th scope="col">Stage</th>
                    <th scope="col">Account</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <template v-for="deal in deals">
                    <ShowDealComponent :deal="deal" :ref="`showDeal_${deal.id}`"></ShowDealComponent>
                    <EditDealComponent :deal="deal" :ref="`editDeal_${deal.id}`"></EditDealComponent>
                </template>
                <CreateDealComponent ref="createDeal"></CreateDealComponent>
            </tbody>
        </table>
        <div><a href="#" @click.prevent="OpenAddLine(1)" class="btn btn-success">Add Deal</a></div>
    </div>
</template>

<script>
import CreateDealComponent from './CreateDealComponent.vue';
import EditDealComponent from './EditDealComponent.vue';
import ShowDealComponent from './ShowDealComponent.vue';
export default {
    name: "DealsComponent",

    data() {
        return {
            deals: null,
            editDealId: null,
            accounts: null,
            errors: null,
        }
    },

    mounted() {
        this.getDeals();
        this.getAccounts();
    },

    methods: {
        getDeals() {
            axios.get('/api/deals')
                .then(data => {
                    // console.log(data);
                    this.deals = data.data.data;
                })
                .catch(error => {
                    // console.log(error.response.data.message);
                    this.$parent.$parent.showIssue(error.response.data.message);
                })
        },

        getAccounts() {
            axios.get('/api/accounts')
                .then(data => {
                    this.accounts = data.data.data;
                    // console.log(data.data.data);
                })
                .catch(error => {
                    // console.log(error);
                    this.$parent.$parent.showIssue(error.response.data.message);
                })
        },

        colorTr(stage) {
            if (stage == "Closed Lost" || stage == "Closed-Lost to Competition") {
                return 'table-danger';
            } else if (stage == "Closed Won") {
                return 'table-success';
            } else {
                return 'table-info';
            }
        },

        OpenAddLine(id) {
            this.$refs.createDeal.AddId = id;
            this.editDealId = null;
            this.errors = null;
        },

        deleteDeal(id) {
            this.$swal({
                title: 'Are you sure?',
                text: "Any associated lists will also be Deleted",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/api/deal/${id}`)
                        .then(data => {
                            this.$swal(
                                'Deleted!',
                                'Deal has been deleted.',
                                'success'
                            )
                            // console.log(data.data);
                            this.getDeals();
                        })
                        .catch(error => {
                            // console.log(error);
                            this.$parent.$parent.showIssue(error.response.data.message);
                        })
                }
            });
        },

        isEdit(id) {
            return this.editDealId === id;
        },

    },

    components: {
        CreateDealComponent,
        EditDealComponent,
        ShowDealComponent
    }
}
</script>
