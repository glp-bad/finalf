
<template>
    <img ref="refImg" :src=this.engine.svgSource>
</template>

<script>
    export default {
        name: "my-icon",
        components: {},
        props: {
            size: {
                type: Number,
                default: 15
            },
            svgIconName: {
                type: String,
                required: true
            }
        },
        created() {
            this.engine.svgSource = require(`../../assets/icons/${this.svgIconName}.svg`);
        },
        mounted() {
            this.$refs.refImg.style.width = this.size + 'px';
        },
        methods: {
        },
        data() {
            return {
                engine: {
                    svgSource: null
                }
            }
        }
    }
</script>

<style scoped></style>
