<template>
    <tr :class="this.$parent.colorTr(deal.Stage)">
        <td scope="row" class="d-none">{{ deal.id }}</td>
        <td>{{ deal.Deal_Name }}</td>
        <td>{{ deal.Stage }}</td>
        <td>{{ deal.Account_Name.name }}</td>
        <td>
            <a href="#" @click.prevent="changeEditDealId(deal.id, deal.Deal_Name, deal.Stage, deal.Account_Name.id)"
                class="btn btn-success mx-3">Edit</a>
            <a href="#" @click.prevent="this.$parent.deleteDeal(deal.id)" class="btn btn-danger">Delete</a>
        </td>
    </tr>
</template>

<script>
export default {
    name: "ShowDealComponent",

    props: [
        'deal'
    ],

    data() {
        return {
        }
    },

    mounted() {
    },

    methods: {

        changeEditDealId(id, Deal_Name, Stage, Account) {
            // console.log(id);
            this.$parent.editDealId = id;
            let editName = `editDeal_${id}`;
            let fullEditName = this.$parent.$refs[editName][0];
            fullEditName.Deal_Name = Deal_Name;
            fullEditName.Stage = Stage;
            fullEditName.Account = Account;
            this.$parent.errors = null;
            this.$parent.$refs.createDeal.AddId = null;
        },
    },

    components: {

    }
}
</script>
