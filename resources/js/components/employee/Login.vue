<template>
    <div>
        <div class="card">
            <div class="card-header">Identificação</div>

            <div class="card-body">
                <form onsubmit="return false">
                    <div class="form-group row">
                        <label
                            for="email"
                            class="col-md-4 col-form-label text-md-right"
                            >Seu nome</label
                        >

                        <div class="col-md-6">
                            <input
                                id="name"
                                type="text"
                                class="form-control"
                                name="name"
                                autofocus
                                v-model="employee.name"
                            />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label
                            for="password"
                            class="col-md-4 col-form-label text-md-right"
                            >Código</label
                        >

                        <div class="col-md-6">
                            <input
                                id="code"
                                type="text"
                                class="form-control"
                                name="code"
                                v-model="employee.code"
                            />
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button
                                type="submit"
                                class="btn btn-primary"
                                @click="saveEmployee()"
                            >
                                Entrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            employee: { name: "", code: "" }
        };
    },
    methods: {
        saveEmployee: function() {
            if (this.employee.name == "" || this.employee.code == "") {
                Swal.fire({
                    title: "Atenção!",
                    text: "Preencha todos os campos",
                    icon: "warning",
                    confirmButtonText: "OK"
                });
                return false;
            }
            localStorage.employee = JSON.stringify(this.employee);
            this.$root.$emit("refreshEmployee");
        }
    }
};
</script>

<style></style>
