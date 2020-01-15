<template>
    <div>
        <employee-login v-if="employee == null"></employee-login>
        <employee-scan v-else></employee-scan>
    </div>
</template>

<script>
export default {
    data() {
        return {
            logged: false,
            employee: null
        };
    },
    mounted() {
        this.isLogged();
        this.$root.$on("refreshEmployee", () => {
            this.isLogged();
        });
    },
    methods: {
        isLogged: function() {
            if (localStorage.employee) {
                this.employee = JSON.parse(localStorage.employee);
                this.logged = true;
            }
        }
    }
};
</script>

<style></style>
