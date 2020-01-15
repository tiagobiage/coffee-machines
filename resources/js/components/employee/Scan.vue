<template>
    <div>
        <div v-if="!hasCamera" class="alert alert-danger">
            Nenhuma camera foi encontrada {{ error }}
        </div>
        <div v-else>{{ contentScan }}</div>
        <video
            controls
            style="border: 1px solid rgb(14, 168, 234); width: 90%;"
        ></video>
        <button @click="activeCamera">camera</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            hasCamera: true,
            contentScan: null
        };
    },
    mounted() {},
    methods: {
        activeCamera: function() {
            try {
                navigator.mediaDevices
                    .getUserMedia({ video: true })
                    .then(function(stream) {
                        alert(stream);
                    })
                    .catch(function(err) {
                        alert(err);
                    });
            } catch (error) {
                alert(error);
            }
        },
        onInit: async function(promise) {
            try {
                await promise;
            } catch (error) {
                this.hasCamera = false;
                if (error.name === "NotAllowedError") {
                    this.error =
                        "ERROR: you need to grant camera access permisson";
                } else if (error.name === "NotFoundError") {
                    this.error = "ERROR: no camera on this device";
                } else if (error.name === "NotSupportedError") {
                    this.error =
                        "ERROR: secure context required (HTTPS, localhost)";
                } else if (error.name === "NotReadableError") {
                    this.error = "ERROR: is the camera already in use?";
                } else if (error.name === "OverconstrainedError") {
                    this.error = "ERROR: installed cameras are not suitable";
                } else if (error.name === "StreamApiNotSupportedError") {
                    this.error =
                        "ERROR: Stream API is not supported in this browser";
                }
            }
        },
        onDecode: function(decodedString) {
            var _this = this;
            console.log(decodedString);
        }
    }
};
</script>

<style></style>
