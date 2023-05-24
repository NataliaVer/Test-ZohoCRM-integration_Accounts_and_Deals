<template>
    <tr :class="this.$parent.isEdit(deal.id) ? '' : 'd-none'">
        <td scope="row" class="d-none">{{ deal.id }}</td>
        <td>
            <input type="text" v-model="Deal_Name" class="form-control">
            <div class="alert alert-danger" v-if="this.$parent.errors && this.$parent.errors.Deal_Name">{{ this.$parent.errors.Deal_Name }}</div>
        </td>
        <td>
            <select v-model="Stage" class="form-select" id="Stage">
                <StageDealComponent></StageDealComponent>
            </select>
            <div class="alert alert-danger" v-if="this.$parent.errors && this.$parent.errors.Stage">{{ this.$parent.errors.Stage }}</div>
        </td>
            <td>
                <select v-model="Account" class="form-control" id="Account">
                <AccountDealComponent ref="accountDeal"></AccountDealComponent>
            </select>
            <div class="alert alert-danger" v-if="this.$parent.errors && this.$parent.errors.Account">{{ this.$parent.errors.Account }}</div>
        </td>
        <td>
            <a href="#" @click.prevent="updateDeal(deal.id)" class="btn btn-success mx-3">Update</a>
            <a href="#" @click.prevent="hideEditDeal" class="btn btn-secondary">Close</a>
        </td>
    </tr>
</template>

<script>
import StageDealComponent from './StageDealComponent.vue';
import AccountDealComponent from './AccountDealComponent.vue';
export default {
    name: "EditDealComponent",

    props: [
        'deal'
    ],

    data() {
        return {
            Stage: null,
            Deal_Name: null,
            Account: null,
        }
    },

    mounted() {
    },

    methods: {

        updateDeal(id) {
            axios.put(`/api/deal/${id}`, { Deal_Name: this.Deal_Name, Stage: this.Stage, Account: this.Account })
                .then(data => {
                    // console.log(data.data);
                    this.$parent.editDealId = null;
                    this.$parent.$parent.$parent.showSaccess();
                    this.$parent.getDeals();
                })
                .catch(error => {
                    // console.log(error.response.data.errors);
                    this.$parent.errors = error.response.data.errors;
                    // console.log(this.$parent.errors);
                });
        },

        hideEditDeal() {
            // console.log(id);
            this.$parent.editDealId = null;
        },

    },
    components: {
        StageDealComponent,
        AccountDealComponent
    }
}
</script>

<style scoped></style>
