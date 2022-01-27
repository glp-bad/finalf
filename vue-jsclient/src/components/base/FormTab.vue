<template>
    <div class = 'ff-form-tab'>
        <div class = 'form-content'>
            <slot name='slotContent' ></slot>
        </div>
        <div class = 'form-button'>
            <slot name='slotButton' ></slot>
        </div>
        <div class = 'form-bottom-line'>
        </div>
    </div>

</template>

<script>
    export default {
		name: "my-form-tab",
        components:{
        },
        props: {
        },
		directives: {},
        created() {

        },
        mounted() {
        },
        methods: {

        },
		data () {
			return {
            }
		}
	}

</script>

<style scoped>
</style>
