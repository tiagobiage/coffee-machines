<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ coffeeMachine.description }}

                    <div class="alert alert-warning" v-if="timeOrder > 0">
                        {{ timeOrder }} segundos
                    </div>
                </div>
                <div class="card-body">
                    <h3 v-if="coffees.length == 0">Passe seu crachá</h3>
                    <div class="form-group" v-else-if="showRate == false">
                        <h3>
                            {{ employee.name }} Coloque o copo na máquina e
                            escolha seu café
                        </h3>
                        <div
                            v-for="(coffee, key) in coffees"
                            :key="key"
                            class="item"
                        >
                            <input
                                type="radio"
                                name="coffee"
                                :id="'coffee' + coffee.id"
                                :value="coffee.id"
                                v-model="coffeeId"
                            />
                            <label :for="'coffee' + coffee.id">{{
                                coffee.name
                            }}</label>
                        </div>
                        <button v-if="coffees.length > 0" @click="sendOrder()">
                            Tirar café
                        </button>
                    </div>

                    <div class="form-group" v-if="showRate == true">
                        <h3>Avalie o café</h3>
                        <div
                            v-for="(vote, index) in 5"
                            :key="index"
                            class="item"
                        >
                            <input
                                type="radio"
                                name="vote"
                                :id="'vote' + index"
                                :value="index + 1"
                                v-model="rate"
                            />
                            <label :for="'vote' + index">{{ index + 1 }}</label>
                        </div>
                        <button @click="sendRate()">
                            Avaliar
                        </button>
                    </div>

                    <div class="alert alert-info" v-if="msg != ''">
                        {{ msg }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
var intervalOrder = null;

export default {
    data() {
        return {
            coffees: [],
            employee: {},
            coffeeMachine: {},
            coffeeId: null,
            showRate: false,
            rate: 0,
            msg: "",
            order: {},
            timeOrder: 0,
            maxTimeOrder: 120
        };
    },
    props: ["idcoffeemachine", "accesscode"],
    mounted: function() {
        var _this = this;
        this.getMachineInfo();
        var channel = Echo.channel("machines");
        channel.listen(".new-event-machine" + this.idcoffeemachine, function(
            data
        ) {
            _this.getCoffees(data);
        });
    },
    methods: {
        getMachineInfo: function() {
            this.axios
                .post(`/api/device/coffeeMachine/${this.idcoffeemachine}`, {
                    accesscode: this.accesscode
                })
                .then(response => {
                    this.coffeeMachine = response.data.coffeeMachine;
                })
                .finally(() => {});
        },
        getCoffees: function(data) {
            console.log(data);
            this.coffees = data.dataSend.coffees;
            this.employee = data.dataSend.employee;
            this.countToFinish(this.maxTimeOrder);
        },
        sendOrder: function() {
            this.axios
                .post(
                    `/api/device/order/${this.employee.id}/${this.idcoffeemachine}/${this.coffeeId}`,
                    {
                        accesscode: this.accesscode
                    }
                )
                .then(response => {
                    this.orderMachine(
                        response.data.order,
                        response.data.coffeeCode
                    );
                    this.msg = "Comunicando com a máquina";
                    this.countToFinish(this.maxTimeOrder);
                })
                .finally(() => {});
        },
        orderMachine: function(order, coffeeCode) {
            this.order = order;
            this.axios
                .get(`${this.coffeeMachine.url}/${coffeeCode}`)
                .then(response => {
                    //console.log(response);
                })
                .finally(() => {
                    this.showRate = true;
                    this.msg = "";
                    this.countToFinish(this.maxTimeOrder);
                });
        },
        sendRate: function() {
            this.axios
                .post(
                    `/api/device/rate/${this.employee.id}/${this.order.id}/${this.coffeeId}/${this.rate}`,
                    {
                        accesscode: this.accesscode,
                        machineId: this.idcoffeemachine
                    }
                )
                .then(response => {
                    clearInterval(intervalOrder);
                    this.timeOrder = 0;
                    this.msg = "Obrigado por avaliar";
                    setTimeout(() => {
                        this.renew();
                    }, 5000);
                })
                .finally(() => {});
        },
        renew: function() {
            this.coffees = [];
            this.employee = {};
            this.coffeeId = null;
            this.showRate = false;
            this.rate = 0;
            this.msg = "";
            this.order = {};
            this.timeOrder = 0;
        },
        countToFinish: function(seconds) {
            clearInterval(intervalOrder);
            console.log(intervalOrder);
            this.timeOrder = seconds;
            intervalOrder = setInterval(() => {
                this.timeOrder--;
                if (this.timeOrder == 0) this.finishOrder();
            }, 1000);
        },
        finishOrder: function() {
            clearInterval(intervalOrder);
            this.axios
                .post(`/api/device/finish-order/${this.order.id}`, {
                    accesscode: this.accesscode,
                    machineId: this.idcoffeemachine
                })
                .then(response => {})
                .finally(() => {
                    this.msg = "Seu tempo acabou, pedido expirado.";
                    setTimeout(() => {
                        this.renew();
                    }, 5000);
                });
        }
    }
};
</script>

<style scoped>
.card-header {
    font-size: 1.5rem;
    font-weight: bold;
}

.card-header .alert {
    float: right;
    font-size: 0.8rem;
    padding: 0.5rem 0.75rem;
    margin: 0;
    font-weight: normal;
}
</style>
