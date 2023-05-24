<template>
    <tr :class="isAdd(AddId) ? '' : 'd-none'">
        <td>
            <input type="text" v-model="Deal_Name" class="form-control" id="Deal_Name">
            <div class="alert alert-danger" v-if="this.$parent.errors && this.$parent.errors.Deal_Name">{{
                this.$parent.errors.Deal_Name }}</div>
        </td>
        <td>
            <select v-model="Stage" class="form-select" id="Stage">
                <StageDealComponent></StageDealComponent>
            </select>
            <div class="alert alert-danger" v-if="this.$parent.errors && this.$parent.errors.Stage">{{
                this.$parent.errors.Stage }}</div>
        </td>
        <td>
            <select v-model="Account" class="form-control" id="Account">
                <AccountDealComponent ref="accountDeal"></AccountDealComponent>
            </select>
            <div class="alert alert-danger" v-if="this.$parent.errors && this.$parent.errors.Account">{{
                this.$parent.errors.Account }}</div>
        </td>
        <td>
            <a href="#" @click.prevent="addDeal" class="btn btn-primary mx-3">Add</a>
            <a href="#" @click.prevent="hideAddDeal" class="btn btn-secondary">Close</a>
        </td>
        <!-- <td></td> -->
    </tr>
</template>

<script>
import StageDealComponent from './StageDealComponent.vue';
import AccountDealComponent from './AccountDealComponent.vue'

export default {
    name: "DealsComponent",

    data() {
        return {
            Stage: null,
            Deal_Name: null,
            Account: null,
            AddId: null,
            accounts: null,
        }
    },

    mounted() {
    },

    methods: {
        addDeal() {
            axios.post('/api/deal', { Stage: this.Stage, Deal_Name: this.Deal_Name, Account: this.Account })
                .then(res => {
                    this.$parent.$parent.$parent.showSaccessAdd();
                    // console.log(res);
                    this.AddId = null;
                    this.Deal_Name = null;
                    this.Stage = null;
                    this.Account = null;
                    this.$parent.getDeals();
                })
                .catch(error => {
                    // console.log(error.response.data.errors);
                    this.$parent.errors = error.response.data.errors;
                });;
        },

        isAdd(id) {
            return this.AddId === 1;
        },
        hideAddDeal() {
            this.AddId = null;
        }
    },

    components: {
        StageDealComponent,
        AccountDealComponent
    }
}
</script>
