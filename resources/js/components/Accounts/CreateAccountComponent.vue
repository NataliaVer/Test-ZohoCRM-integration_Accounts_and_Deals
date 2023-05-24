<template>
    <tr :class="isAdd(AddId) ? '' : 'd-none'">
        <td>
            <input type="text" v-model="Account_name" class="form-control" id="Account_name" placeholder="King (Sample)">
            <div class="alert alert-danger" v-if="this.$parent.errors && this.$parent.errors.Account_name">{{ this.$parent.errors.Account_name }}</div>
        </td>
        <td>
            <input type="text" v-model="Phone" class="form-control" id="Phone" placeholder="555-555-555">
            <div class="alert alert-danger" v-if="this.$parent.errors && this.$parent.errors.Phone">{{ this.$parent.errors.Phone }}</div>
        </td>
        <td>
            <input type="text" v-model="Website" class="form-control" id="Website" placeholder="http://example.com">
            <div class="alert alert-danger" v-if="this.$parent.errors && this.$parent.errors.Website">{{ this.$parent.errors.Website }}</div>
        </td>
        <td>
            <a href="#" @click.prevent="addAccount" class="btn btn-primary mx-3">Add</a>
            <a href="#" @click.prevent="hideAddAccount" class="btn btn-secondary">Close</a>
        </td>
    </tr>
</template>

<script>
export default {
    name: "CreateAccountComponent",

    data() {
        return {
            Account_name: null,
            Website: null,
            Phone: null,
            AddId: null,

        }
    },

    mounted() {

    },

    methods: {
        addAccount() {
            axios.post('/api/account', { Account_name: this.Account_name, Website: this.Website, Phone: this.Phone })
                .then(res => {
                    this.$parent.$parent.$parent.showSaccessAdd();

                    this.AddId = null;
                    this.Account_name = null;
                    this.Website = null;
                    this.Phone = null;
                    this.$parent.getAccounts();
                })
                .catch(error => {
                            // console.log(error.response.data.errors);
                            this.$parent.errors = error.response.data.errors;
                        });
        },

        hideAddAccount() {
            // console.log(id);
            this.AddId = null;
        },

        isAdd(id) {
            return this.AddId === 1;
        }
    },
}
</script>

<style scoped></style>
